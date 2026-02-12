@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="text-primary mb-4">Müşteri Getirdim</h1>

    <div class="card mb-4 shadow-sm border-primary-subtle">
        <div class="card-header bg-primary-subtle">Yeni Referral Talebi</div>
        <div class="card-body">
            <form method="POST" action="{{ route('partner.referral.store') }}" class="row g-3">
                @csrf
                <div class="col-md-4">
                    <label class="form-label">Araç (opsiyonel)</label>
                    <select name="vehicle_id" class="form-select">
                        <option value="">Seçiniz</option>
                        @foreach($vehicles as $vehicle)
                            <option value="{{ $vehicle->id }}">{{ $vehicle->plate }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4"><label class="form-label">Firma</label><input name="company_name" class="form-control"></div>
                <div class="col-md-4"><label class="form-label">Yetkili</label><input name="contact_name" class="form-control"></div>
                <div class="col-md-4"><label class="form-label">Telefon</label><input name="contact_phone" class="form-control"></div>
                <div class="col-12"><label class="form-label">Detay</label><textarea name="details" class="form-control" rows="3"></textarea></div>
                <div class="col-12"><button class="btn btn-primary">Gönder</button></div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm border-primary-subtle">
        <div class="card-header bg-primary-subtle">Gönderilen Talepler</div>
        <div class="card-body">
            <table class="table align-middle">
                <thead><tr><th>Firma</th><th>Kişi</th><th>Araç</th><th>Durum</th><th>Tarih</th></tr></thead>
                <tbody>
                    @forelse($claims as $claim)
                        <tr>
                            <td>{{ $claim->company_name ?: '-' }}</td>
                            <td>{{ $claim->contact_name ?: '-' }}</td>
                            <td>{{ $claim->vehicle->plate ?? '-' }}</td>
                            <td><span class="badge bg-{{ $claim->status === 'approved' ? 'success' : ($claim->status === 'rejected' ? 'danger' : 'primary') }}">{{ $claim->status }}</span></td>
                            <td>{{ $claim->created_at->format('d.m.Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-muted">Talep bulunamadı.</td></tr>
                    @endforelse
                </tbody>
            </table>
            {{ $claims->links() }}
        </div>
    </div>
</div>
@endsection
