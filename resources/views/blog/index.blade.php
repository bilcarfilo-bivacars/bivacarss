@extends('layouts.app')

@section('title', 'Blog')

@section('content')
    <h1>Blog</h1>
    @foreach ($posts as $post)
        <article>
            <h2><a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a></h2>
            <p>{{ $post->excerpt }}</p>
        </article>
    @endforeach

    {{ $posts->links() }}
@endsection
