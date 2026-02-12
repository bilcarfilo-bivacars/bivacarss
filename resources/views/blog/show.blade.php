@extends('layouts.app')

@section('title', $post->seo_title ?: $post->title)

@section('meta')
    <meta name="description" content="{{ $post->seo_description }}">
    @if($post->canonical_url)
        <link rel="canonical" href="{{ $post->canonical_url }}">
    @endif
    <script type="application/ld+json">
        {!! $post->schema_json ?: json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => $post->title,
            'description' => $post->seo_description ?: $post->excerpt,
            'datePublished' => optional($post->published_at)->toIso8601String(),
            'author' => ['@type' => 'Person', 'name' => optional($post->author)->name],
        ], JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT) !!}
    </script>
@endsection

@section('content')
    <article>
        <h1>{{ $post->title }}</h1>
        {!! nl2br(e($post->content)) !!}
    </article>
@endsection
