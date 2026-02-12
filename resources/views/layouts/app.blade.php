<!doctype html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $meta['title'] ?? 'BivaCars' }}</title>
    <meta name="description" content="{{ $meta['description'] ?? 'BivaCars araç kiralama' }}">
    <link rel="canonical" href="{{ $meta['canonical'] ?? request()->url() }}">
    <meta property="og:title" content="{{ data_get($meta, 'og.title', $meta['title'] ?? 'BivaCars') }}">
    <meta property="og:description" content="{{ data_get($meta, 'og.description', '') }}">
    <meta property="og:url" content="{{ data_get($meta, 'og.url', request()->url()) }}">
</head>
<body>
    @yield('content')
    @yield('jsonld')
</body>
</html>
