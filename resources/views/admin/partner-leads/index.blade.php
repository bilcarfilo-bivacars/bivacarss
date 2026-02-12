@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="h3 mb-3">Partner Lead Listesi</h1>

    <form method="GET" class="row g-2 mb-3">
        <div class="col-md-4">
            <select class="form-select" name="status">
                <option value="">Tüm Durumlar</option>
                @foreach(['new' => 'New', 'contacted' => 'Contacted', 'converted' => 'Converted', 'archived' => 'Archived'] as $value => $label)
                    <option value="{{ $value }}" @selected($status === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary">Filtrele</button>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Ad Soyad</th>
                    <th>Telefon</th>
                    <th>Şehir</th>
                    <th>Durum</th>
                    <th>Tarih</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($leads as $lead)
                    <tr>
                        <td>{{ $lead->id }}</td>
                        <td>{{ $lead->full_name }}</td>
                        <td>{{ $lead->phone }}</td>
                        <td>{{ $lead->city }}</td>
                        <td>{{ $lead->status }}</td>
                        <td>{{ $lead->created_at }}</td>
                        <td><a href="{{ route('admin.partner-leads.show', $lead->id) }}" class="btn btn-sm btn-outline-primary">Detay</a></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">Kayıt bulunamadı.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $leads->links() }}
</div>
@endsection
