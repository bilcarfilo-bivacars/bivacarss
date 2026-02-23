<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Operasyon Paneli</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-slate-50 text-slate-900">
<div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
    <header class="mb-6 rounded-xl border border-blue-100 bg-white p-5 shadow-sm">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-blue-800">Operasyon Paneli</h1>
                <p class="mt-1 text-sm text-slate-600">Bugünkü durum / hızlı aksiyon</p>
            </div>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button class="rounded-lg bg-blue-700 px-4 py-2 text-sm font-medium text-white hover:bg-blue-800">Çıkış Yap</button>
            </form>
        </div>
    </header>

    <section class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
        @php
            $cards = [
                ['label' => 'Bugünkü Partner Lead', 'value' => $metrics['today_partner_leads_count'] ?? 0, 'meta' => 'bugün'],
                ['label' => 'Bugünkü Corporate Lead', 'value' => $metrics['today_corporate_leads_count'] ?? 0, 'meta' => 'bugün'],
                ['label' => 'High Value Lead', 'value' => $metrics['high_value_leads_count'] ?? 0, 'meta' => 'son 30 gün'],
                ['label' => 'Aktif Araç', 'value' => $metrics['active_vehicles_count'] ?? 0, 'meta' => 'listing_status=active'],
                ['label' => 'Öne Çıkan Araç', 'value' => $metrics['featured_vehicles_count'] ?? 0, 'meta' => 'aktif + featured'],
                ['label' => 'Bekleyen Fiyat Talebi', 'value' => $metrics['pending_price_requests_count'] ?? 0, 'meta' => 'acil takip'],
                ['label' => 'Aktif Kurumsal Lease', 'value' => $metrics['active_corporate_leases_count'] ?? 0, 'meta' => 'status=active'],
                ['label' => 'Bekleyen Ödeme', 'value' => $metrics['pending_payments_count'] ?? 0, 'meta' => 'pending'],
            ];
        @endphp
        @foreach($cards as $card)
            <article class="rounded-xl border border-blue-100 bg-white p-4 shadow-sm">
                <p class="text-xs uppercase tracking-wide text-blue-700">{{ $card['label'] }}</p>
                <p class="mt-2 text-2xl font-semibold text-slate-900">{{ number_format((float) $card['value'], 0, ',', '.') }}</p>
                <p class="mt-1 text-xs text-slate-500">{{ $card['meta'] }}</p>
            </article>
        @endforeach
    </section>

    <section class="mb-6 grid grid-cols-1 gap-4 lg:grid-cols-3">
        <article class="rounded-xl border border-blue-100 bg-white p-5 shadow-sm lg:col-span-2">
            <h2 class="text-lg font-semibold text-blue-800">Aylık Gelir Tahmini</h2>
            <p class="mt-2 text-3xl font-bold text-slate-900">{{ number_format((float) ($metrics['monthly_revenue_estimate'] ?? 0), 2, ',', '.') }} TL</p>
            <p class="mt-1 text-xs text-slate-500">Aktif corporate lease toplam aylık bedeli.</p>
        </article>

        <article class="rounded-xl border border-blue-100 bg-white p-5 shadow-sm">
            <h2 class="text-lg font-semibold text-blue-800">Dönüşüm İpucu</h2>
            <p class="mt-2 text-sm text-slate-700">
                Son 30 gün: <strong>{{ $metrics['conversion_rate_hint']['converted_count'] ?? 0 }}</strong> /
                <strong>{{ $metrics['conversion_rate_hint']['total_count'] ?? 0 }}</strong>
            </p>
            <p class="mt-1 text-sm text-slate-700">
                Oran: <strong>{{ $metrics['conversion_rate_hint']['rate'] !== null ? number_format((float) $metrics['conversion_rate_hint']['rate'], 2, ',', '.') . '%' : '—' }}</strong>
            </p>
        </article>
    </section>

    <section class="mb-6 rounded-xl border border-blue-100 bg-white p-5 shadow-sm">
        <h2 class="text-lg font-semibold text-blue-800">Acil İşler</h2>
        <div class="mt-4 flex flex-wrap gap-3">
            @if(($metrics['pending_price_requests_count'] ?? 0) > 0)
                <a href="{{ route('admin.corporate-leases.index') }}" class="rounded-lg bg-blue-700 px-4 py-2 text-sm font-medium text-white hover:bg-blue-800">Fiyat Taleplerine Git</a>
            @endif

            @if(($metrics['high_value_leads_count'] ?? 0) > 0)
                <a href="{{ route('admin.corporate-leads.index', ['grade' => 'high']) }}" class="rounded-lg border border-blue-300 px-4 py-2 text-sm font-medium text-blue-700 hover:bg-blue-50">High Lead’leri Gör</a>
            @endif

            <a href="{{ route('admin.corporate-pipeline.index') }}" class="rounded-lg border border-blue-300 px-4 py-2 text-sm font-medium text-blue-700 hover:bg-blue-50">Bekleyen Araç Onayları</a>
        </div>
    </section>

    <section class="mb-6 rounded-xl border border-blue-100 bg-white p-5 shadow-sm">
        <h2 class="text-lg font-semibold text-blue-800">Son Corporate Lead’ler</h2>
        <div class="mt-4 overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50">
                <tr>
                    <th class="px-3 py-2 text-left">Tarih</th><th class="px-3 py-2 text-left">Firma</th><th class="px-3 py-2 text-left">Telefon</th>
                    <th class="px-3 py-2 text-left">Score</th><th class="px-3 py-2 text-left">Grade</th><th class="px-3 py-2 text-left">Status</th><th class="px-3 py-2 text-left">Aksiyon</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                @forelse($recentCorporateLeads as $lead)
                    <tr>
                        <td class="px-3 py-2">{{ $lead->created_at?->format('d.m.Y H:i') }}</td>
                        <td class="px-3 py-2">{{ $lead->company_name }}</td>
                        <td class="px-3 py-2">{{ $lead->contact_phone }}</td>
                        <td class="px-3 py-2">{{ $lead->lead_score }}</td>
                        <td class="px-3 py-2">{{ $lead->lead_grade }}</td>
                        <td class="px-3 py-2">{{ $lead->status }}</td>
                        <td class="px-3 py-2">
                            <a class="text-blue-700 hover:underline" href="{{ route('admin.corporate-leads.show', $lead->id) }}">Detay</a>
                            @if(Route::has('admin.corporate-leads.convert-to-lease'))
                                <form class="inline" method="POST" action="{{ route('admin.corporate-leads.convert-to-lease', $lead->id) }}">
                                    @csrf
                                    <button class="ml-2 text-blue-700 hover:underline">Lease’e Çevir</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="px-3 py-3 text-center text-slate-500">Kayıt yok.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <section class="mb-6 rounded-xl border border-blue-100 bg-white p-5 shadow-sm">
        <h2 class="text-lg font-semibold text-blue-800">Son Partner Lead’ler</h2>
        <div class="mt-4 overflow-x-auto">
            @php
                $partnerHasExpectedRent = \Illuminate\Support\Facades\Schema::hasColumn('partner_leads', 'expected_rent');
                $partnerHasDamage = \Illuminate\Support\Facades\Schema::hasColumn('partner_leads', 'has_damage');
            @endphp
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50">
                <tr>
                    <th class="px-3 py-2 text-left">Tarih</th><th class="px-3 py-2 text-left">Ad</th><th class="px-3 py-2 text-left">Telefon</th>
                    <th class="px-3 py-2 text-left">Şehir</th><th class="px-3 py-2 text-left">Araç</th><th class="px-3 py-2 text-left">Expected Rent</th>
                    <th class="px-3 py-2 text-left">Has Damage</th><th class="px-3 py-2 text-left">Score/Grade</th><th class="px-3 py-2 text-left">Status</th><th class="px-3 py-2 text-left">Detay</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                @forelse($recentPartnerLeads as $lead)
                    <tr>
                        <td class="px-3 py-2">{{ $lead->created_at?->format('d.m.Y H:i') }}</td>
                        <td class="px-3 py-2">{{ $lead->full_name }}</td>
                        <td class="px-3 py-2">{{ $lead->phone }}</td>
                        <td class="px-3 py-2">{{ $lead->city ?? '—' }}</td>
                        <td class="px-3 py-2">{{ trim(($lead->brand ?? '') . ' ' . ($lead->model ?? '')) ?: '—' }}</td>
                        <td class="px-3 py-2">{{ $partnerHasExpectedRent && isset($lead->expected_rent) ? number_format((float) $lead->expected_rent, 2, ',', '.') . ' TL' : '—' }}</td>
                        <td class="px-3 py-2">{{ $partnerHasDamage && isset($lead->has_damage) ? ($lead->has_damage ? 'Evet' : 'Hayır') : '—' }}</td>
                        <td class="px-3 py-2">{{ $lead->lead_score }} / {{ $lead->lead_grade }}</td>
                        <td class="px-3 py-2">{{ $lead->status }}</td>
                        <td class="px-3 py-2"><a class="text-blue-700 hover:underline" href="{{ route('admin.partner-leads.show', $lead->id) }}">Detay</a></td>
                    </tr>
                @empty
                    <tr><td colspan="10" class="px-3 py-3 text-center text-slate-500">Kayıt yok.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <section class="rounded-xl border border-blue-100 bg-white p-5 shadow-sm">
        <h2 class="text-lg font-semibold text-blue-800">Son Corporate Lease’ler</h2>
        <div class="mt-4 overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50">
                <tr>
                    <th class="px-3 py-2 text-left">Firma</th><th class="px-3 py-2 text-left">Model</th><th class="px-3 py-2 text-left">KM</th>
                    <th class="px-3 py-2 text-left">Fiyat</th><th class="px-3 py-2 text-left">Payment Status</th><th class="px-3 py-2 text-left">Aksiyon</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                @forelse($recentLeases as $lease)
                    <tr>
                        <td class="px-3 py-2">{{ $lease->company_name }}</td>
                        <td class="px-3 py-2">{{ optional($lease->model)->brand }} {{ optional($lease->model)->model }}</td>
                        <td class="px-3 py-2">{{ optional($lease->matchedVehicle)->km ? number_format((int) optional($lease->matchedVehicle)->km, 0, ',', '.') : '—' }}</td>
                        <td class="px-3 py-2">{{ number_format((float) $lease->monthly_price, 2, ',', '.') }} TL</td>
                        <td class="px-3 py-2">{{ $lease->payment_status }}</td>
                        <td class="px-3 py-2">
                            <form method="POST" action="{{ route('admin.corporate-leases.mark-paid', $lease->id) }}">
                                @csrf
                                <button class="text-blue-700 hover:underline" type="submit">Ödendi işaretle</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-3 py-3 text-center text-slate-500">Kayıt yok.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>
</body>
</html>
