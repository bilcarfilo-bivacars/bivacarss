<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'BivaCars')</title>
    <meta name="description" content="@yield('meta_description', 'BivaCars araç kiralama hizmetleri.')">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 text-slate-900">
    <main>
        @yield('content')
    </main>

    @if (view()->exists('components.floating-contact'))
        @include('components.floating-contact')
    @endif
</body>
</html>
