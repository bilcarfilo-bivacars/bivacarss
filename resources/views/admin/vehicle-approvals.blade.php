@extends('layouts.app')

@section('title', 'İlan Onayları | Admin')

@section('content')
    <h1 class="page-title">İlan Onayları</h1>
    <section class="card table-wrap">
        <table>
            <thead>
            <tr>
                <th>Araç</th>
                <th>Partner</th>
                <th>Fiyat</th>
                <th>İşlemler</th>
            </tr>
            </thead>
            <tbody>
            @forelse($vehicles as $vehicle)
                <tr>
                    <td>{{ $vehicle->brand }} {{ $vehicle->model }} ({{ $vehicle->year }})</td>
                    <td>#{{ $vehicle->partner_id }}</td>
                    <td>{{ number_format((float)($vehicle->listing_price_monthly ?? 0), 0, ',', '.') }} ₺</td>
                    <td style="display:flex;gap:8px;">
                        <button class="btn btn-primary" onclick="moderateVehicle({{ $vehicle->id }}, 'approve')">Approve</button>
                        <button class="btn btn-secondary" onclick="moderateVehicle({{ $vehicle->id }}, 'reject')">Reject</button>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="muted">Bekleyen ilan yok.</td></tr>
            @endforelse
            </tbody>
        </table>
    </section>
@endsection

@push('scripts')
<script>
async function moderateVehicle(vehicleId, action) {
    const response = await fetch(`/api/admin/vehicles/${vehicleId}/${action}`, {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    });

    if (!response.ok) {
        alert('İşlem başarısız oldu.');
        return;
    }

    window.location.reload();
}
</script>
@endpush
