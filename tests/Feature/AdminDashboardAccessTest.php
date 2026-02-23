<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDashboardAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_access_dashboard(): void
    {
        $admin = User::query()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'phone' => '5550000001',
            'password' => 'password',
            'role' => 'admin',
            'status' => 'active',
        ]);

        $this->actingAs($admin)
            ->get('/admin')
            ->assertOk();
    }

    public function test_partner_cannot_access_dashboard(): void
    {
        $partner = User::query()->create([
            'name' => 'Partner User',
            'email' => 'partner@example.com',
            'phone' => '5550000002',
            'password' => 'password',
            'role' => 'partner',
            'status' => 'active',
        ]);

        $this->actingAs($partner)
            ->get('/admin')
            ->assertForbidden();
    }

    public function test_passive_user_gets_forbidden(): void
    {
        $passiveAdmin = User::query()->create([
            'name' => 'Passive Admin',
            'email' => 'passive-admin@example.com',
            'phone' => '5550000003',
            'password' => 'password',
            'role' => 'admin',
            'status' => 'passive',
        ]);

        $this->actingAs($passiveAdmin)
            ->get('/admin')
            ->assertForbidden();
    }
}
