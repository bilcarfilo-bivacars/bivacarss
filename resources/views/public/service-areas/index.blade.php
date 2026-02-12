@extends('layouts.app')

@section('content')
<main>
    <h1>Hizmet Bölgeleri</h1>
    <p>İstanbul Anadolu Yakası ve Kocaeli lokasyonlarında hızlı araç kiralama.</p>
    <div class="grid">
        @foreach($cities as $city)
            <article>
                <h2>{{ $city->name }}</h2>
                <p>{{ $city->districts_count }} ilçe</p>
                <a href="{{ route('service-areas.city', $city->slug) }}">Bölgeyi Gör</a>
            </article>
        @endforeach
    </div>
</main>
@endsection
