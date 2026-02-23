<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $seoPage?->title ?: $city->name.' '.$industry->name.' Filo Kiralama | BivaCars' }}</title>
    <meta name="description" content="{{ $seoPage?->description ?: $city->name.' bölgesinde '.$industry->name.' firmalarına yıllık kurumsal kiralama çözümleri.' }}">
    <link rel="canonical" href="{{ url()->current() }}">
    @vite(['resources/css/app.css'])
    @php
        $schema = $seoPage?->schema_override ?: json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'Service',
            'name' => 'Kurumsal Filo Kiralama',
            'areaServed' => $city->name,
            'audience' => ['@type' => 'BusinessAudience'],
        ], JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
    @endphp
    <script type="application/ld+json">{!! $schema !!}</script>
</head>
<body class="bg-slate-50 text-slate-900 pb-24">
<div class="mx-auto max-w-6xl px-4 py-8">
    <h1 class="text-3xl font-bold text-blue-900">{{ $city->name }} {{ $industry->name }} Filo Kiralama</h1>
    <p class="mt-2 text-slate-700">{{ $seoPage?->content ?: 'Kurumsal mobilite ihtiyaçlarınız için ölçeklenebilir, SLA odaklı filo kiralama desteği.' }}</p>

    <div class="mt-6 grid gap-4 md:grid-cols-3">
        <div class="rounded-xl bg-white p-4 border">Operasyon kolaylığı</div>
        <div class="rounded-xl bg-white p-4 border">Maliyet avantajı</div>
        <div class="rounded-xl bg-white p-4 border">Hızlı teslim</div>
    </div>

    <section class="mt-8 grid gap-6 lg:grid-cols-2">
        <form method="POST" action="{{ route('public.corporate-lead.store') }}" class="rounded-xl border bg-white p-5 space-y-3">
            @csrf
            <h2 class="text-xl font-semibold">Mini Filo İhtiyaç Formu</h2>
            <input type="hidden" name="city" value="{{ $city->name }}">
            <input type="hidden" name="sector" value="{{ $industry->name }}">
            <div>
                <label class="text-sm">Firma adı</label>
                <input name="company_name" class="mt-1 w-full rounded border px-3 py-2" required>
            </div>
            <div>
                <label class="text-sm">Telefon</label>
                <input name="contact_phone" class="mt-1 w-full rounded border px-3 py-2" required>
            </div>
            <div>
                <label class="text-sm">Vergi numarası (opsiyonel)</label>
                <input name="tax_number" class="mt-1 w-full rounded border px-3 py-2" placeholder="Opsiyonel">
            </div>
            <div>
                <label class="text-sm">Araç sayısı (opsiyonel)</label>
                <input name="vehicles_needed" type="number" min="0" class="mt-1 w-full rounded border px-3 py-2" placeholder="—">
            </div>
            <div>
                <label class="text-sm">Notlar (opsiyonel)</label>
                <textarea name="notes" class="mt-1 w-full rounded border px-3 py-2" rows="3"></textarea>
            </div>
            <button class="rounded-lg bg-blue-700 px-4 py-2 text-white">Teklif Al</button>
        </form>

        <aside class="rounded-xl border bg-white p-5">
            <p class="text-sm text-slate-600">Gebze ve çevresinde kurumsal müşterilere hizmet.</p>
            <h3 class="mt-3 font-semibold">Örnek Paketler</h3>
            <ul class="mt-2 space-y-2 text-sm">
                @foreach($packages->take(3) as $package)
                    <li>{{ number_format($package->km_limit, 0, ',', '.') }} km / yıl - {{ number_format((float)$package->yearly_price, 2, ',', '.') }} TL</li>
                @endforeach
            </ul>
        </aside>
    </section>
</div>

<div class="fixed bottom-0 left-0 right-0 border-t bg-white p-3">
    <div class="mx-auto flex max-w-6xl gap-2">
        <a href="https://wa.me/905550000000?text={{ urlencode($whatsAppMessage) }}" class="flex-1 rounded-lg bg-green-600 px-4 py-2 text-center text-white">WhatsApp</a>
        <a href="tel:+905550000000" class="flex-1 rounded-lg bg-blue-700 px-4 py-2 text-center text-white">Telefon</a>
    </div>
</div>
</body>
</html>
