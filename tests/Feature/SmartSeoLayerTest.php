<?php

namespace Tests\Feature;

use App\Models\CorporateLead;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SmartSeoLayerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_industries_index_returns_ok(): void
    {
        $this->get('/sektorler')->assertOk();
    }

    public function test_industry_show_returns_ok(): void
    {
        $this->get('/sektorler/lojistik')->assertOk();
    }

    public function test_city_industry_show_returns_ok(): void
    {
        $this->get('/filo-kiralama/kocaeli/lojistik')->assertOk();
    }

    public function test_sitemap_contains_new_paths(): void
    {
        $response = $this->get('/sitemap.xml');
        $response->assertOk();
        $response->assertSee('/sektorler', false);
        $response->assertSee('/filo-kiralama/', false);
    }

    public function test_city_industry_mini_form_posts_to_corporate_leads(): void
    {
        $response = $this->post('/kurumsal-teklif-al', [
            'company_name' => 'Gebze Lojistik A.Ş.',
            'contact_phone' => '5554443322',
            'city' => 'Kocaeli',
            'sector' => 'Lojistik / Nakliye',
            'vehicles_count' => 8,
            'notes' => 'Acil teklif',
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseCount('corporate_leads', 1);
        $lead = CorporateLead::query()->first();
        $this->assertSame(8, $lead->vehicles_needed);
    }
}
