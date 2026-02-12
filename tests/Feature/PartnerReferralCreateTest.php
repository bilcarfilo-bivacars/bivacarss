<?php

namespace Tests\Feature;

use App\Models\Partner;
use App\Models\ReferralClaim;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PartnerReferralCreateTest extends TestCase
{
    use RefreshDatabase;

    public function test_partner_can_create_referral_claim(): void
    {
        $user = User::factory()->create();
        $partner = Partner::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->post('/partner/referral', [
            'company_name' => 'ACME Lojistik',
            'contact_name' => 'Ahmet Yılmaz',
            'contact_phone' => '05550000000',
            'details' => 'Filoda 10 araç yenileme planı var.',
        ]);

        $response->assertRedirect('/partner/referral');

        $this->assertDatabaseHas('referral_claims', [
            'partner_id' => $partner->id,
            'company_name' => 'ACME Lojistik',
            'status' => 'pending',
        ]);
    }
}
