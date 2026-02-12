@extends('layouts.admin')

@section('content')
    <h1>Teklif #{{ $offer->id }}</h1>
    <p>{{ $offer->brand }} {{ $offer->model }} - {{ $offer->kmPackage?->km_limit }} km</p>
    <p>Durum: {{ $offer->status }}</p>

    <form action="{{ route('admin.corporate-offers.generate-pdf', $offer) }}" method="POST">
        @csrf
        <button type="submit">PDF Oluştur</button>
    </form>

    @if($pdfUrl)
        <p><a href="{{ $pdfUrl }}" target="_blank">PDF Görüntüle/İndir (public)</a></p>
    @endif

    @if($signedPdfUrl)
        <p><a href="{{ $signedPdfUrl }}" target="_blank">7 Gün Geçerli Signed URL</a></p>
    @endif

    <p><a href="{{ $whatsAppLink }}" target="_blank">WhatsApp ile Paylaş</a></p>

    <form action="{{ route('admin.corporate-offers.mark-sent', $offer) }}" method="POST">
        @csrf
        <button type="submit">Gönderildi işaretle</button>
    </form>
@endsection
