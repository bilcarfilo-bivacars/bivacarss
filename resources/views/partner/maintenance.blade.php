@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="text-primary mb-4">Bakım Takibi</h1>

    <form class="row g-2 mb-3" method="GET">
        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="">Tümü</option>
                <option value="open" @selected($status==='open')>Open</option>
                <option value="done" @selected($status==='done')>Done</option>
            </select>
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary">Filtrele</button>
        </div>
    </form>

    <div class="card shadow-sm border-primary-subtle">
        <div class="card-body">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Araç</th>
                        <th>Başlık</th>
                        <th>Tür</th>
                        <th>Termin</th>
                        <th>Durum</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($records as $record)
                        <tr>
                            <td>{{ $record->vehicle->plate ?? '-' }}</td>
                            <td>{{ $record->title }}</td>
                            <td>{{ strtoupper($record->type) }}</td>
                            <td>{{ optional($record->due_date)->format('d.m.Y') ?: '-' }}</td>
                            <td>
                                <span class="badge bg-{{ $record->status === 'done' ? 'success' : ($record->status === 'cancelled' ? 'secondary' : 'primary') }}">
                                    {{ $record->status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-muted">Kayıt bulunamadı.</td></tr>
                    @endforelse
                </tbody>
            </table>

            {{ $records->links() }}
        </div>
    </div>
</div>
@endsection
