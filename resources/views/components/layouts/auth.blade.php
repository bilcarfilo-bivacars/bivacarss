<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'BivaCars' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen">
<div class="mx-auto flex min-h-screen max-w-7xl items-center justify-center px-4 py-12">
    <div class="w-full max-w-md rounded-2xl bg-white p-8 shadow-xl ring-1 ring-brand-100">
        <div class="mb-6 text-center">
            <h1 class="text-2xl font-semibold text-brand-700">{{ $heading }}</h1>
            <p class="mt-2 text-sm text-slate-500">{{ $subheading }}</p>
        </div>

        @if ($errors->any())
            <div class="mb-4 rounded-md border border-red-200 bg-red-50 p-3 text-sm text-red-700">
                {{ $errors->first() }}
            </div>
        @endif

        {{ $slot }}
    </div>
</div>
</body>
</html>
