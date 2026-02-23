@extends('layouts.admin')

@section('content')
    <h1>{{ $lease->exists ? 'Kurumsal Kiralama Düzenle' : 'Kurumsal Kiralama Oluştur' }}</h1>

    <form id="corporate-lease-form">
        @csrf
        <label>Firma Adı
            <input name="company_name" value="{{ old('company_name', $lease->company_name) }}" required>
        </label>

        <label>Kurumsal Model
            <select name="corporate_model_id" id="corporate_model_id">
                <option value="">Seçiniz</option>
                @foreach($models as $model)
                    <option value="{{ $model->id }}" @selected($lease->corporate_model_id == $model->id)>
                        {{ $model->brand }} {{ $model->model }}
                    </option>
                @endforeach
            </select>
        </label>

        <label>KM Paketi
            <select name="km_package_id" id="km_package_id" required>
                <option value="">Seçiniz</option>
                @foreach($packages as $package)
                    <option value="{{ $package->id }}" data-price="{{ $package->yearly_price }}" @selected($lease->km_package_id == $package->id)>
                        {{ $package->km_limit }} km - {{ number_format($package->yearly_price, 2, ',', '.') }} TL
                    </option>
                @endforeach
            </select>
        </label>

        <label>Fiyat
            <input name="monthly_price" id="monthly_price" value="{{ old('monthly_price', $lease->monthly_price) }}" type="number" step="0.01">
        </label>

        <label>Ödeme Durumu
            <select name="payment_status">
                <option value="pending" @selected(old('payment_status', $lease->payment_status) === 'pending')>pending</option>
                <option value="paid" @selected(old('payment_status', $lease->payment_status) === 'paid')>paid</option>
            </select>
        </label>

        <button type="submit">Kaydet</button>
    </form>

    @if($lease->exists)
        <hr>
        <h2>Araç Öner</h2>

        @if($lease->matchedVehicle)
            <p><strong>Eşleşen Araç:</strong> {{ $lease->matchedVehicle->brand }} {{ $lease->matchedVehicle->model }}</p>
        @endif

        <table>
            <thead>
                <tr>
                    <th>Marka/Model</th>
                    <th>Yıl</th>
                    <th>KM</th>
                    <th>Fiyat</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($vehicleSuggestions as $vehicle)
                    <tr>
                        <td>{{ $vehicle->brand }} {{ $vehicle->model }}</td>
                        <td>{{ $vehicle->year }}</td>
                        <td>{{ $vehicle->km }}</td>
                        <td>{{ number_format($vehicle->listing_price_monthly, 2, ',', '.') }} TL</td>
                        <td>
                            <form method="POST" action="{{ route('admin.corporate-leases.match-vehicle', $lease) }}">
                                @csrf
                                <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">
                                <button type="submit">Bu aracı eşleştir</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">Uygun araç önerisi bulunamadı.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    @endif

    <script>
        document.getElementById('km_package_id')?.addEventListener('change', function (e) {
            const selected = e.target.selectedOptions[0];
            if (selected?.dataset?.price) {
                document.getElementById('monthly_price').value = selected.dataset.price;
            }
        });
    </script>
@endsection
