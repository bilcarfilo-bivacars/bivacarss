<?php

namespace Tests\Feature;

use App\Models\CorporateLead;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class CorporateLeadToLeaseConversionTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_convert_corporate_lead_to_lease(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $packageId = DB::table('km_packages')->insertGetId([
            'km_limit' => 20000,
            'yearly_price' => 42000,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $lead = CorporateLead::factory()->create([
            'vehicles_needed' => 6,
            'status' => 'qualified',
        ]);

        $response = $this->actingAs($admin)
            ->post(route('admin.corporate-leads.convert-to-lease', $lead->id));

        $response->assertRedirect();

        $lease = DB::table('corporate_leases')->where('source_lead_id', $lead->id)->first();

        $this->assertNotNull($lease);
        $this->assertSame((int) $lead->id, (int) $lease->source_lead_id);
        $this->assertSame('qualified', $lease->pipeline_stage);
        $this->assertSame((int) $packageId, (int) $lease->km_package_id);

        $this->assertDatabaseHas('corporate_leads', [
            'id' => $lead->id,
            'converted_to_lease_id' => $lease->id,
        ]);
    }
}
