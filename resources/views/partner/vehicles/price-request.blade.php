@extends('layouts.app')

@section('title', 'Fiyat Talebi | Partner')

@section('content')
    <h1 class="page-title">Fiyat / Öne Çıkarma Talebi</h1>
    <section class="card">
        <p><strong>Araç:</strong> {{ $vehicle->brand }} {{ $vehicle->model }} ({{ $vehicle->year }})</p>
        <p class="muted">Mevcut fiyat: {{ number_format((float)($vehicle->listing_price_monthly ?? 0), 0, ',', '.') }} ₺ / ay</p>

        <form id="priceRequestForm" class="row" style="align-items:end;">
            <label>Talep Türü
                <select name="request_type" required>
                    <option value="price_drop">Fiyat Düşürme</option>
                    <option value="feature_request">Öne Çıkarma Talebi</option>
                </select>
            </label>
            <label>Yeni Fiyat (₺)
                <input type="number" name="new_price" min="0">
            </label>
            <label>Açıklama
                <input name="note" placeholder="Opsiyonel not">
            </label>
            <button class="btn btn-primary" type="submit">Talebi Gönder</button>
        </form>
    </section>
@endsection

@push('scripts')
<script>
document.getElementById('priceRequestForm').addEventListener('submit', async function (event) {
    event.preventDefault();

    const formData = new FormData(event.target);
    formData.append('vehicle_id', '{{ $vehicle->id }}');

    const response = await fetch('/api/partner/price-change-requests', {
        method: 'POST',
        body: formData,
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    });

    if (!response.ok) {
        alert('Talep gönderilemedi.');
        return;
    }

    alert('Talebiniz alındı.');
    window.location.href = '/partner/araclar';
});
</script>
@endpush
