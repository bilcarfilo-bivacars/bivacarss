<!doctype html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #222; }
        .header { margin-bottom: 24px; }
        .title { font-size: 20px; font-weight: bold; margin-bottom: 8px; }
        .meta td { padding: 4px 8px 4px 0; }
        .box { border: 1px solid #ddd; padding: 12px; margin: 16px 0; }
        .small { font-size: 10px; color: #666; margin-top: 24px; }
    </style>
</head>
<body>
<div class="header">
    <div class="title">{{ $company['name'] ?? 'BivaCars' }} - Kurumsal Araç Teklifi</div>
    <div>{{ $company['address'] ?? '' }}</div>
    <div>Tel: {{ $company['phone'] ?? '-' }} | E-posta: {{ $company['email'] ?? '-' }}</div>
    <div>Harita: {{ $company['maps_url'] ?? '-' }}</div>
</div>

<table class="meta">
    <tr>
        <td><strong>Teklif No:</strong></td>
        <td>BVC-{{ $offer->id }}</td>
    </tr>
    <tr>
        <td><strong>Tarih:</strong></td>
        <td>{{ now()->format('d.m.Y') }}</td>
    </tr>
    <tr>
        <td><strong>Şirket:</strong></td>
        <td>{{ $offer->company_name ?: 'Belirtilmedi' }}</td>
    </tr>
</table>

<div class="box">
    <p><strong>Araç:</strong> {{ $offer->brand }} {{ $offer->model }}</p>
    <p><strong>KM Paketi:</strong> {{ $offer->kmPackage?->km_limit }} km</p>
    <p><strong>Fiyat:</strong> {{ number_format((float) $offer->monthly_price, 2, ',', '.') }} TL + KDV (%{{ number_format((float) $offer->vat_rate, 2, ',', '.') }})</p>
    <p><strong>Notlar:</strong> {{ $offer->notes ?: '-' }}</p>
</div>

<p>Rezervasyon/iletişim: WhatsApp/Telefon</p>

<div class="small">Bu teklif bilgilendirme amaçlıdır.</div>
</body>
</html>
