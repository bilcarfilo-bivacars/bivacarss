@extends('layouts.app')

@section('title', 'BivaCars | Ana Sayfa')

@section('content')
    <h1 class="page-title">BivaCars</h1>

    <section class="card" style="margin-bottom:16px;">
        <h2 style="margin-top:0;color:#0c3b78;">Fırsat Araçlar</h2>
        <p class="muted">Bu liste <code>/api/public/vehicles/featured</code> endpointinden canlı yüklenir.</p>
        <div id="featuredGrid" class="grid grid-3"></div>
        <p id="featuredError" class="muted" style="display:none;color:#a50f0f;"></p>
    </section>
@endsection

@push('scripts')
<script>
(async function loadFeatured() {
    const target = document.getElementById('featuredGrid');
    const error = document.getElementById('featuredError');

    try {
        const response = await fetch('/api/public/vehicles/featured');
        if (!response.ok) throw new Error('API hatası: ' + response.status);

        const vehicles = await response.json();
        const items = Array.isArray(vehicles.data) ? vehicles.data : vehicles;

        if (!items.length) {
            target.innerHTML = '<p class="muted">Şu anda öne çıkan araç bulunmuyor.</p>';
            return;
        }

        target.innerHTML = items.map(vehicle => `
            <article class="card">
                <h3 style="margin:0 0 8px;">${vehicle.brand ?? ''} ${vehicle.model ?? ''}</h3>
                <p class="muted" style="margin:0 0 8px;">${vehicle.year ?? '-'} • ${vehicle.fuel_type ?? '-'} • ${vehicle.transmission ?? '-'}</p>
                <strong style="color:#0f4ea5;">${Number(vehicle.listing_price_monthly ?? 0).toLocaleString('tr-TR')} ₺/ay</strong>
            </article>
        `).join('');
    } catch (e) {
        error.style.display = 'block';
        error.textContent = 'Fırsat araçlar yüklenemedi. Lütfen daha sonra tekrar deneyin.';
    }
})();
</script>
@endpush
