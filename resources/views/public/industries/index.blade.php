<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sektörler | BivaCars</title>
    <meta name="description" content="Sektörünüze özel kurumsal filo kiralama çözümleri.">
    @vite(['resources/css/app.css'])
</head>
<body class="bg-slate-50 text-slate-900">
<div class="mx-auto max-w-6xl px-4 py-8">
    <h1 class="text-3xl font-bold text-blue-900">Sektör Bazlı Kurumsal Filo Çözümleri</h1>
    <p class="mt-2 text-slate-600">Yüksek tempolu operasyonlara uygun, ölçeklenebilir araç kiralama planları.</p>

    <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        @foreach($industries as $industry)
            <article class="rounded-xl border border-blue-100 bg-white p-5 shadow-sm">
                <h2 class="text-lg font-semibold text-blue-800">{{ $industry->name }}</h2>
                <p class="mt-2 text-sm text-slate-600">{{ $industry->description ?: 'Sektöre özel maliyet ve operasyon optimizasyonu için esnek filo planları.' }}</p>
                <a href="{{ url('/sektorler/'.$industry->key) }}" class="mt-4 inline-flex rounded-lg bg-blue-700 px-3 py-2 text-sm font-medium text-white">İncele</a>
            </article>
        @endforeach
    </div>
</div>
</body>
</html>
