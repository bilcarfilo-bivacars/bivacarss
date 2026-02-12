@extends('layouts.admin')

@section('content')
    <h1>Kurumsal Teklifler</h1>
    <a href="{{ route('admin.corporate-offers.create') }}">Yeni Teklif</a>

    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Firma</th>
            <th>Araç</th>
            <th>Durum</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach ($offers as $offer)
            <tr>
                <td>{{ $offer->id }}</td>
                <td>{{ $offer->company_name ?: '-' }}</td>
                <td>{{ $offer->brand }} {{ $offer->model }}</td>
                <td>{{ $offer->status }}</td>
                <td><a href="{{ route('admin.corporate-offers.show', $offer) }}">Detay</a></td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $offers->links() }}
@endsection
