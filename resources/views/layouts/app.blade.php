<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', config('bivacars.company_name')) }}</title>
</head>
<body>
    <main>
        @yield('content')
    </main>

    <footer>
        <h2>{{ config('bivacars.company_name') }}</h2>
        <ul>
            <li>
                Telefon:
                <a href="tel:{{ config('bivacars.phone_e164') }}">{{ config('bivacars.phone_display') }}</a>
            </li>
            <li>
                E-posta:
                <a href="mailto:{{ config('bivacars.email') }}">{{ config('bivacars.email') }}</a>
            </li>
            <li>Adres: {{ config('bivacars.address') }}</li>
            <li>
                <a href="{{ config('bivacars.maps_url') }}" target="_blank" rel="noopener noreferrer">Haritada Gör</a>
            </li>
        </ul>
    </footer>

    @php
        $companyName = config('bivacars.company_name');
        $companyUrl = url('/');
        $telephone = config('bivacars.phone_e164');
        $email = config('bivacars.email');
        $address = config('bivacars.address');
        $mapUrl = config('bivacars.maps_url');
    @endphp

    <script type="application/ld+json">
        {!! json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'LocalBusiness',
            'name' => $companyName,
            'url' => $companyUrl,
            'telephone' => $telephone,
            'email' => $email,
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => $address,
            ],
            'hasMap' => $mapUrl,
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>
</body>
</html>
