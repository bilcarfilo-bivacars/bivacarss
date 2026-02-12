<!doctype html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Biva Cars')</title>
    <style>
        :root { color-scheme: light; }
        body {
            margin: 0;
            font-family: system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, sans-serif;
            line-height: 1.5;
            background: #f6f8fb;
            color: #1f2937;
        }
        .container {
            width: min(960px, 92vw);
            margin: 0 auto;
            padding: 2rem 0 3rem;
        }
    </style>
    @stack('styles')
</head>
<body>
@yield('content')
@stack('scripts')
</body>
</html>
