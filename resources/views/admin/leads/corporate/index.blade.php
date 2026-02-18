@extends('layouts.app')

@section('title', 'Kurumsal Leadler')

@section('content')
<div class="container py-4">
    <h1 class="h4 mb-3">Kurumsal Leadler</h1>

    <form method="GET" class="row g-2 mb-3">
        <div class="col-md-3"><input class="form-control" name="status" placeholder="status" value="{{ $status }}"></div>
        <div class="col-md-3"><input class="form-control" name="grade" placeholder="grade" value="{{ $grade }}"></div>
        <div class="col-md-3"><input class="form-control" name="min_score" type="number" placeholder="min score" value="{{ request('min_score') }}"></div>
        <div class="col-md-3"><button class="btn btn-primary">Filtrele</button></div>
    </form>

    <table class="table table-striped">
        <thead><tr><th>ID</th><th>Şirket</th><th>Skor</th><th>Grade</th><th>Status</th><th></th></tr></thead>
        <tbody>
        @foreach($leads as $lead)
            <tr>
                <td>{{ $lead->id }}</td>
                <td>{{ $lead->company_name }}</td>
                <td><span class="badge bg-primary">{{ $lead->lead_score }}</span></td>
                <td><span class="badge {{ $lead->lead_grade === 'high' ? 'bg-success' : ($lead->lead_grade === 'medium' ? 'bg-warning text-dark' : 'bg-secondary') }}">{{ $lead->lead_grade }}</span></td>
                <td><span class="badge bg-info text-dark">{{ $lead->status }}</span></td>
                <td><a href="{{ route('admin.corporate-leads.show', $lead->id) }}" class="btn btn-sm btn-outline-dark">Detay</a></td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $leads->links() }}
</div>
@endsection
