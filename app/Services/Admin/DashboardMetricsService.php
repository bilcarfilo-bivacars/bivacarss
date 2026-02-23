<?php

namespace App\Services\Admin;

use App\Models\CorporateLead;
use App\Models\CorporateLease;
use App\Models\PartnerLead;
use Closure;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DashboardMetricsService
{
    public function getMetrics(): array
    {
        return Cache::remember('bivacars:dashboard:metrics', now()->addMinutes(5), function (): array {
            $metrics = [
                'today_partner_leads_count' => PartnerLead::query()->whereDate('created_at', today())->count(),
                'today_corporate_leads_count' => CorporateLead::query()->whereDate('created_at', today())->count(),
                'high_value_leads_count' => $this->getHighValueLeadsCount(),
                'active_vehicles_count' => $this->getActiveVehiclesCount(),
                'featured_vehicles_count' => $this->getFeaturedVehiclesCount(),
                'pending_price_requests_count' => $this->getPendingPriceRequestsCount(),
                'active_corporate_leases_count' => CorporateLease::query()->where('status', 'active')->count(),
                'pending_payments_count' => $this->getPendingPaymentsCount(),
                'monthly_revenue_estimate' => (float) CorporateLease::query()->where('status', 'active')->sum('monthly_price'),
            ];

            $metrics['conversion_rate_hint'] = $this->getConversionRateHint();

            return $metrics;
        });
    }

    public function getRecentCorporateLeads(int $limit = 10): Collection
    {
        return $this->rememberRecent('bivacars:dashboard:recent:corporate_leads', function (): Collection {
            return CorporateLead::query()
                ->select(['id', 'company_name', 'contact_phone', 'lead_score', 'lead_grade', 'status', 'created_at', 'converted_to_lease_id'])
                ->latest()
                ->limit(10)
                ->get();
        }, $limit);
    }

    public function getRecentPartnerLeads(int $limit = 10): Collection
    {
        return $this->rememberRecent('bivacars:dashboard:recent:partner_leads', function (): Collection {
            $columns = ['id', 'full_name', 'phone', 'city', 'brand', 'model', 'lead_score', 'lead_grade', 'status', 'created_at'];

            if (Schema::hasColumn('partner_leads', 'expected_rent')) {
                $columns[] = 'expected_rent';
            }

            if (Schema::hasColumn('partner_leads', 'has_damage')) {
                $columns[] = 'has_damage';
            }

            return PartnerLead::query()->select($columns)->latest()->limit(10)->get();
        }, $limit);
    }

    public function getRecentLeases(int $limit = 10): Collection
    {
        return $this->rememberRecent('bivacars:dashboard:recent:leases', function (): Collection {
            return CorporateLease::query()
                ->with(['model:id,brand,model', 'matchedVehicle:id,brand,model,km'])
                ->select(['id', 'company_name', 'corporate_model_id', 'matched_vehicle_id', 'monthly_price', 'payment_status', 'status', 'created_at'])
                ->latest()
                ->limit(10)
                ->get();
        }, $limit);
    }

    private function rememberRecent(string $key, Closure $resolver, int $limit): Collection
    {
        $items = Cache::remember($key, now()->addMinutes(2), $resolver);

        return $items->take(max($limit, 1))->values();
    }

    private function getHighValueLeadsCount(): int
    {
        $partner = PartnerLead::query()->where('lead_grade', 'high')->whereNotNull('scored_at')->where('scored_at', '>=', now()->subDays(30))->count();
        $corporate = CorporateLead::query()->where('lead_grade', 'high')->whereNotNull('scored_at')->where('scored_at', '>=', now()->subDays(30))->count();

        return $partner + $corporate;
    }

    private function getActiveVehiclesCount(): int
    {
        if (! Schema::hasTable('vehicles')) {
            return 0;
        }

        return (int) DB::table('vehicles')->where('listing_status', 'active')->count();
    }

    private function getFeaturedVehiclesCount(): int
    {
        if (! Schema::hasTable('vehicles') || ! Schema::hasColumn('vehicles', 'is_featured')) {
            return 0;
        }

        return (int) DB::table('vehicles')->where('listing_status', 'active')->where('is_featured', 1)->count();
    }

    private function getPendingPriceRequestsCount(): int
    {
        if (! Schema::hasTable('price_change_requests') || ! Schema::hasColumn('price_change_requests', 'status')) {
            return 0;
        }

        return (int) DB::table('price_change_requests')->where('status', 'pending')->count();
    }

    private function getPendingPaymentsCount(): int
    {
        if (Schema::hasTable('payments') && Schema::hasColumn('payments', 'status')) {
            return (int) DB::table('payments')->where('status', 'pending')->count();
        }

        return CorporateLease::query()->where('payment_status', 'pending')->count();
    }

    private function getConversionRateHint(): array
    {
        $query = CorporateLead::query()->where('created_at', '>=', now()->subDays(30));
        $total = (clone $query)->count();

        $convertedColumn = Schema::hasColumn('corporate_leads', 'converted_lease_id')
            ? 'converted_lease_id'
            : (Schema::hasColumn('corporate_leads', 'converted_to_lease_id') ? 'converted_to_lease_id' : null);

        if (! $convertedColumn) {
            return ['converted_count' => 0, 'total_count' => $total, 'rate' => null];
        }

        $converted = (clone $query)->whereNotNull($convertedColumn)->count();

        return [
            'converted_count' => $converted,
            'total_count' => $total,
            'rate' => $total > 0 ? round(($converted / $total) * 100, 2) : null,
        ];
    }
}
