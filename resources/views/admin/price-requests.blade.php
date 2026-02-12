@extends('layouts.app')

@section('title', 'Fiyat Talepleri | Admin')

@section('content')
    <h1 class="page-title">Fiyat Talepleri</h1>

    <section class="card table-wrap">
        <table>
            <thead>
            <tr>
                <th>Araç</th>
                <th>Tür</th>
                <th>Eski Fiyat</th>
                <th>Yeni Fiyat</th>
                <th>İşlemler</th>
            </tr>
            </thead>
            <tbody>
            @forelse($requests as $request)
                <tr>
                    <td>{{ $request->brand }} {{ $request->model }} ({{ $request->year }})</td>
                    <td>{{ $request->request_type }}</td>
                    <td>{{ number_format((float)($request->listing_price_monthly ?? 0), 0, ',', '.') }} ₺</td>
                    <td>{{ number_format((float)($request->new_price ?? 0), 0, ',', '.') }} ₺</td>
                    <td style="display:flex;gap:8px;flex-wrap:wrap;">
                        <button class="btn btn-primary" onclick="reviewRequest({{ $request->id }}, 'approve')">Approve</button>
                        <button class="btn btn-secondary" onclick="reviewRequest({{ $request->id }}, 'reject')">Reject</button>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="muted">Bekleyen fiyat talebi bulunamadı.</td></tr>
            @endforelse
            </tbody>
        </table>
    </section>
@endsection

@push('scripts')
<script>
async function reviewRequest(requestId, action) {
    const response = await fetch(`/api/admin/price-change-requests/${requestId}/${action}`, {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    });

    if (!response.ok) {
        alert('Talep işlenemedi.');
        return;
    }

    window.location.reload();
}
</script>
@endpush
