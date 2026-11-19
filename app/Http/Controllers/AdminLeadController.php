<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Project;
use App\Services\LeadAnalytics;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminLeadController extends Controller
{
    public function dashboard(Request $request, LeadAnalytics $analytics)
    {
        $data = $request->validate(['days' => ['nullable', Rule::in([7, 30, 90])]]);
        return view('admin.leads.dashboard', ['report' => $analytics->report((int) ($data['days'] ?? 30)), 'overview' => $analytics->overview()]);
    }

    private function filtered(Request $request)
    {
        $filters = $request->validate([
            'q' => 'nullable|string|max:100', 'status' => ['nullable', Rule::in(array_keys(Lead::STATUSES))],
            'project_id' => 'nullable|integer|exists:projects,id', 'locale' => ['nullable', Rule::in(['en', 'ru', 'unknown'])],
            'from' => 'nullable|date_format:Y-m-d', 'to' => ['nullable', 'date_format:Y-m-d', Rule::when($request->filled('from'), 'after_or_equal:from')],
            'source' => 'nullable|string|max:255', 'campaign' => 'nullable|string|max:255', 'due' => 'nullable|boolean',
        ]);
        $query = Lead::query();
        if ($q = $filters['q'] ?? null) {
            $digits = preg_replace('/[^0-9]/', '', $q);
            $query->where(function ($query) use ($q, $digits) {
                foreach (['name','email','whatsapp_phone','project_name','sales_owner'] as $field) $query->orWhere($field, 'like', '%'.$q.'%');
                if (strlen($digits) >= 4) $query->orWhere('phone_normalized', 'like', '%'.$digits.'%');
            });
        }
        foreach (['status','project_id'] as $field) if ($value = $filters[$field] ?? null) $query->where($field, $value);
        if ($locale = $filters['locale'] ?? null) $locale === 'unknown' ? $query->whereNull('locale') : $query->where('locale', $locale);
        if ($from = $filters['from'] ?? null) $query->where('created_at', '>=', CarbonImmutable::parse($from, 'Asia/Bangkok')->startOfDay()->setTimezone(config('app.timezone', 'UTC')));
        if ($to = $filters['to'] ?? null) $query->where('created_at', '<=', CarbonImmutable::parse($to, 'Asia/Bangkok')->endOfDay()->setTimezone(config('app.timezone', 'UTC')));
        if ($source = $filters['source'] ?? null) $query->where(fn ($q) => $q->where('utm_source', $source)->orWhere('source', $source));
        if ($campaign = $filters['campaign'] ?? null) $query->where('utm_campaign', $campaign);
        if ($request->boolean('due')) $query->whereNotIn('status', ['won','lost'])->where('next_follow_up_at', '<=', now());
        return $query;
    }

    public function index(Request $request)
    {
        return view('admin.leads.index', [
            'leads' => $this->filtered($request)->orderByDesc('created_at')->orderByDesc('id')->paginate(20)->withQueryString(),
            'projects' => Project::withTrashed()->orderBy('title')->get(['id', 'title']),
            'sources' => Lead::selectRaw('COALESCE(utm_source, source) as label')->distinct()->orderBy('label')->pluck('label')->filter(),
        ]);
    }

    public function show(Lead $lead)
    {
        $related = Lead::where('phone_normalized', $lead->phone_normalized)->whereKeyNot($lead->id);
        return view('admin.leads.show', ['lead' => $lead, 'repeatCount' => $lead->phone_normalized ? (clone $related)->count() : 0,
            'related' => $lead->phone_normalized ? $related->latest('id')->limit(5)->get() : collect()]);
    }

    public function update(Request $request, Lead $lead)
    {
        $data = $request->validate(['status' => ['required', Rule::in(array_keys(Lead::STATUSES))],
            'sales_owner' => 'nullable|string|max:100', 'notes' => 'nullable|string|max:5000',
            'next_follow_up_at' => 'nullable|date_format:Y-m-d\TH:i']);
        $data['next_follow_up_at'] = !empty($data['next_follow_up_at']) ? CarbonImmutable::createFromFormat('Y-m-d\TH:i', $data['next_follow_up_at'], 'Asia/Bangkok')->setTimezone(config('app.timezone', 'UTC')) : null;
        if (in_array($data['status'], ['contacted','qualified','viewing','won']) && !$lead->contacted_at) $data['contacted_at'] = now();
        $data['closed_at'] = in_array($data['status'], ['won','lost']) ? ($lead->closed_at ?? now()) : null;
        $lead->update($data);
        return back()->with('saved', 'บันทึกสถานะและข้อมูลติดตามลูกค้าแล้ว');
    }

    public function export(Request $request)
    {
        $query = $this->filtered($request)->orderByDesc('id');
        return response()->streamDownload(function () use ($query) {
            $file = fopen('php://output', 'w');
            fwrite($file, "\xEF\xBB\xBF");
            fputcsv($file, ['ID','วันที่ (ไทย)','ชื่อ','WhatsApp','อีเมล','โครงการ','ภาษา','สถานะ','ผู้ดูแล','แหล่งที่มา','UTM Source','UTM Medium','UTM Campaign','UTM Content','UTM Term','ติดตามครั้งถัดไป (ไทย)','บันทึก','เป้าหมาย','งบประมาณ','ทำเลที่สนใจ'], ',', '"', '');
            foreach ($query->cursor() as $lead) {
                $values = [$lead->id, $lead->created_at?->timezone('Asia/Bangkok')->format('Y-m-d H:i'), $lead->name,
                    $lead->phone_normalized, $lead->email, $lead->project_name, $lead->locale, Lead::STATUSES[$lead->status] ?? $lead->status,
                    $lead->sales_owner, $lead->source, $lead->utm_source, $lead->utm_medium, $lead->utm_campaign, $lead->utm_content, $lead->utm_term,
                    $lead->next_follow_up_at?->timezone('Asia/Bangkok')->format('Y-m-d H:i'), $lead->notes,
                    $lead->purpose, $lead->budget_range, $lead->preferred_area];
                $safe = array_map(function ($value) {
                    $text = (string) ($value ?? '');
                    return preg_match('/^[\x00-\x20\x{FEFF}]*[=+@\-]/u', $text) || preg_match('/^[\t\r\n]/', $text) ? "'".$text : $text;
                }, $values);
                fputcsv($file, $safe, ',', '"', '');
            }
            fclose($file);
        }, 'sanbada-leads-'.now('Asia/Bangkok')->format('Ymd-His').'.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
    }
}
