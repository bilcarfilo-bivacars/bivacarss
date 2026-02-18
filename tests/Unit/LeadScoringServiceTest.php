<?php

namespace Tests\Unit;

use App\Models\PartnerLead;
use App\Services\Leads\LeadScoringService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LeadScoringServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_partner_lead_with_ten_vehicles_gets_high_grade(): void
    {
        $lead = PartnerLead::query()->create([
            'full_name' => 'Test Partner',
            'phone' => '5550000000',
            'city' => 'Kocaeli',
            'vehicles_count' => 10,
            'expected_rent' => 50000,
            'has_damage' => false,
            'status' => 'new',
        ]);

        $result = app(LeadScoringService::class)->scorePartnerLead($lead);

        $this->assertSame('high', $result['grade']);
        $this->assertGreaterThanOrEqual(70, $result['score']);
    }
}
