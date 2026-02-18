<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PartnerLeadAdminAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_non_admin_user_cannot_access_partner_lead_admin_screen(): void
    {
        $user = User::query()->create([
            'name' => 'Partner User',
            'email' => 'partner@example.com',
            'phone' => '5551234567',
            'password' => 'password',
            'role' => 'partner',
            'status' => 'active',
        ]);

        $response = $this->actingAs($user)->get('/admin/leadler/partner');

        $response->assertForbidden();
    }
}
