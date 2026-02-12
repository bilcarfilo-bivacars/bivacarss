@extends('layouts.app')

@section('title', 'Partner Araçlarım')

@section('content')
    <h1 class="page-title">Araçlarım</h1>
    <div class="card table-wrap">
        <table>
            <thead>
            <tr>
                <th>Araç</th>
                <th>Durum</th>
                <th>Fiyat</th>
                <th>Net Kazanç</th>
                <th>Featured</th>
                <th>İşlemler</th>
            </tr>
            </thead>
            <tbody>
            @forelse($vehicles as $vehicle)
                @php
                    $price = (float) ($vehicle->listing_price_monthly ?? 0);
                    $net = $price * 0.9;
                    $status = $vehicle->status ?? 'pending_approval';
                @endphp
                <tr>
                    <td>{{ $vehicle->brand }} {{ $vehicle->model }} ({{ $vehicle->year }})</td>
                    <td><span class="badge {{ str_contains($status, 'approved') ? 'approved' : (str_contains($status, 'reject') ? 'rejected' : 'pending') }}">{{ $status }}</span></td>
                    <td>{{ number_format($price, 0, ',', '.') }} ₺</td>
                    <td>{{ number_format($net, 0, ',', '.') }} ₺</td>
                    <td>{{ !empty($vehicle->is_featured) ? 'Evet' : 'Hayır' }}</td>
                    <td style="display:flex;gap:8px;flex-wrap:wrap;">
                        <a class="btn btn-secondary" href="#">Düzenle</a>
                        <a class="btn btn-secondary" href="/partner/araclar/{{ $vehicle->id }}/fiyat">Fiyat Talebi</a>
                        @if(!empty($vehicle->gps_login_url))
                            <a class="btn btn-secondary" href="{{ $vehicle->gps_login_url }}" target="_blank" rel="noopener noreferrer">Takibe Git</a>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="muted">Araç bulunamadı.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
