<?php

namespace Tests\Feature;

use App\Models\Partner;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PartnerMaintenanceListAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_partner_can_access_maintenance_list_endpoint(): void
    {
        $user = User::factory()->create();
        Partner::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get('/partner/bakim-takibi');

        $response->assertOk();
    }
}
