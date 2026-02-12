<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PartnerLeadTest extends TestCase
{
    use RefreshDatabase;

    public function test_valid_partner_lead_can_be_created(): void
    {
        $response = $this->post('/aracimi-kiraya-vermek-istiyorum', [
            'ad_soyad' => 'Hasan Yilmaz',
            'telefon' => '05550000000',
            'sehir' => 'Kocaeli',
            'arac_markasi' => 'Toyota',
            'arac_model' => 'Corolla',
            'yil' => 2022,
            'km' => 32000,
            'beklenen_aylik_kira' => 40000,
            'hasar_kaydi_var_mi' => 'hayır',
            'calculation_json' => '{"net_aylik":34000}',
        ]);

        $response->assertRedirect(route('partner.investment.show'));

        $this->assertDatabaseHas('partner_leads', [
            'full_name' => 'Hasan Yilmaz',
            'phone' => '05550000000',
            'city' => 'Kocaeli',
            'status' => 'new',
        ]);
    }
}
