<?php

namespace Tests\Feature;

use App\Models\CorporateLead;
use App\Models\CorporateLease;
use App\Models\PartnerLead;
use App\Models\KmPackage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AdminDashboardApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_fetch_metrics(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'status' => 'active',
        ]);

        PartnerLead::query()->create([
            'full_name' => 'Partner Lead',
            'phone' => '5550001000',
            'status' => 'new',
        ]);

        CorporateLead::query()->create([
            'company_name' => 'Acme A.Ş.',
            'contact_phone' => '5550002000',
            'status' => 'new',
        ]);

        $package = KmPackage::query()->create(['km_limit' => 12000, 'yearly_price' => 10000, 'is_active' => true]);

        CorporateLease::query()->create([
            'company_name' => 'Acme A.Ş.',
            'km_package_id' => $package->id,
            'monthly_price' => 10000,
            'status' => 'active',
            'payment_status' => 'pending',
            'created_by' => $admin->id,
        ]);

        Sanctum::actingAs($admin);

        $this->getJson('/api/admin/dashboard/metrics')
            ->assertOk()
            ->assertJsonStructure([
                'today_partner_leads_count',
                'today_corporate_leads_count',
                'high_value_leads_count',
                'active_vehicles_count',
                'featured_vehicles_count',
                'pending_price_requests_count',
                'active_corporate_leases_count',
                'pending_payments_count',
                'monthly_revenue_estimate',
                'conversion_rate_hint' => ['converted_count', 'total_count', 'rate'],
            ]);
    }

    public function test_admin_can_fetch_recent_endpoints(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'status' => 'active',
        ]);

        Sanctum::actingAs($admin);

        $this->getJson('/api/admin/dashboard/recent-leads?type=corporate&limit=10')->assertOk();
        $this->getJson('/api/admin/dashboard/recent-leads?type=partner&limit=10')->assertOk();
        $this->getJson('/api/admin/dashboard/recent-leases?limit=10')->assertOk();
    }
}
