@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="text-primary mb-4">Admin - Bakım Takibi</h1>

    <div class="card mb-4 border-primary-subtle">
        <div class="card-header bg-primary-subtle">Yeni Kayıt</div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.maintenance.store') }}" class="row g-3">
                @csrf
                <div class="col-md-3">
                    <select class="form-select" name="vehicle_id" required>
                        <option value="">Araç seçin</option>
                        @foreach($vehicles as $vehicle)
                            <option value="{{ $vehicle->id }}">{{ $vehicle->plate }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3"><input class="form-control" name="type" placeholder="type" required></div>
                <div class="col-md-3"><input class="form-control" name="title" placeholder="başlık" required></div>
                <div class="col-md-3"><input class="form-control" name="due_date" type="date"></div>
                <div class="col-md-3"><input class="form-control" name="cost_estimate" type="number" step="0.01" placeholder="Maliyet"></div>
                <div class="col-12"><button class="btn btn-primary">Kaydet</button></div>
            </form>
        </div>
    </div>

    <div class="card border-primary-subtle">
        <div class="card-body">
            <table class="table align-middle">
                <thead><tr><th>Araç</th><th>Başlık</th><th>Tür</th><th>Termin</th><th>Durum</th><th></th></tr></thead>
                <tbody>
                @forelse($records as $record)
                    <tr>
                        <td>{{ $record->vehicle->plate ?? '-' }}</td>
                        <td>{{ $record->title }}</td>
                        <td>{{ $record->type }}</td>
                        <td>{{ optional($record->due_date)->format('d.m.Y') ?: '-' }}</td>
                        <td><span class="badge bg-{{ $record->status === 'done' ? 'success' : 'primary' }}">{{ $record->status }}</span></td>
                        <td>
                            @if($record->status !== 'done')
                            <form method="POST" action="{{ route('admin.maintenance.done', $record) }}">
                                @csrf
                                @method('PATCH')
                                <button class="btn btn-sm btn-outline-success">Done</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-muted">Kayıt yok.</td></tr>
                @endforelse
                </tbody>
            </table>
            {{ $records->links() }}
        </div>
    </div>
</div>
@endsection
