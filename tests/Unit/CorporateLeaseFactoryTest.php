<?php

namespace Tests\Unit;

use App\Models\CorporateLead;
use App\Models\User;
use App\Services\Corporate\CorporateLeaseFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class CorporateLeaseFactoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_prefers_30000_km_package_for_large_fleet_lead(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $km20 = DB::table('km_packages')->insertGetId([
            'km_limit' => 20000,
            'yearly_price' => 39000,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $km30 = DB::table('km_packages')->insertGetId([
            'km_limit' => 30000,
            'yearly_price' => 47000,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $lead = CorporateLead::factory()->create([
            'vehicles_needed' => 12,
            'status' => 'qualified',
        ]);

        $this->actingAs($admin);

        $lease = app(CorporateLeaseFactory::class)->createFromLead($lead);

        $this->assertSame((int) $km30, (int) $lease->km_package_id);
        $this->assertNotSame((int) $km20, (int) $lease->km_package_id);
    }
}
