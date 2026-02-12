@extends('layouts.app')

@section('content')
<div class="container py-4">
    <a href="{{ route('admin.partner-leads.index') }}" class="btn btn-light mb-3">← Listeye Dön</a>

    <h1 class="h3">Lead #{{ $lead->id }}</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card mb-3">
        <div class="card-body">
            <p><strong>Ad Soyad:</strong> {{ $lead->full_name }}</p>
            <p><strong>Telefon:</strong> {{ $lead->phone }}</p>
            <p><strong>Şehir:</strong> {{ $lead->city }}</p>
            <p><strong>Araç:</strong> {{ $lead->brand }} {{ $lead->model }}</p>
            <p><strong>Yıl / KM:</strong> {{ $lead->year }} / {{ $lead->km }}</p>
            <p><strong>Beklenen Kira:</strong> {{ $lead->expected_rent }}</p>
            <p><strong>Hasar Kaydı:</strong> {{ $lead->has_damage ? 'Evet' : 'Hayır' }}</p>
            <p><strong>Açıklama:</strong> {{ $lead->notes }}</p>
            <p><strong>Hesaplama JSON:</strong> <code>{{ $lead->calculation_json }}</code></p>
        </div>
    </div>

    @if($lead->photo_path)
        <div class="mb-3">
            <img src="{{ asset('storage/' . $lead->photo_path) }}" alt="Araç fotoğrafı" style="max-width: 320px" class="img-thumbnail">
        </div>
    @endif

    <form method="POST" action="{{ route('admin.partner-leads.update', $lead->id) }}" class="card card-body">
        @csrf
        @method('PUT')
        <label class="form-label">Durum Güncelle</label>
        <div class="d-flex gap-2">
            <select class="form-select" name="status">
                @foreach(['new', 'contacted', 'converted', 'archived'] as $status)
                    <option value="{{ $status }}" @selected($lead->status === $status)>{{ $status }}</option>
                @endforeach
            </select>
            <button class="btn btn-primary">Güncelle</button>
        </div>
    </form>
</div>
@endsection
