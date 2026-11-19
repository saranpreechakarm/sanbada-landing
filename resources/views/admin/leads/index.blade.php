@extends('admin.layout')
@section('title', 'Leads / ลูกค้าที่สนใจ')
@section('content')
<div class="page-heading"><div><div class="eyebrow">CUSTOMER INQUIRIES</div><h1>Leads / ลูกค้าที่สนใจ</h1><p class="muted">คำขอจากแบบฟอร์มบนเว็บไซต์ ค้นหาและติดตามลูกค้าได้จากที่นี่</p></div><div class="heading-actions"><a class="button" href="{{ route('admin.leads.dashboard') }}">แดชบอร์ดลูกค้า ↗</a><a class="button primary" href="{{ route('admin.leads.export', request()->query()) }}">ดาวน์โหลด CSV</a></div></div>
<form method="get" class="panel lead-filters">
    <label class="span-2">ค้นหาลูกค้า<input name="q" value="{{ request('q') }}" maxlength="100" placeholder="ชื่อ เบอร์ อีเมล โครงการ หรือผู้ดูแล"></label>
    <label>สถานะ<select name="status"><option value="">ทุกสถานะ</option>@foreach(\App\Models\Lead::STATUSES as $value => $label)<option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>@endforeach</select></label>
    <label>โครงการ<select name="project_id"><option value="">ทุกโครงการ</option>@foreach($projects as $project)<option value="{{ $project->id }}" @selected(request('project_id') == $project->id)>{{ $project->title }}</option>@endforeach</select></label>
    <label>ตั้งแต่วันที่ (ไทย)<input type="date" name="from" value="{{ request('from') }}"></label><label>ถึงวันที่ (ไทย)<input type="date" name="to" value="{{ request('to') }}"></label>
    <label>ภาษา<select name="locale"><option value="">ทุกภาษา</option>@foreach(['en' => 'English','ru' => 'Русский','unknown' => 'ไม่ระบุ / ข้อมูลเดิม'] as $value => $label)<option value="{{ $value }}" @selected(request('locale') === $value)>{{ $label }}</option>@endforeach</select></label>
    <label>แหล่งที่มา<select name="source"><option value="">ทุกแหล่งที่มา</option>@foreach($sources as $source)<option value="{{ $source }}" @selected(request('source') === $source)>{{ $source }}</option>@endforeach</select></label>
    <div class="filter-actions"><label class="check"><input type="checkbox" name="due" value="1" @checked(request()->boolean('due'))>ถึงกำหนดติดตาม</label><button class="button primary">ค้นหา</button><a href="{{ route('admin.leads.index') }}">ล้างตัวกรอง</a></div>
    @if(request('campaign'))<input type="hidden" name="campaign" value="{{ request('campaign') }}"><p class="hint">แคมเปญ: {{ request('campaign') }}</p>@endif
</form>
<div class="panel lead-results"><div class="panel-heading"><h2>พบ {{ number_format($leads->total()) }} รายการ</h2><span class="hint">เรียงจากคำขอล่าสุด</span></div>
    <div class="lead-table-heading"><span>ลูกค้า</span><span>โครงการ / แหล่งที่มา</span><span>วันที่ / ผู้ดูแล</span><span>สถานะ</span><span></span></div>
    @forelse($leads as $lead)
        <article class="lead-row">
            <div class="lead-contact"><a href="{{ route('admin.leads.show', $lead) }}"><strong>{{ $lead->name ?: 'ไม่ระบุชื่อ' }}</strong></a><small>{{ $lead->phone_normalized ?: $lead->whatsapp_country.' '.$lead->whatsapp_phone }}</small>@if($lead->email)<small>{{ $lead->email }}</small>@endif<span class="hint">#{{ $lead->id }}</span></div>
            <div><strong class="lead-project">{{ $lead->project_name ?: 'ไม่ระบุโครงการ / ข้อมูลเดิม' }}</strong><small>{{ $lead->utm_source ?: ($lead->source ?: 'ไม่ระบุแหล่งที่มา') }}@if($lead->utm_campaign) · {{ $lead->utm_campaign }}@endif</small><span class="pill">{{ $lead->locale ? strtoupper($lead->locale) : 'ไม่ระบุภาษา' }}</span></div>
            <div><span>{{ $lead->created_at?->timezone('Asia/Bangkok')->format('d/m/Y H:i') ?: 'ไม่ระบุเวลา' }}</span><small>{{ $lead->sales_owner ?: 'ยังไม่ระบุผู้ดูแล' }}</small>@if($lead->next_follow_up_at)<small class="{{ $lead->next_follow_up_at->isPast() && !in_array($lead->status, ['won','lost']) ? 'followup-due' : '' }}">ติดตาม {{ $lead->next_follow_up_at->timezone('Asia/Bangkok')->format('d/m H:i') }}</small>@endif</div>
            <div><span class="pill lead-status-{{ array_key_exists($lead->status, \App\Models\Lead::STATUSES) ? $lead->status : 'unknown' }}">{{ \App\Models\Lead::STATUSES[$lead->status] ?? $lead->status }}</span></div>
            <a class="button small" href="{{ route('admin.leads.show', $lead) }}">ดู / ติดตาม ↗</a>
        </article>
    @empty<div class="empty"><h2>ยังไม่มีรายการที่ตรงกับตัวกรอง</h2><p>เมื่อมีลูกค้าส่งแบบฟอร์ม รายการจะแสดงที่นี่</p><a href="{{ route('admin.leads.index') }}">ดู Leads ทั้งหมด</a></div>@endforelse
</div><div class="pagination">{{ $leads->links() }}</div>
<p class="hint">หนึ่งรายการคือหนึ่งคำขอ เบอร์เดียวกันอาจส่งหลายครั้ง ข้อมูลโครงการ ภาษา และ UTM จะเริ่มเก็บจากฟอร์มเวอร์ชันนี้</p>
@endsection
