@extends('layouts.app')

@section('content')
    <section>
        <h1>İletişim</h1>
        <p><strong>{{ config('bivacars.company_name') }}</strong></p>
        <p>
            Telefon:
            <a href="tel:{{ config('bivacars.phone_e164') }}">{{ config('bivacars.phone_display') }}</a>
        </p>
        <p>
            E-posta:
            <a href="mailto:{{ config('bivacars.email') }}">{{ config('bivacars.email') }}</a>
        </p>
        <p>Adres: {{ config('bivacars.address') }}</p>
        <p>
            <a href="{{ config('bivacars.maps_url') }}" target="_blank" rel="noopener noreferrer">Yol Tarifi Al</a>
        </p>
    </section>
@endsection
