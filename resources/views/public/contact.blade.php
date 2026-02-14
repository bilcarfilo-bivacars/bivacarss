@extends('layouts.app')

@section('title', 'İletişim | BivaCars')
@section('meta_description', 'BivaCars Gebze araç kiralama iletişim. WhatsApp/Telefon ile hızlı rezervasyon.')

@section('content')
<div class="mx-auto max-w-5xl px-4 py-12 sm:px-6 lg:px-8">
    <h1 class="mb-8 text-3xl font-bold text-slate-900">İletişim</h1>

    <div class="grid gap-4 md:grid-cols-3">
        <div class="rounded-2xl border border-blue-100 bg-blue-50 p-5 shadow-sm">
            <h2 class="text-sm font-semibold uppercase tracking-wide text-blue-700">Telefon</h2>
            <a href="tel:{{ preg_replace('/\D+/', '', $phone) }}" class="mt-2 block text-lg font-semibold text-slate-900 hover:text-blue-700">
                {{ $phone }}
            </a>
        </div>

        <div class="rounded-2xl border border-blue-100 bg-blue-50 p-5 shadow-sm">
            <h2 class="text-sm font-semibold uppercase tracking-wide text-blue-700">E-posta</h2>
            <a href="mailto:{{ $email }}" class="mt-2 block text-lg font-semibold text-slate-900 hover:text-blue-700">
                {{ $email }}
            </a>
        </div>

        <div class="rounded-2xl border border-blue-100 bg-blue-50 p-5 shadow-sm">
            <h2 class="text-sm font-semibold uppercase tracking-wide text-blue-700">Adres</h2>
            <p class="mt-2 text-base font-medium text-slate-900">{{ $address }}</p>
        </div>
    </div>

    <div class="mt-8 flex flex-wrap items-center gap-3">
        <button id="loadMapBtn" type="button" class="rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
            Haritayı Göster
        </button>

        <a href="{{ $maps_url }}" target="_blank" rel="noopener" class="rounded-xl border border-blue-200 bg-white px-5 py-3 text-sm font-semibold text-blue-700 transition hover:bg-blue-50">
            Yol tarifi
        </a>
    </div>

    <div id="mapContainer" class="mt-6 hidden overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        {!! $maps_embed_html !!}
    </div>
</div>

<script>
    const loadMapBtn = document.getElementById('loadMapBtn');
    const mapContainer = document.getElementById('mapContainer');

    loadMapBtn?.addEventListener('click', () => {
        mapContainer?.classList.remove('hidden');
        loadMapBtn.classList.add('hidden');
    });
</script>
@endsection
