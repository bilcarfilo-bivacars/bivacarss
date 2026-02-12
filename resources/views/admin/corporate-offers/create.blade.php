@extends('layouts.admin')

@section('content')
    <h1>Yeni Kurumsal Teklif</h1>

    <form method="POST" action="{{ route('admin.corporate-offers.store') }}">
        @csrf
        <label>Marka</label>
        <select name="brand" required>
            @foreach($corporateModels as $corporateModel)
                <option value="{{ $corporateModel->brand }}">{{ $corporateModel->brand }}</option>
            @endforeach
        </select>

        <label>Model</label>
        <select name="model" required>
            @foreach($corporateModels as $corporateModel)
                <option value="{{ $corporateModel->model }}">{{ $corporateModel->model }}</option>
            @endforeach
        </select>

        <label>KM Paketi</label>
        <select name="km_package_id" required>
            @foreach($kmPackages as $package)
                <option value="{{ $package->id }}">{{ $package->km_limit }} km - {{ $package->monthly_price }} TL</option>
            @endforeach
        </select>

        <label>Aylık Fiyat</label>
        <input name="monthly_price" type="number" step="0.01" required>

        <label>Firma Adı</label>
        <input name="company_name" type="text">

        <label>İletişim Telefonu</label>
        <input name="contact_phone" type="text">

        <label>Notlar</label>
        <textarea name="notes"></textarea>

        <button type="submit">Kaydet</button>
    </form>
@endsection
