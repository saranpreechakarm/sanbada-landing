<?php

namespace App\Services;

use App\Models\Lead;
use Carbon\CarbonImmutable;

class LeadAnalytics
{
    public function overview(): array
    {
        $today = CarbonImmutable::now('Asia/Bangkok')->startOfDay()->setTimezone(config('app.timezone', 'UTC'));
        return [
            'total' => Lead::count(),
            'today' => Lead::where('created_at', '>=', $today)->count(),
            'new' => Lead::where('status', 'new')->count(),
            'followups' => Lead::whereNotIn('status', ['won', 'lost'])->where('next_follow_up_at', '<=', now())->count(),
        ];
    }

    public function report(int $days): array
    {
        $start = CarbonImmutable::now('Asia/Bangkok')->startOfDay()->subDays($days - 1);
        $end = CarbonImmutable::now('Asia/Bangkok')->endOfDay();
        $query = Lead::whereBetween('created_at', [$start->setTimezone(config('app.timezone', 'UTC')), $end->setTimezone(config('app.timezone', 'UTC'))]);
        $total = (clone $query)->count();
        $previous = Lead::whereBetween('created_at', [$start->subDays($days)->setTimezone(config('app.timezone', 'UTC')), $start->subMicrosecond()->setTimezone(config('app.timezone', 'UTC'))])->count();
        $status = (clone $query)->selectRaw('status, COUNT(*) as total')->groupBy('status')->pluck('total', 'status');
        $unique = (clone $query)->whereNotNull('phone_normalized')->distinct()->count('phone_normalized');
        $chart = [];
        for ($day = $start; $day->lte($end); $day = $day->addDay()) $chart[$day->format('Y-m-d')] = 0;
        foreach ((clone $query)->select('id', 'created_at')->cursor() as $lead) {
            $key = $lead->created_at->timezone('Asia/Bangkok')->format('Y-m-d');
            if (isset($chart[$key])) $chart[$key]++;
        }
        return [
            'days' => $days, 'start' => $start, 'end' => $end, 'total' => $total, 'previous' => $previous,
            'change' => $previous ? round(($total - $previous) / $previous * 100, 1) : null,
            'unique' => $unique, 'repeat' => max(0, $total - $unique),
            'won' => (int) ($status['won'] ?? 0), 'conversion' => $total ? round(($status['won'] ?? 0) / $total * 100, 1) : 0,
            'status' => $status, 'chart' => $chart, 'chartMax' => max(1, ...array_values($chart)),
            'projects' => (clone $query)->selectRaw('project_name, COUNT(*) as total')->groupBy('project_name')->orderByDesc('total')->limit(8)->get(),
            'sources' => (clone $query)->selectRaw('COALESCE(utm_source, source) as label, COUNT(*) as total')->groupByRaw('COALESCE(utm_source, source)')->orderByDesc('total')->limit(8)->get(),
            'campaigns' => (clone $query)->whereNotNull('utm_campaign')->selectRaw('utm_campaign as label, COUNT(*) as total')->groupBy('utm_campaign')->orderByDesc('total')->limit(8)->get(),
            'languages' => (clone $query)->selectRaw('locale, COUNT(*) as total')->groupBy('locale')->pluck('total', 'locale'),
            'countries' => (clone $query)->selectRaw('whatsapp_country, COUNT(*) as total')->groupBy('whatsapp_country')->orderByDesc('total')->limit(8)->get(),
        ];
    }
}
