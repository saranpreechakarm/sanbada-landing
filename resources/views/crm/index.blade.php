@extends('crm.layout')
@section('content')
<section class="card">
<h2>ลูกค้า {{ number_format($customers->total()) }} ราย</h2>
<p class="muted">เรียงจากวันที่ลูกค้าทักล่าสุด · วันที่เริ่มบันทึกนับจากเหตุการณ์ที่ระบบได้รับ ไม่ใช่วันเริ่มเป็นลูกค้าจริง · เวลาไทย</p>
<form class="filters" method="get" action="{{ route('crm.index') }}">
<div><label for="q">ค้นหาลูกค้า</label><input id="q" name="q" value="{{ request('q') }}" placeholder="ชื่อ รหัสลูกค้า เบอร์ หรือเซลล์"></div>
<div><label for="status">สถานะ</label><select id="status" name="status"><option value="">ทุกสถานะ</option>@foreach(\App\Models\LineCustomer::STATUSES as $key => $label)<option value="{{ $key }}" @selected(request('status') === $key)>{{ $label }}</option>@endforeach</select></div>
<button>ค้นหา</button><a href="{{ route('crm.index') }}">ล้างตัวกรอง</a>
</form>
</section>
<section class="card">
@if($customers->isEmpty())
<h2>ยังไม่มีลูกค้าในรายการนี้</h2><p class="muted">เมื่อเชื่อม LINE สำเร็จ ลูกค้าที่ทักมาจะปรากฏที่นี่ หากเลือกตัวกรองอยู่ ให้ลองล้างตัวกรอง</p>
@else
<div class="scroll"><table>
<thead><tr><th>ลูกค้า / ชื่อ LINE</th><th>วันที่</th><th>ชื่อเรียก</th><th>เบอร์โทร</th><th>เซลล์ผู้ดูแล</th><th>สถานะ</th><th>บันทึก</th></tr></thead>
<tbody>
@foreach($customers as $customer)
<tr>
<td><div class="code">{{ $customer->customer_code }}</div><div class="name">{{ $customer->display_name ?? 'รอดึงชื่อ LINE' }}</div></td>
<td class="date">เริ่ม {{ $customer->first_contact_at->timezone('Asia/Bangkok')->format('d/m/Y H:i') }}<br>ล่าสุด {{ $customer->last_contact_at->timezone('Asia/Bangkok')->format('d/m/Y H:i') }}</td>
<td><input form="customer-{{ $customer->id }}" aria-label="ชื่อเรียก {{ $customer->customer_code }}" name="nickname" maxlength="255" value="{{ $customer->nickname }}" placeholder="ใช้ชื่อ LINE ได้"></td>
<td><input form="customer-{{ $customer->id }}" aria-label="เบอร์โทร {{ $customer->customer_code }}" name="phone" maxlength="40" value="{{ $customer->phone }}" placeholder="ถ้ามี"></td>
<td><select form="customer-{{ $customer->id }}" aria-label="เซลล์ {{ $customer->customer_code }}" name="sales_owner">
<option value="">ยังไม่มอบหมาย</option>
@foreach(['สโรชา', 'จี้เจี้ยบ', 'สุภาพร', 'อิศรา'] as $salesOwner)
<option value="{{ $salesOwner }}" @selected($customer->sales_owner === $salesOwner)>{{ $loop->iteration }}. {{ $salesOwner }}</option>
@endforeach
@if($customer->sales_owner && !in_array($customer->sales_owner, ['สโรชา', 'จี้เจี้ยบ', 'สุภาพร', 'อิศรา'], true))
<option value="{{ $customer->sales_owner }}" selected>{{ $customer->sales_owner }} (เดิม)</option>
@endif
</select></td>
<td><select form="customer-{{ $customer->id }}" aria-label="สถานะ {{ $customer->customer_code }}" name="status">@foreach(\App\Models\LineCustomer::STATUSES as $key => $label)<option value="{{ $key }}" @selected($customer->status === $key)>{{ $label }}</option>@endforeach</select></td>
<td><form id="customer-{{ $customer->id }}" method="post" action="{{ route('crm.update', $customer) }}">@csrf @method('PATCH')<button aria-label="บันทึก {{ $customer->customer_code }}">บันทึก</button></form></td>
</tr>
@endforeach
</tbody></table></div>
<nav class="pager" aria-label="หน้ารายชื่อลูกค้า">@if($customers->previousPageUrl())<a href="{{ $customers->previousPageUrl() }}">ก่อนหน้า</a>@endif<span>หน้า {{ $customers->currentPage() }} / {{ $customers->lastPage() }}</span>@if($customers->nextPageUrl())<a href="{{ $customers->nextPageUrl() }}">ถัดไป</a>@endif</nav>
@endif
</section>
@endsection
