@extends('layouts.app')

@section('title', 'Yeni Araç İlanı | Partner')

@section('content')
    <h1 class="page-title">Yeni Araç İlanı (3 Adım)</h1>

    <form id="wizardForm" class="card">
        <div data-step="1" class="wizard-step">
            <h2>Adım 1: Araç Bilgileri</h2>
            <div class="row">
                <label>Marka <input name="brand" required></label>
                <label>Model <input name="model" required></label>
                <label>Yıl <input type="number" name="year" min="1990" required></label>
                <label>Vites
                    <select name="transmission" required>
                        <option value="">Seçiniz</option><option>Otomatik</option><option>Manuel</option>
                    </select>
                </label>
                <label>Yakıt
                    <select name="fuel_type" required>
                        <option value="">Seçiniz</option><option>Benzin</option><option>Dizel</option><option>Hibrit</option><option>Elektrik</option>
                    </select>
                </label>
                <label>Kilometre <input type="number" name="km" min="0" required></label>
            </div>
        </div>

        <div data-step="2" class="wizard-step" style="display:none;">
            <h2>Adım 2: Fotoğraf</h2>
            <p class="muted">Şimdilik placeholder upload alanı. Public disk kullanılacak şekilde form-data olarak API'ye gönderilir.</p>
            <input type="file" name="photos[]" multiple accept="image/*">
        </div>

        <div data-step="3" class="wizard-step" style="display:none;">
            <h2>Adım 3: Fiyatlandırma</h2>
            <div class="row">
                <label>Aylık Liste Fiyatı (₺)
                    <input type="number" id="listingPrice" name="listing_price_monthly" min="0" required>
                </label>
                <label>KDV Modu
                    <select name="vat_mode">
                        <option value="included">KDV Dahil</option>
                        <option value="excluded">KDV Hariç</option>
                    </select>
                </label>
            </div>
            <p class="muted" id="commissionPreview">Net kazanç: -</p>
        </div>

        <div style="margin-top:16px;display:flex;gap:10px;">
            <button type="button" id="prevBtn" class="btn btn-secondary" style="display:none;">Geri</button>
            <button type="button" id="nextBtn" class="btn btn-primary">İleri</button>
            <button type="submit" id="saveBtn" class="btn btn-primary" style="display:none;">Kaydet</button>
        </div>
    </form>
@endsection

@push('scripts')
<script>
(function () {
    const form = document.getElementById('wizardForm');
    const steps = Array.from(document.querySelectorAll('.wizard-step'));
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const saveBtn = document.getElementById('saveBtn');
    const listingPriceInput = document.getElementById('listingPrice');
    const commissionPreview = document.getElementById('commissionPreview');

    let currentStep = 0;

    function renderStep() {
        steps.forEach((step, index) => {
            step.style.display = index === currentStep ? 'block' : 'none';
        });

        prevBtn.style.display = currentStep > 0 ? 'inline-flex' : 'none';
        nextBtn.style.display = currentStep < steps.length - 1 ? 'inline-flex' : 'none';
        saveBtn.style.display = currentStep === steps.length - 1 ? 'inline-flex' : 'none';
    }

    async function loadCommissionPreview() {
        const price = Number(listingPriceInput.value || 0);
        if (!price) {
            commissionPreview.textContent = 'Net kazanç: -';
            return;
        }

        try {
            const response = await fetch(`/api/partner/commission-preview?price=${price}`);
            const payload = await response.json();
            const netAmount = payload.net_amount ?? payload.data?.net_amount;
            const rate = payload.commission_rate ?? payload.data?.commission_rate;
            commissionPreview.textContent = `Net kazanç: ${Number(netAmount || 0).toLocaleString('tr-TR')} ₺ (Komisyon: %${Number((rate || 0) * 100).toFixed(1)})`;
        } catch (_) {
            const fallbackNet = price * 0.9;
            commissionPreview.textContent = `Net kazanç (tahmini): ${fallbackNet.toLocaleString('tr-TR')} ₺`;
        }
    }

    prevBtn.addEventListener('click', () => {
        currentStep = Math.max(0, currentStep - 1);
        renderStep();
    });

    nextBtn.addEventListener('click', () => {
        currentStep = Math.min(steps.length - 1, currentStep + 1);
        renderStep();
    });

    listingPriceInput.addEventListener('input', loadCommissionPreview);

    form.addEventListener('submit', async (event) => {
        event.preventDefault();
        const formData = new FormData(form);

        const response = await fetch('/api/partner/vehicles', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });

        if (!response.ok) {
            alert('İlan kaydedilemedi. Lütfen alanları kontrol edin.');
            return;
        }

        window.location.href = '/partner/araclar';
    });

    renderStep();
})();
</script>
@endpush
