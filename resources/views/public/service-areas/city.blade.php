@extends('layouts.app')

@section('content')
<main>
    <h1>{{ $meta['h1'] }}</h1>
    <div class="grid">
        @foreach($city->districts as $district)
            <article>
                <h2>{{ $district->name }}</h2>
                <a href="{{ route('service-areas.district', [$city->slug, $district->slug]) }}">İlçeyi İncele</a>
            </article>
        @endforeach
    </div>
    <details>
        <summary>Tüm Noktalar (Popup yerine minimal modal alternatifi)</summary>
        <ul>
            @foreach($city->points as $point)
                <li>{{ $point->name }} ({{ $point->type }})</li>
            @endforeach
        </ul>
    </details>
    <p><a href="https://wa.me/905000000000">WhatsApp</a> | <a href="tel:+905000000000">Telefon</a></p>
</main>
@endsection

@section('jsonld')
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'LocalBusiness',
    'name' => 'BivaCars',
    'url' => request()->url(),
    'areaServed' => $city->name,
], JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT) !!}
</script>
@endsection
