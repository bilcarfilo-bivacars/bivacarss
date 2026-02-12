@extends('layouts.app')

@section('title', 'Blog Düzenle')

@section('content')
    <h1>{{ $post->exists ? 'Yazı Düzenle' : 'Yeni Yazı' }}</h1>

    <form method="POST" action="{{ $post->exists ? route('admin.blog.update', $post->id) : route('admin.blog.store') }}">
        @csrf
        @if($post->exists)
            @method('PUT')
        @endif

        <label>Başlık <input type="text" name="title" value="{{ old('title', $post->title) }}"></label>
        <label>Slug <input type="text" name="slug" value="{{ old('slug', $post->slug) }}"></label>
        <label>İçerik <textarea name="content" rows="15">{{ old('content', $post->content) }}</textarea></label>
        <label>SEO Title <input type="text" name="seo_title" value="{{ old('seo_title', $post->seo_title) }}"></label>
        <label>SEO Description <textarea name="seo_description">{{ old('seo_description', $post->seo_description) }}</textarea></label>
        <label>Durum
            <select name="status">
                <option value="draft" @selected(old('status', $post->status) === 'draft')>Taslak</option>
                <option value="published" @selected(old('status', $post->status) === 'published')>Yayınlı</option>
            </select>
        </label>
        <label>Yayın Tarihi <input type="datetime-local" name="published_at" value="{{ old('published_at', optional($post->published_at)->format('Y-m-d\TH:i')) }}"></label>

        <button type="submit">Kaydet</button>
    </form>

    @if($post->exists)
        <form method="POST" action="{{ route('admin.blog.publish', $post->id) }}">
            @csrf
            <button type="submit">Yayınla</button>
        </form>
    @endif
@endsection
