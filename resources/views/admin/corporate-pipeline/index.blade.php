@extends('layouts.admin')

@section('content')
    <h1>Kurumsal Pipeline</h1>

    <form method="GET" class="mb-3">
        <label>Pipeline Stage
            <select name="pipeline_stage">
                <option value="">Tümü</option>
                @foreach(['new','contacted','qualified','proposal_sent','won','lost'] as $pipeline)
                    <option value="{{ $pipeline }}" @selected($stage === $pipeline)>{{ $pipeline }}</option>
                @endforeach
            </select>
        </label>
        <button type="submit">Filtrele</button>
    </form>

    <table>
        <thead>
        <tr>
            <th>Pipeline</th>
            <th>Şirket</th>
            <th>Vehicles Needed</th>
            <th>Budget Monthly</th>
            <th>Lead Score / Grade</th>
            <th>Aksiyon</th>
        </tr>
        </thead>
        <tbody>
        @foreach($leases as $lease)
            <tr>
                <td>{{ $lease->pipeline_stage }}</td>
                <td>{{ $lease->company_name }}</td>
                <td>{{ optional($lease->sourceLead)->vehicles_needed ?? '-' }}</td>
                <td>{{ optional($lease->sourceLead)->budget_monthly ? number_format($lease->sourceLead->budget_monthly, 2, ',', '.') . ' TL' : '-' }}</td>
                <td>
                    @if($lease->sourceLead)
                        {{ $lease->sourceLead->lead_score }} / {{ $lease->sourceLead->lead_grade }}
                    @else
                        -
                    @endif
                </td>
                <td>
                    @if($lease->source_lead_id)
                        <a href="{{ route('admin.corporate-leads.show', $lease->source_lead_id) }}">Detay</a>
                    @endif
                    <a href="{{ route('admin.corporate-leases.edit', $lease) }}">Lease</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $leases->links() }}
@endsection
