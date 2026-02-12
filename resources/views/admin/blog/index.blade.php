@extends('layouts.app')

@section('title', 'Admin Blog')

@section('content')
    <h1>Blog Yönetimi</h1>
    <a href="{{ route('admin.blog.create') }}">Yeni Yazı</a>

    <table>
        <thead>
        <tr>
            <th>Başlık</th>
            <th>Durum</th>
            <th>Yayın Tarihi</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($posts as $post)
            <tr>
                <td>{{ $post->title }}</td>
                <td>{{ $post->status }}</td>
                <td>{{ optional($post->published_at)->format('d.m.Y H:i') }}</td>
                <td><a href="{{ route('admin.blog.edit', $post->id) }}">Düzenle</a></td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $posts->links() }}
@endsection
