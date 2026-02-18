<?php

namespace Tests\Feature;

use App\Models\CorporateLead;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CorporateLeadPublicFormTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_corporate_form_inserts_and_scores_lead(): void
    {
        $response = $this->post('/kurumsal-teklif-al', [
            'company_name' => 'Acme A.Ş.',
            'contact_phone' => '5551112233',
            'city' => 'İstanbul',
            'vehicles_needed' => 12,
            'budget_monthly' => 1200000,
            'tax_number' => '1234567890',
            'sector' => 'Lojistik',
        ]);

        $response->assertRedirect('/kurumsal-teklif-al');

        $lead = CorporateLead::query()->first();
        $this->assertNotNull($lead);
        $this->assertGreaterThanOrEqual(0, $lead->lead_score);
        $this->assertNotNull($lead->lead_grade);
    }
}
