@extends('layouts.app')

@section('title', 'Kurumsal Teklif Al')

@section('content')
<div class="container py-5">
    <h1 class="h3 mb-4">Kurumsal Teklif Formu</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('public.corporate-lead.store') }}" class="row g-3">
        @csrf
        <div class="col-md-6">
            <label class="form-label">Şirket Adı</label>
            <input type="text" class="form-control" name="company_name" value="{{ old('company_name') }}" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Vergi No / TCKN</label>
            <input type="text" class="form-control" name="tax_number" value="{{ old('tax_number') }}">
        </div>
        <div class="col-md-6">
            <label class="form-label">Yetkili</label>
            <input type="text" class="form-control" name="contact_name" value="{{ old('contact_name') }}">
        </div>
        <div class="col-md-6">
            <label class="form-label">Telefon</label>
            <input type="text" class="form-control" name="contact_phone" value="{{ old('contact_phone') }}" required>
        </div>
        <div class="col-md-6"><input type="text" class="form-control" name="city" placeholder="Şehir" value="{{ old('city') }}"></div>
        <div class="col-md-6"><input type="text" class="form-control" name="district" placeholder="İlçe" value="{{ old('district') }}"></div>
        <div class="col-md-6"><input type="text" class="form-control" name="sector" placeholder="Sektör" value="{{ old('sector') }}"></div>
        <div class="col-md-3"><input type="number" class="form-control" name="vehicles_needed" placeholder="Araç İhtiyacı" value="{{ old('vehicles_needed') }}"></div>
        <div class="col-md-3"><input type="number" class="form-control" name="lease_months" placeholder="Kiralama Ay" value="{{ old('lease_months', 12) }}"></div>
        <div class="col-md-6"><input type="number" class="form-control" step="0.01" name="budget_monthly" placeholder="Aylık Bütçe" value="{{ old('budget_monthly') }}"></div>
        <div class="col-12"><textarea class="form-control" name="notes" rows="3" placeholder="Notlar">{{ old('notes') }}</textarea></div>
        <div class="col-12"><button class="btn btn-primary">Teklif Talebi Gönder</button></div>
    </form>
</div>
@endsection
