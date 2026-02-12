@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="text-primary mb-4">Admin - Referral Talepleri</h1>

    <div class="card border-primary-subtle">
        <div class="card-body">
            <table class="table align-middle">
                <thead><tr><th>Partner</th><th>Firma</th><th>Kişi</th><th>Durum</th><th>İşlem</th></tr></thead>
                <tbody>
                    @forelse($claims as $claim)
                        <tr>
                            <td>{{ $claim->partner->company_name ?? '-' }}</td>
                            <td>{{ $claim->company_name ?: '-' }}</td>
                            <td>{{ $claim->contact_name ?: '-' }}</td>
                            <td><span class="badge bg-{{ $claim->status === 'approved' ? 'success' : ($claim->status === 'rejected' ? 'danger' : 'primary') }}">{{ $claim->status }}</span></td>
                            <td class="d-flex gap-2">
                                @if($claim->status === 'pending')
                                    <form method="POST" action="{{ route('admin.referrals.approve', $claim) }}">
                                        @csrf
                                        @method('PUT')
                                        <button class="btn btn-sm btn-success">Approve</button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.referrals.reject', $claim) }}">
                                        @csrf
                                        @method('PUT')
                                        <button class="btn btn-sm btn-outline-danger">Reject</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-muted">Kayıt bulunamadı.</td></tr>
                    @endforelse
                </tbody>
            </table>
            {{ $claims->links() }}
        </div>
    </div>
</div>
@endsection
