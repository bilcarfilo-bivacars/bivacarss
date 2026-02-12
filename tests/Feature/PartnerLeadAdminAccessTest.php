<?php

namespace Tests\Feature;

use Tests\TestCase;

class PartnerLeadAdminAccessTest extends TestCase
{
    public function test_admin_partner_lead_list_requires_admin_access(): void
    {
        $response = $this->get('/admin/partner-leads');

        $response->assertStatus(302);
    }
}
