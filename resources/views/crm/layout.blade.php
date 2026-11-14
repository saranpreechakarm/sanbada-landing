<!doctype html>
<html lang="th">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex,nofollow">
    <title>ทะเบียนลูกค้า LINE · ทรัพย์มณี</title>
    <style>
        *{box-sizing:border-box}body{margin:0;background:#f5f6f8;color:#172a2b;font:16px/1.6 system-ui,sans-serif}header{background:#163c37;color:white;padding:22px max(24px,calc((100% - 1300px)/2));display:flex;gap:20px;align-items:center;justify-content:space-between}h1{margin:0;font-size:24px}main{max-width:1350px;margin:auto;padding:28px 24px}h2{margin:0 0 18px;font-size:21px}.muted{color:#64736e;font-size:14px}.card{background:white;border:1px solid #dce4df;border-radius:14px;padding:24px;margin-bottom:20px}input,select,button{font:inherit;border:1px solid #bccbc4;border-radius:8px;padding:9px 12px;max-width:100%}input,select{background:white;color:#172a2b}button,.button{background:#196953;color:white;border:0;cursor:pointer;text-decoration:none;display:inline-block;padding:10px 16px;border-radius:8px}label{display:block;font-size:14px;margin-bottom:6px}a{color:#196953}input:focus,select:focus,button:focus{outline:3px solid #83d0b7;outline-offset:2px}.filters{display:flex;align-items:end;gap:12px;flex-wrap:wrap}.filters input{width:320px}.scroll{overflow-x:auto}table{border-collapse:collapse;width:100%;min-width:1060px}th,td{text-align:left;padding:14px 10px;border-bottom:1px solid #e6eae8;vertical-align:top}th{font-size:13px;color:#64736e;background:#f5f8f6}td{font-size:14px}td input,td select{width:150px;font-size:14px}.notice{background:#e1f4e9;padding:12px 18px;border-radius:8px;margin-bottom:18px}.errors{background:#fff0ed;color:#8c3024;padding:12px 18px;border-radius:8px}.login{max-width:440px;margin:40px auto}.login input{width:100%;margin-bottom:18px}.pager{display:flex;gap:20px;align-items:center;justify-content:center;margin-top:22px}.code{font-weight:700;white-space:nowrap}.name{max-width:220px;overflow-wrap:anywhere}.date{white-space:nowrap;font-size:13px}@media(max-width:600px){main{padding:18px 12px}header{padding:18px 16px}h1{font-size:20px}.card{padding:16px}.filters input{width:100%}}
    </style>
</head>
<body>
<header><div><h1>ทะเบียนลูกค้า LINE</h1><div>ทรัพย์มณี Property</div></div>
@auth
<form action="{{ route('crm.logout') }}" method="post">@csrf<button>ออกจากระบบ</button></form>
@endauth
</header>
<main>
@if($errors->any())<div class="errors" role="alert">{{ $errors->first() }}</div>@endif
@if(session('saved'))<div class="notice" role="status">{{ session('saved') }}</div>@endif
@yield('content')
</main>
</body></html>
