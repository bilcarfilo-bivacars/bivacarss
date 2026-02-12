@extends('layouts.app')

@section('title', 'Kurumsal Kiralama | BivaCars')

@section('content')
    <h1 class="page-title">Kurumsal Kiralama</h1>

    <section class="card" style="margin-bottom:16px;">
        <h2 style="margin-top:0;color:#0c3b78;">1) Model Seçin</h2>
        <div class="grid grid-3" id="modelGrid">
            @forelse($models as $model)
                <label class="card" style="cursor:pointer;">
                    <input type="radio" name="selected_model" value="{{ $model->id }}" data-brand="{{ $model->brand }}" data-model="{{ $model->model }}" style="width:auto;">
                    <div>
                        <strong>{{ $model->brand }} {{ $model->model }}</strong>
                    </div>
                </label>
            @empty
                <p class="muted">Aktif kurumsal model bulunamadı.</p>
            @endforelse
        </div>
    </section>

    <section class="card" style="margin-bottom:16px;">
        <h2 style="margin-top:0;color:#0c3b78;">2) KM Paketi Seçin</h2>
        <div class="row" id="packageGroup">
            @foreach($kmPackages as $package)
                <label class="card" style="cursor:pointer;">
                    <input type="radio" name="km_package" value="{{ $package->id }}" data-km="{{ $package->yearly_km_limit }}" data-price="{{ $package->yearly_price }}" style="width:auto;">
                    <div><strong>{{ number_format($package->yearly_km_limit, 0, ',', '.') }} KM/Yıl</strong></div>
                    <div class="muted">{{ number_format($package->yearly_price, 0, ',', '.') }} ₺ + KDV</div>
                </label>
            @endforeach
        </div>
    </section>

    <section class="card">
        <h2 style="margin-top:0;color:#0c3b78;">3) Teklif Alın</h2>
        <p id="selectionSummary" class="muted">Model ve KM paketi seçildiğinde fiyat burada görünecek.</p>
        <div style="display:flex;flex-wrap:wrap;gap:10px;">
            <a id="waCta" class="btn btn-primary" href="#" target="_blank" rel="noopener noreferrer" style="pointer-events:none;opacity:.6;">WhatsApp'tan Teklif Al</a>
            <a class="btn btn-secondary" href="tel:{{ config('bivacars.phone_number') }}">Telefon ile Ara</a>
        </div>
    </section>
@endsection

@push('scripts')
<script>
(function() {
    const modelInputs = document.querySelectorAll('input[name="selected_model"]');
    const packageInputs = document.querySelectorAll('input[name="km_package"]');
    const summary = document.getElementById('selectionSummary');
    const cta = document.getElementById('waCta');
    const waNumber = @json(config('bivacars.whatsapp_number'));

    function getSelected(name) {
        return document.querySelector(`input[name="${name}"]:checked`);
    }

    function refresh() {
        const selectedModel = getSelected('selected_model');
        const selectedPackage = getSelected('km_package');

        if (!selectedModel || !selectedPackage) {
            summary.textContent = 'Model ve KM paketi seçildiğinde fiyat burada görünecek.';
            cta.style.pointerEvents = 'none';
            cta.style.opacity = '.6';
            cta.href = '#';
            return;
        }

        const brand = selectedModel.dataset.brand;
        const model = selectedModel.dataset.model;
        const kmLimit = selectedPackage.dataset.km;
        const price = Number(selectedPackage.dataset.price);

        summary.textContent = `${brand} ${model} için yıllık ${Number(kmLimit).toLocaleString('tr-TR')} KM paketi: ${price.toLocaleString('tr-TR')} ₺ + KDV.`;

        const message = `Merhaba, ${brand} ${model} için kurumsal kiralama teklifi istiyorum. Yıllık ${Number(kmLimit).toLocaleString('tr-TR')} km paketi hakkında bilgi alabilir miyim?`;
        cta.href = `https://wa.me/${waNumber}?text=${encodeURIComponent(message)}`;
        cta.style.pointerEvents = 'auto';
        cta.style.opacity = '1';
    }

    [...modelInputs, ...packageInputs].forEach(input => input.addEventListener('change', refresh));
})();
</script>
@endpush
