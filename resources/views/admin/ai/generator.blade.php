@extends('layouts.app')

@section('title', 'AI İçerik Üretici')

@section('content')
    <h1>AI İçerik Üretici</h1>

    @if($apiKeyMissing)
        <p style="color: red;">OPENAI_API_KEY eksik. Lütfen .env dosyasını kontrol edin.</p>
    @endif

    <form method="POST" action="{{ route('admin.ai.generate') }}">
        @csrf
        <label>Başlık <input type="text" name="title" value="{{ old('title') }}"></label>
        <label>Şehir / İlçe <input type="text" name="city" value="{{ old('city') }}"></label>
        <label>Anahtar Kelime <input type="text" name="keyword" value="{{ old('keyword') }}"></label>
        <label>Prompt
            <select name="prompt_key">
                @foreach($prompts as $prompt)
                    <option value="{{ $prompt->key }}" @selected(old('prompt_key') === $prompt->key)>{{ $prompt->name }}</option>
                @endforeach
            </select>
        </label>
        <button type="submit">Üret</button>
    </form>

    <form method="POST" action="{{ route('admin.ai.create-draft') }}">
        @csrf
        <input type="hidden" name="title" value="{{ old('title') }}">
        <textarea name="generated_content" rows="20">{{ session('generated_content', $generated) }}</textarea>
        <button type="submit">Blog taslağı oluştur</button>
    </form>
@endsection
