@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Chatbot Flow Yönetimi</h1>

    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Anahtar</th>
                <th>Ad</th>
                <th>Durum</th>
                <th>İşlemler</th>
            </tr>
        </thead>
        <tbody>
            @foreach($flows as $flow)
            <tr>
                <td>{{ $flow->id }}</td>
                <td>{{ $flow->key }}</td>
                <td>{{ $flow->name }}</td>
                <td>{{ $flow->active ? 'Aktif' : 'Pasif' }}</td>
                <td>
                    <form action="{{ route('admin.chatbot.flows.toggle', $flow) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-sm btn-primary">Toggle</button>
                    </form>
                    <a href="{{ route('admin.chatbot.messages.index', $flow) }}" class="btn btn-sm btn-secondary">Mesajlar</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
