<?php

namespace Tests\Feature\Admin;

use App\Models\CorporateOffer;
use App\Models\KmPackage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CorporateOfferTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_corporate_offer(): void
    {
        $admin = User::factory()->create();
        $kmPackage = KmPackage::factory()->create();

        $response = $this->actingAs($admin)
            ->postJson('/api/admin/corporate-offers', [
                'brand' => 'Renault',
                'model' => 'Clio',
                'km_package_id' => $kmPackage->id,
                'monthly_price' => 25000,
                'company_name' => 'ABC A.Ş.',
                'contact_phone' => '+90 (555) 123 45 67',
            ]);

        $response->assertCreated();

        $this->assertDatabaseHas('corporate_offers', [
            'brand' => 'Renault',
            'model' => 'Clio',
            'company_name' => 'ABC A.Ş.',
            'status' => 'draft',
        ]);
    }

    public function test_generate_pdf_creates_file_on_public_disk(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create();
        $offer = CorporateOffer::factory()->create([
            'created_by' => $admin->id,
            'status' => 'draft',
        ]);

        $response = $this->actingAs($admin)
            ->postJson("/api/admin/corporate-offers/{$offer->id}/generate-pdf");

        $response->assertOk();
        $path = $response->json('pdf_path');

        Storage::disk('public')->assertExists($path);
    }
}
