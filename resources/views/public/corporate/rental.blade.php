@extends('layouts.app')

@section('content')
    <h1>Kurumsal Kiralama</h1>

    <div id="models">
        @foreach($models as $model)
            <button class="model-option" data-brand="{{ $model->brand }}" data-model="{{ $model->model }}">
                {{ $model->brand }} {{ $model->model }}
            </button>
        @endforeach
    </div>

    <label>KM Paket
        <select id="km_package_id">
            @foreach($packages as $package)
                <option value="{{ $package->id }}" data-km="{{ $package->km_limit }}" data-price="{{ $package->yearly_price }}">
                    {{ $package->km_limit }} km
                </option>
            @endforeach
        </select>
    </label>

    <p>Fiyat: <strong id="price_preview">-</strong> TL + KDV</p>
    <a id="whatsapp_cta" href="#" target="_blank" rel="noopener">WhatsApp ile teklif iste</a>

    <script>
        let selectedBrand = '';
        let selectedModel = '';

        const modelButtons = document.querySelectorAll('.model-option');
        const kmSelect = document.getElementById('km_package_id');
        const pricePreview = document.getElementById('price_preview');
        const cta = document.getElementById('whatsapp_cta');

        function updateUI() {
            const option = kmSelect.selectedOptions[0];
            const km = option?.dataset?.km || '';
            const price = option?.dataset?.price || '';
            pricePreview.textContent = price;

            const text = `Merhaba, ${selectedBrand} ${selectedModel} - ${km} km paketi için ${price} TL + KDV kurumsal kiralama teklifi istiyorum.`;
            cta.href = `https://wa.me/?text=${encodeURIComponent(text)}`;
        }

        modelButtons.forEach((btn) => {
            btn.addEventListener('click', () => {
                selectedBrand = btn.dataset.brand;
                selectedModel = btn.dataset.model;
                updateUI();
            });
        });

        kmSelect.addEventListener('change', updateUI);
        updateUI();
    </script>
@endsection
