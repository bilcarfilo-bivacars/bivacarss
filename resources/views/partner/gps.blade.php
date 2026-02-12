@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="text-primary mb-4">GPS / Araç Takip</h1>

    <div class="card shadow-sm border-primary-subtle">
        <div class="card-body">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>Plaka</th>
                        <th>GPS Sağlayıcı</th>
                        <th>Takip</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($vehicles as $vehicle)
                        <tr>
                            <td>{{ $vehicle->plate }}</td>
                            <td>{{ $vehicle->gps_provider ?: 'Tanımsız' }}</td>
                            <td>
                                @if($vehicle->gps_login_url)
                                    <a class="btn btn-sm btn-primary" href="{{ $vehicle->gps_login_url }}" target="_blank" rel="noopener">
                                        Takip Linki
                                    </a>
                                @else
                                    <span class="text-muted">Henüz tanımlanmadı</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="text-muted">Araç bulunamadı.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
