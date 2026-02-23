<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $seoPage?->title ?: $industry->name.' için Kurumsal Filo Kiralama | BivaCars' }}</title>
    <meta name="description" content="{{ $seoPage?->description ?: $industry->name.' firmaları için ölçeklenebilir kurumsal araç kiralama çözümleri.' }}">
    <link rel="canonical" href="{{ url()->current() }}">
    @vite(['resources/css/app.css'])
</head>
<body class="bg-slate-50 text-slate-900">
<div class="mx-auto max-w-5xl px-4 py-8">
    <h1 class="text-3xl font-bold text-blue-900">{{ $industry->name }} için Kurumsal Filo Kiralama</h1>
    <p class="mt-3 text-slate-700">{{ $seoPage?->content ?: ($industry->description ?: 'Operasyon yoğunluğunuza göre optimize edilen, bütçe kontrollü araç kiralama paketleri sunuyoruz.') }}</p>

    <section class="mt-8 grid gap-4 md:grid-cols-3">
        <div class="rounded-xl bg-white p-4 shadow-sm border border-slate-200"><h2 class="font-semibold">Use-case 1</h2><p class="text-sm mt-1">Saha ekipleri için hızlı teslim.</p></div>
        <div class="rounded-xl bg-white p-4 shadow-sm border border-slate-200"><h2 class="font-semibold">Use-case 2</h2><p class="text-sm mt-1">Sezonluk kapasite artışına uygun filo.</p></div>
        <div class="rounded-xl bg-white p-4 shadow-sm border border-slate-200"><h2 class="font-semibold">Use-case 3</h2><p class="text-sm mt-1">Tek panelden yönetilen kiralama süreci.</p></div>
    </section>

    @if(!empty($seoPage?->faq_json))
        <section class="mt-8 rounded-xl border border-blue-100 bg-white p-5">
            <h2 class="text-xl font-semibold text-blue-800">Sık Sorulanlar</h2>
            <div class="mt-3 space-y-3">
                @foreach($seoPage->faq_json as $faq)
                    <div>
                        <h3 class="font-medium">{{ $faq['question'] ?? '' }}</h3>
                        <p class="text-sm text-slate-600">{{ $faq['answer'] ?? '' }}</p>
                    </div>
                @endforeach
            </div>
        </section>
    @endif
</div>
</body>
</html>
