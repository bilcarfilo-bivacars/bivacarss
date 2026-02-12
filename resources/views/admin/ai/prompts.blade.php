@extends('layouts.app')

@section('title', 'AI Prompt Yönetimi')

@section('content')
    <h1>Prompt Yönetimi</h1>

    <h2>Yeni Prompt</h2>
    <form method="POST" action="{{ route('admin.ai-prompts.store') }}">
        @csrf
        @include('admin.ai.prompt-fields')
        <button type="submit">Kaydet</button>
    </form>

    <h2>Mevcut Promptlar</h2>
    @foreach($prompts as $prompt)
        <form method="POST" action="{{ route('admin.ai-prompts.update', $prompt->id) }}">
            @csrf
            @method('PUT')
            @include('admin.ai.prompt-fields', ['row' => $prompt])
            <button type="submit">Güncelle</button>
        </form>

        <form method="POST" action="{{ route('admin.ai-prompts.destroy', $prompt->id) }}">
            @csrf
            @method('DELETE')
            <button type="submit">Sil</button>
        </form>
    @endforeach

    {{ $prompts->links() }}
@endsection
