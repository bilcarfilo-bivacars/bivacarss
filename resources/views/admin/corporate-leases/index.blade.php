@extends('layouts.admin')

@section('content')
    <h1>Kurumsal Kiralamalar</h1>
    <table>
        <thead>
        <tr>
            <th>Firma</th>
            <th>Model</th>
            <th>KM Paket</th>
            <th>Aylık Fiyat (+KDV)</th>
            <th>Ödeme Durumu</th>
            <th>Aksiyon</th>
        </tr>
        </thead>
        <tbody>
        @foreach($leases as $lease)
            <tr>
                <td>{{ $lease->company_name }}</td>
                <td>{{ optional($lease->model)->brand }} {{ optional($lease->model)->model }}</td>
                <td>{{ optional($lease->kmPackage)->km_limit }} km</td>
                <td>{{ number_format($lease->monthly_price, 2, ',', '.') }} TL</td>
                <td>
                    <span class="badge {{ $lease->payment_status === 'paid' ? 'badge-success' : 'badge-warning' }}">
                        {{ $lease->payment_status }}
                    </span>
                </td>
                <td>
                    <form method="POST" action="{{ url('/api/admin/corporate-leases/'.$lease->id.'/mark-paid') }}">
                        @csrf
                        <button type="submit">Ödendi işaretle</button>
                    </form>
                    <a href="{{ route('admin.corporate-leases.edit', $lease) }}">Düzenle</a>
                    <a href="{{ url('/admin/corporate-offers?lease='.$lease->id) }}">PDF teklif</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $leases->links() }}
@endsection
