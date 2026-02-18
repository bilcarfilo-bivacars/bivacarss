@extends('layouts.app')

@section('title', 'Kurumsal Lead Detay')

@section('content')
<div class="container py-4">
    <h1 class="h4">Kurumsal Lead #{{ $lead->id }}</h1>
    <p><strong>Şirket:</strong> {{ $lead->company_name }}</p>
    <p><strong>Telefon:</strong> {{ $lead->contact_phone }}</p>
    <p><strong>Skor:</strong> <span class="badge bg-primary">{{ $lead->lead_score }}</span></p>
    <p><strong>Grade:</strong> <span class="badge {{ $lead->lead_grade === 'high' ? 'bg-success' : ($lead->lead_grade === 'medium' ? 'bg-warning text-dark' : 'bg-secondary') }}">{{ $lead->lead_grade }}</span></p>
    <p><strong>Status:</strong> <span class="badge bg-info text-dark">{{ $lead->status }}</span></p>

    <form method="POST" action="{{ route('admin.corporate-leads.rescore', $lead->id) }}" class="mb-3">
        @csrf
        <button class="btn btn-warning">Yeniden Puanla</button>
    </form>

    <form method="POST" action="{{ route('admin.corporate-leads.status', $lead->id) }}">
        @csrf
        <select name="status" class="form-select mb-2">
            @foreach(['new','contacted','qualified','won','lost'] as $status)
                <option value="{{ $status }}" @selected($lead->status === $status)>{{ $status }}</option>
            @endforeach
        </select>
        <button class="btn btn-primary">Durumu Güncelle</button>
    </form>
</div>
@endsection
