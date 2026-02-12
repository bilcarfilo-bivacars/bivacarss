@extends('layouts.app')

@section('content')
<article class="mx-auto max-w-3xl p-6">
    <img
        src="{{ $post->cover_url }}"
        alt="{{ $post->title }}"
        width="1200"
        height="630"
        loading="lazy"
        decoding="async"
        class="mb-6 h-auto w-full rounded-xl object-cover"
    >
    <h1 class="text-3xl font-bold">{{ $post->title }}</h1>
    <div class="prose mt-6">{!! $post->content !!}</div>
</article>
@endsection
