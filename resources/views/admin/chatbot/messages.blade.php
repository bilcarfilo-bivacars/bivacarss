@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $flow->name }} - Mesajlar</h1>
    <a href="{{ route('admin.chatbot.flows.index') }}" class="btn btn-sm btn-light">← Flow Listesi</a>

    @if(session('status'))
        <div class="alert alert-success mt-3">{{ session('status') }}</div>
    @endif

    <h2 class="mt-4">Yeni Mesaj</h2>
    <form action="{{ route('admin.chatbot.messages.store', $flow) }}" method="POST">
        @csrf
        <input type="text" name="trigger" placeholder="trigger" required>
        <textarea name="reply_text" placeholder="reply_text" required></textarea>
        <select name="reply_type">
            <option value="text">text</option>
            <option value="template">template</option>
            <option value="link">link</option>
        </select>
        <input type="text" name="meta_json" placeholder="meta_json">
        <input type="number" name="sort_order" placeholder="sort_order" value="0">
        <label><input type="checkbox" name="active" value="1" checked> Aktif</label>
        <button type="submit">Kaydet</button>
    </form>

    <h2 class="mt-4">Mevcut Mesajlar</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Trigger</th>
                <th>Reply</th>
                <th>Tip</th>
                <th>Sıra</th>
                <th>Aktif</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($messages as $message)
                <tr>
                    <form action="{{ route('admin.chatbot.messages.update', [$flow, $message]) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <td><input type="text" name="trigger" value="{{ $message->trigger }}" required></td>
                        <td><textarea name="reply_text" required>{{ $message->reply_text }}</textarea></td>
                        <td>
                            <select name="reply_type">
                                @foreach(['text','template','link'] as $type)
                                    <option value="{{ $type }}" @selected($message->reply_type === $type)>{{ $type }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td><input type="number" name="sort_order" value="{{ $message->sort_order }}"></td>
                        <td><input type="checkbox" name="active" value="1" @checked($message->active)></td>
                        <td>
                            <input type="text" name="meta_json" value="{{ $message->meta_json }}" placeholder="meta_json">
                            <button type="submit">Güncelle</button>
                        </td>
                    </form>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
