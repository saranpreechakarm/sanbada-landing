@extends('crm.layout')
@section('content')
<section class="card login">
<h2>ตั้งบัญชีผู้ดูแลครั้งแรก</h2>
<p class="muted">บัญชีนี้ดูและแก้ไขลูกค้า LINE ได้ทั้งหมด ลิงก์จะปิดหลังสร้างบัญชีสำเร็จ</p>
<form method="post" action="{{ request()->fullUrl() }}">
@csrf
<label for="name">ชื่อผู้ดูแล</label><input id="name" name="name" value="{{ old('name') }}" autocomplete="name" maxlength="255" required>
<label for="email">อีเมล</label><input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="username" maxlength="255" required>
<label for="password">รหัสผ่าน (อย่างน้อย 12 ตัวอักษร)</label><input id="password" name="password" type="password" autocomplete="new-password" minlength="12" required>
<label for="password_confirmation">ยืนยันรหัสผ่าน</label><input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" minlength="12" required>
<button>สร้างบัญชีผู้ดูแล</button>
</form>
</section>
@endsection
