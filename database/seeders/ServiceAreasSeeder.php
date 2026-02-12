<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceAreasSeeder extends Seeder
{
    public function run(): void
    {
        // Intentionally left minimal; project-specific seed payloads are expected
        // to call the helper methods below.
    }

    protected function upsertPoint(array $point): void
    {
        DB::table('location_points')->updateOrInsert(
            [
                'city_id' => $point['city_id'],
                'district_id' => $point['district_id'] ?? null,
                'type' => $point['type'],
                'slug' => $point['slug'],
            ],
            [
                'name' => $point['name'],
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );
    }

    protected function upsertSeoPage(array $seo): void
    {
        DB::table('seo_pages')->updateOrInsert(
            [
                'ref_type' => $seo['ref_type'],
                'ref_id' => $seo['ref_id'],
                'locale' => $seo['locale'] ?? 'tr',
            ],
            [
                'title' => $seo['title'] ?? null,
                'description' => $seo['description'] ?? null,
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );
    }
}
