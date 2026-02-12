@extends('layouts.app')

@section('title', 'İletişim')

@push('styles')
<style>
    .contact-card {
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 8px 30px rgba(15, 23, 42, 0.08);
        padding: 1.5rem;
    }

    .contact-grid {
        display: grid;
        gap: 1rem;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        margin-bottom: 1.25rem;
    }

    .contact-item {
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 1rem;
        overflow-wrap: anywhere;
    }

    .contact-item h3 {
        margin: 0 0 .4rem;
        font-size: 0.95rem;
        color: #374151;
    }

    .contact-item p,
    .contact-item a {
        margin: 0;
        font-size: 0.98rem;
        color: #111827;
        text-decoration: none;
    }

    .map-action {
        display: flex;
        flex-wrap: wrap;
        gap: .75rem;
        align-items: center;
        margin-bottom: 1rem;
    }

    .btn {
        border: 0;
        border-radius: 10px;
        padding: .75rem 1rem;
        cursor: pointer;
        font-size: .95rem;
        font-weight: 600;
    }

    .btn-primary {
        background: #111827;
        color: #fff;
    }

    .btn-secondary {
        background: #e5e7eb;
        color: #111827;
    }

    .map-wrapper {
        display: none;
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid #e5e7eb;
        background: #f3f4f6;
    }

    .map-wrapper.is-visible {
        display: block;
    }

    @media (max-width: 768px) {
        .contact-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
    <main class="container">
        <section class="contact-card">
            <h1>İletişim</h1>
            <p>Bize aşağıdaki iletişim kanallarından ulaşabilirsiniz.</p>

            <div class="contact-grid">
                <article class="contact-item">
                    <h3>Telefon</h3>
                    <a href="tel:{{ preg_replace('/\s+/', '', $phoneDisplay) }}">{{ $phoneDisplay }}</a>
                </article>
                <article class="contact-item">
                    <h3>E-posta</h3>
                    <a href="mailto:{{ $email }}">{{ $email }}</a>
                </article>
                <article class="contact-item">
                    <h3>Adres</h3>
                    <p>{{ $address }}</p>
                </article>
            </div>

            <div class="map-action">
                <button id="showMapButton" class="btn btn-primary" type="button" aria-controls="mapWrapper" aria-expanded="false">
                    Haritayı Göster
                </button>
                <a class="btn btn-secondary" href="{{ $mapsUrl }}" target="_blank" rel="noopener noreferrer">Google Maps'te Aç</a>
            </div>

            <div id="mapWrapper" class="map-wrapper" aria-hidden="true">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3020.545918910522!2d29.419365600000003!3d40.7939959!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14cb21a72fee741f%3A0x731821cb55da8844!2sGebze%20Ara%C3%A7%20Kiralama%20-%20Gebze%20Rent%20A%20Car%20-%20Gebze%20Oto%20Kiralama!5e0!3m2!1str!2str!4v1770816929508!5m2!1str!2str"
                    width="100%"
                    height="450"
                    style="border:0;"
                    allowfullscreen
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </section>
    </main>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var showMapButton = document.getElementById('showMapButton');
        var mapWrapper = document.getElementById('mapWrapper');

        if (!showMapButton || !mapWrapper) {
            return;
        }

        showMapButton.addEventListener('click', function () {
            mapWrapper.classList.add('is-visible');
            mapWrapper.setAttribute('aria-hidden', 'false');
            showMapButton.setAttribute('aria-expanded', 'true');
            showMapButton.disabled = true;
            showMapButton.textContent = 'Harita Yüklendi';
        });
    });
</script>
@endpush
