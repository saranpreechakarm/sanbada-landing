@extends('admin.layout')
@section('title', 'สร้างผู้ดูแลคนแรก')
@section('content')
<div class="auth-card"><div class="eyebrow">LET’S GET STARTED</div><h1>สร้างบัญชีผู้ดูแล</h1><p class="muted">ลิงก์นี้ใช้ตั้งค่าครั้งแรก เมื่อสร้างบัญชีแล้วจะปิดอัตโนมัติ</p>
@if($errors->any())<div class="notice error">{{ $errors->first() }}</div>@endif
<form method="post" action="{{ request()->fullUrl() }}" class="stack">@csrf
<label>ชื่อผู้ดูแล<input name="name" value="{{ old('name') }}" required maxlength="100" autocomplete="name"></label>
<label>อีเมล<input type="email" name="email" value="{{ old('email') }}" required autocomplete="username"></label>
<label>รหัสผ่านอย่างน้อย 12 ตัวอักษร<input type="password" name="password" required minlength="12" autocomplete="new-password"></label>
<label>ยืนยันรหัสผ่าน<input type="password" name="password_confirmation" required minlength="12" autocomplete="new-password"></label>
<button class="button primary full">สร้างบัญชีผู้ดูแล →</button>
</form></div>
@endsection
