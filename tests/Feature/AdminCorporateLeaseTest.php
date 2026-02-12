<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class AdminCorporateLeaseTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_corporate_lease(): void
    {
        $admin = User::factory()->create();

        $modelId = DB::table('corporate_models')->insertGetId([
            'brand' => 'BMW',
            'model' => '320i',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $packageId = DB::table('km_packages')->insertGetId([
            'km_limit' => 20,
            'yearly_price' => 35000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->actingAs($admin, 'sanctum')->postJson('/api/admin/corporate-leases', [
            'company_name' => 'ABC A.Ş.',
            'corporate_model_id' => $modelId,
            'km_package_id' => $packageId,
        ]);

        $response->assertCreated()->assertJsonPath('company_name', 'ABC A.Ş.');
        $this->assertDatabaseHas('corporate_leases', [
            'company_name' => 'ABC A.Ş.',
            'payment_status' => 'pending',
            'km_package_id' => $packageId,
        ]);
    }

    public function test_mark_paid_endpoint_updates_payment_status(): void
    {
        $admin = User::factory()->create();

        $packageId = DB::table('km_packages')->insertGetId([
            'km_limit' => 10,
            'yearly_price' => 25000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $leaseId = DB::table('corporate_leases')->insertGetId([
            'company_name' => 'XYZ Ltd',
            'km_package_id' => $packageId,
            'monthly_price' => 25000,
            'vat_rate' => 20,
            'status' => 'draft',
            'payment_status' => 'pending',
            'created_by' => $admin->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->actingAs($admin, 'sanctum')
            ->postJson("/api/admin/corporate-leases/{$leaseId}/mark-paid")
            ->assertOk()
            ->assertJsonPath('payment_status', 'paid');

        $this->assertDatabaseHas('corporate_leases', [
            'id' => $leaseId,
            'payment_status' => 'paid',
        ]);
    }
}
