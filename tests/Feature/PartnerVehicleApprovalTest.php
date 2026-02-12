<?php

namespace Tests\Feature;

use App\Models\Partner;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class PartnerVehicleApprovalTest extends TestCase
{
    use RefreshDatabase;

    public function test_partner_creates_vehicle_as_pending_and_admin_approves_it(): void
    {
        $partnerUser = User::factory()->create();
        $partner = Partner::factory()->create(['user_id' => $partnerUser->id]);

        Sanctum::actingAs($partnerUser);

        $createResponse = $this->postJson('/api/partner/vehicles', [
            'brand' => 'Toyota',
            'model' => 'Corolla',
            'year' => 2022,
            'transmission' => 'automatic',
            'fuel_type' => 'hybrid',
            'km' => 35000,
        ]);

        $createResponse->assertCreated();
        $this->assertDatabaseHas('vehicles', [
            'partner_id' => $partner->id,
            'listing_status' => 'pending_approval',
        ]);

        $vehicleId = $createResponse->json('id');

        $admin = User::factory()->create();
        Sanctum::actingAs($admin);
        $this->putJson("/api/admin/vehicles/{$vehicleId}/approve")
            ->assertOk();

        $this->assertDatabaseHas('vehicles', [
            'id' => $vehicleId,
            'listing_status' => 'active',
        ]);
    }
}
