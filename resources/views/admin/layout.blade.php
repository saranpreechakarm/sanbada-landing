<!doctype html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex,nofollow">
    <title>@yield('title', 'จัดการเว็บไซต์') · Sanbada Admin</title>
    <link rel="stylesheet" href="{{ asset('css/content-admin.css') }}">
    <script src="{{ asset('js/content-admin.js') }}" defer></script>
</head>
<body>
@if(request()->routeIs('admin.login', 'admin.setup'))
    <main class="auth-shell"><a class="auth-brand" href="{{ route('home', 'ru') }}">SANBADA <span>CONTENT STUDIO</span></a>@yield('content')</main>
@else
    <aside class="sidebar">
        <a class="brand" href="{{ route('admin.dashboard') }}">SANBADA<span>CONTENT STUDIO</span></a>
        <div class="sidebar-label">จัดการเว็บไซต์</div>
        <nav aria-label="เมนูผู้ดูแล">
            @foreach(['dashboard' => ['ภาพรวม', '◈'], 'leads.index' => ['Leads / ลูกค้า', '♧'], 'projects.index' => ['โปรเจกต์', '▦'], 'videos.index' => ['วิดีโอ', '▷'], 'users.index' => ['ผู้ดูแลระบบ', '◎'], 'guide' => ['คู่มือการใช้งาน', '☰']] as $page => [$label, $icon])
                <a class="nav-link {{ request()->routeIs('admin.'.explode('.', $page)[0].'*') ? 'active' : '' }}" href="{{ route('admin.'.$page) }}"><span aria-hidden="true">{{ $icon }}</span>{{ $label }}</a>
            @endforeach
        </nav>
        <div class="sidebar-footer"><div class="avatar">{{ mb_substr(auth()->user()->name, 0, 1) }}</div><div><strong>{{ auth()->user()->name }}</strong><small>ผู้ดูแลเว็บไซต์</small></div></div>
        <form method="post" action="{{ route('admin.logout') }}">@csrf<button class="logout">ออกจากระบบ ↗</button></form>
    </aside>
    <div class="workspace">
        <header class="topbar"><span>Sanbada Real Estate <span class="muted">/ หลังบ้าน</span></span><a href="{{ route('home', 'ru') }}" target="_blank" rel="noopener">เปิดหน้าเว็บ ↗</a></header>
        <main class="main-content">
            @if(session('saved'))<div class="notice success" role="status">{{ session('saved') }}</div>@endif
            @if($errors->any())<div class="notice error" role="alert"><strong>กรุณาตรวจสอบข้อมูล</strong><ul>@foreach($errors->all() as $message)<li>{{ $message }}</li>@endforeach</ul><p>หากเลือกรูปหรือ PDF ไว้ กรุณาเลือกไฟล์อีกครั้ง</p></div>@endif
            @yield('content')
        </main>
    </div>
@endif
</body>
</html>
