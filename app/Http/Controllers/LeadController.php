<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLeadRequest;
use App\Models\Lead;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LeadController extends Controller
{
    public function store(StoreLeadRequest $request)
    {
        $data = $request->validated();
        $data['whatsapp_phone'] = preg_replace('/\s+/', '', $data['whatsapp_phone']);
        $file = $data['pdf'] ?? '';
        $query = Project::where('is_published', true);
        $project = !empty($data['project_id']) ? (clone $query)->find($data['project_id']) : null;
        if (!$project && !empty($data['project'])) $project = (clone $query)->where('title', $data['project'])->first();
        if (!$project && $file) $project = (clone $query)->where('pdf_path', $file)->first();
        $file = $project?->pdf_path;
        Lead::create([
            ...collect($data)->only(['whatsapp_country','whatsapp_phone','email','name','consent','utm_source','utm_medium','utm_campaign','utm_content','utm_term','purpose','budget_range','preferred_area'])->all(),
            'source' => 'website', 'status' => 'new', 'locale' => app()->getLocale(),
            'project_id' => $project?->id, 'project_name' => $project?->title, 'project_category' => $project?->category,
            'phone_normalized' => Lead::normalizePhone($data['whatsapp_country'], $data['whatsapp_phone']),
        ]);
        return redirect()->route('thankyou', array_filter([
            'locale' => app()->getLocale(), 'file' => $file,
            'project' => $file ? $project?->title : null,
        ]));
    }

    public function downloadPdf(Request $request)
    {
        $file = $request->query('file', '');
        abort_unless(is_string($file) && $file !== '' && Project::where('is_published', true)->where('pdf_path', $file)->exists(), 404);
        if (str_starts_with($file, 'assets/projects/pdf/')) {
            $root = realpath(public_path('assets/projects/pdf'));
            $path = realpath(public_path($file));
        } elseif (str_starts_with($file, 'content/brochures/')) {
            $root = realpath(Storage::disk('content_documents')->path('brochures'));
            $path = realpath(Storage::disk('content_documents')->path(substr($file, strlen('content/'))));
        } else {
            abort(404);
        }
        abort_unless($root && $path && str_starts_with($path, $root.DIRECTORY_SEPARATOR) && is_file($path) && strtolower(pathinfo($path, PATHINFO_EXTENSION)) === 'pdf', 404);
        return response()->download($path, basename($path), ['Content-Type' => 'application/pdf', 'X-Content-Type-Options' => 'nosniff']);
    }
}
