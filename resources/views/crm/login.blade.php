@extends('crm.layout')
@section('content')
<section class="card login">
<h2>เข้าสู่ระบบสำหรับทีมงาน</h2>
<p class="muted">ใช้บัญชีที่ได้รับสิทธิ์ดูแลลูกค้า LINE</p>
<form method="post" action="{{ route('crm.login') }}">
@csrf
<label for="email">อีเมล</label><input id="email" name="email" type="email" autocomplete="username" value="{{ old('email') }}" required autofocus>
<label for="password">รหัสผ่าน</label><input id="password" name="password" type="password" autocomplete="current-password" required>
<button type="submit">เข้าสู่ระบบ</button>
</form>
</section>
@endsection
