<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Partner Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="p-8">
<div class="mx-auto max-w-4xl rounded-xl bg-white p-8 shadow ring-1 ring-brand-100">
    <h1 class="text-2xl font-semibold text-brand-700">Partner Dashboard</h1>
    <p class="mt-2 text-slate-600">Burası placeholder partner panel ekranıdır.</p>

    <form class="mt-6" method="POST" action="{{ route('partner.logout') }}">
        @csrf
        <button class="rounded-lg bg-slate-900 px-4 py-2 text-white">Çıkış Yap</button>
    </form>
</div>
</body>
</html>
