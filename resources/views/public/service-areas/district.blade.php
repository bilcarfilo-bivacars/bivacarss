@extends('layouts.app')

@section('content')
<main>
    <nav>
        <a href="{{ route('service-areas.index') }}">Hizmet Bölgeleri</a> /
        <a href="{{ route('service-areas.city', $district->city->slug) }}">{{ $district->city->name }}</a> /
        <span>{{ $district->name }}</span>
    </nav>

    <h1>{{ $meta['h1'] }}</h1>
    <div>{!! $meta['content'] ?: '<p>' . e($district->name) . ' bölgesinde araç kiralama, günlük ve kurumsal teslimat seçenekleriyle sunulur.</p>' !!}</div>

    <h2>İlgili Lokasyon Noktaları</h2>
    <ul>
        @foreach($district->points as $point)
            <li><a href="{{ route('service-areas.point', [$district->city->slug, $district->slug, $point->slug]) }}">{{ $point->name }}</a></li>
        @endforeach
    </ul>

    <p><a href="https://wa.me/905000000000">WhatsApp ile Rezervasyon</a></p>
    <p><a href="tel:+905000000000">Telefonla Hızlı Destek</a></p>
</main>
@endsection

@section('jsonld')
@php
    $breadcrumb = [
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => [
            ['@type' => 'ListItem', 'position' => 1, 'name' => 'Hizmet Bölgeleri', 'item' => route('service-areas.index')],
            ['@type' => 'ListItem', 'position' => 2, 'name' => $district->city->name, 'item' => route('service-areas.city', $district->city->slug)],
            ['@type' => 'ListItem', 'position' => 3, 'name' => $district->name, 'item' => request()->url()],
        ],
    ];

    $schema = $meta['schema_override']
        ? json_decode($meta['schema_override'], true)
        : [
            ['@context' => 'https://schema.org', '@type' => 'LocalBusiness', 'name' => 'BivaCars', 'areaServed' => $district->name],
            ['@context' => 'https://schema.org', '@type' => 'Service', 'name' => 'Araç Kiralama', 'areaServed' => $district->name],
            $breadcrumb,
        ];
@endphp
<script type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT) !!}</script>
@endsection
