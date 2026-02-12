@extends('layouts.app')

@section('content')
<main>
    <nav>
        <a href="{{ route('service-areas.index') }}">Hizmet Bölgeleri</a> /
        <a href="{{ route('service-areas.city', $point->city->slug) }}">{{ $point->city->name }}</a> /
        <a href="{{ route('service-areas.district', [$point->city->slug, $point->district->slug]) }}">{{ $point->district->name }}</a> /
        <span>{{ $point->name }}</span>
    </nav>

    <h1>{{ $meta['h1'] }}</h1>
    <div>{!! $meta['content'] ?: '<p>' . e($point->name) . ' çevresinde araç teslim ve iade noktalarıyla esnek kiralama deneyimi.</p>' !!}</div>

    <p><strong>Adres:</strong> {{ $point->address ?: 'Bilgi yakında eklenecek.' }}</p>
    <p><a href="https://wa.me/905000000000">WhatsApp</a> | <a href="tel:+905000000000">Telefon</a></p>
</main>
@endsection

@section('jsonld')
@php
    $defaultSchema = [
        ['@context' => 'https://schema.org', '@type' => 'LocalBusiness', 'name' => 'BivaCars', 'areaServed' => $point->district->name],
        ['@context' => 'https://schema.org', '@type' => 'Service', 'name' => 'Araç Kiralama', 'areaServed' => $point->district->name],
        ['@context' => 'https://schema.org', '@type' => 'Place', 'name' => $point->name, 'address' => $point->address],
        ['@context' => 'https://schema.org', '@type' => 'BreadcrumbList', 'itemListElement' => [
            ['@type' => 'ListItem', 'position' => 1, 'name' => 'Hizmet Bölgeleri', 'item' => route('service-areas.index')],
            ['@type' => 'ListItem', 'position' => 2, 'name' => $point->city->name, 'item' => route('service-areas.city', $point->city->slug)],
            ['@type' => 'ListItem', 'position' => 3, 'name' => $point->district->name, 'item' => route('service-areas.district', [$point->city->slug, $point->district->slug])],
            ['@type' => 'ListItem', 'position' => 4, 'name' => $point->name, 'item' => request()->url()],
        ]],
    ];

    if ($point->lat && $point->lng) {
        $defaultSchema[2]['geo'] = ['@type' => 'GeoCoordinates', 'latitude' => $point->lat, 'longitude' => $point->lng];
    }

    $schema = $meta['schema_override'] ? json_decode($meta['schema_override'], true) : $defaultSchema;
@endphp
<script type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT) !!}</script>
@endsection
