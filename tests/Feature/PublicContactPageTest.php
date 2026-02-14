<?php

namespace Tests\Feature;

use Tests\TestCase;

class PublicContactPageTest extends TestCase
{
    public function test_contact_page_is_accessible_and_renders_company_info(): void
    {
        $response = $this->get('/iletisim');

        $response->assertOk();
        $response->assertSee('Haritayı Göster');
        $response->assertSee(config('bivacars.company.phone'));
        $response->assertSee(config('bivacars.company.email'));
    }
}
