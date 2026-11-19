@extends('admin.layout')
@section('title', 'เข้าสู่ระบบ')
@section('content')
<div class="auth-card">
    <div class="eyebrow">WELCOME BACK</div><h1>ดูแลเว็บได้ง่าย ๆ<br>จากที่เดียว</h1><p class="muted">จัดการโปรเจกต์ โครงการใหม่ และวิดีโอของ Sanbada</p>
    @if(session('saved'))<div class="notice success">{{ session('saved') }}</div>@endif
    @if($errors->any())<div class="notice error" role="alert">{{ $errors->first() }}</div>@endif
    <form method="post" action="{{ route('admin.login') }}" class="stack">@csrf
        <label>อีเมล<input type="email" name="email" value="{{ old('email') }}" required autocomplete="username" autofocus></label>
        <label>รหัสผ่าน<input type="password" name="password" required autocomplete="current-password"></label>
        <button class="button primary full">เข้าสู่ระบบ →</button>
    </form>
    <p class="hint">ลืมรหัสผ่าน? ให้ผู้ดูแลอีกบัญชีตั้งรหัสผ่านใหม่ในเมนูผู้ดูแลระบบ</p>
</div>
@endsection
