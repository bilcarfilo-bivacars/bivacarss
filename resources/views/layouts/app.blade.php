<!doctype html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'BivaCars')</title>
    <style>
        :root { color-scheme: light; }
        body { margin:0; font-family: Arial, sans-serif; background:#f5f8fc; color:#1b2a41; }
        .container { max-width: 1140px; margin: 0 auto; padding: 24px 16px 80px; }
        .page-title { margin: 0 0 16px; color:#0b3b7a; }
        .card { background:#fff; border-radius:14px; padding:16px; box-shadow:0 6px 18px rgba(14,60,120,.08); border:1px solid #e6eef8; }
        .grid { display:grid; gap:14px; }
        .grid-3 { grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); }
        .btn { display:inline-flex; align-items:center; justify-content:center; padding:10px 14px; border-radius:10px; text-decoration:none; border:0; cursor:pointer; font-weight:600; }
        .btn-primary { background:#0f4ea5; color:#fff; }
        .btn-secondary { background:#e8f1ff; color:#0f4ea5; }
        .badge { border-radius:999px; font-size:12px; padding:4px 10px; display:inline-block; }
        .badge.pending { background:#fff6dd; color:#9a7400; }
        .badge.approved { background:#dbf9e5; color:#136f37; }
        .badge.rejected { background:#ffe5e5; color:#a50f0f; }
        .table-wrap { overflow:auto; }
        table { width:100%; border-collapse: collapse; background:#fff; }
        th, td { text-align:left; padding:12px; border-bottom:1px solid #edf2fa; font-size:14px; }
        th { background:#f0f6ff; color:#0c3b78; }
        input, select { width:100%; padding:10px; border-radius:8px; border:1px solid #cad9ef; }
        .row { display:grid; gap:12px; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); }
        .muted { color:#5d6d86; font-size:14px; }
    </style>
</head>
<body>
<div class="container">
    @yield('content')
</div>

@include('components.floating-contact')
@if(View::exists('components.popup'))
    @include('components.popup')
@endif
@stack('scripts')
</body>
</html>
