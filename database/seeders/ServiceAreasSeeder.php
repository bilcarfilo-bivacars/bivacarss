<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\District;
use App\Models\LocationPoint;
use Illuminate\Database\Seeder;

class ServiceAreasSeeder extends Seeder
{
    public function run(): void
    {
        $istanbul = City::query()->updateOrCreate(
            ['slug' => 'istanbul-anadolu'],
            ['name' => 'İstanbul Anadolu Yakası', 'region_group' => 'istanbul-anadolu', 'active' => true, 'sort_order' => 1]
        );

        $kocaeli = City::query()->updateOrCreate(
            ['slug' => 'kocaeli'],
            ['name' => 'Kocaeli', 'region_group' => 'kocaeli', 'active' => true, 'sort_order' => 2]
        );

        $districts = [
            [$istanbul->id, 'Kadıköy', 'kadikoy'],
            [$istanbul->id, 'Üsküdar', 'uskudar'],
            [$istanbul->id, 'Ataşehir', 'atasehir'],
            [$kocaeli->id, 'Gebze', 'gebze'],
            [$kocaeli->id, 'Darıca', 'darica'],
            [$kocaeli->id, 'İzmit', 'izmit'],
        ];

        foreach ($districts as $index => [$cityId, $name, $slug]) {
            District::query()->updateOrCreate(
                ['city_id' => $cityId, 'slug' => $slug],
                ['name' => $name, 'active' => true, 'sort_order' => $index + 1]
            );
        }

        $gebze = District::query()->where('slug', 'gebze')->first();
        $izmit = District::query()->where('slug', 'izmit')->first();

        $points = [
            ['city_id' => $kocaeli->id, 'district_id' => $gebze?->id, 'type' => 'otogar', 'name' => 'Gebze Otogar', 'slug' => 'gebze-otogar'],
            ['city_id' => $kocaeli->id, 'district_id' => $izmit?->id, 'type' => 'otogar', 'name' => 'İzmit Otogar', 'slug' => 'izmit-otogar'],
            ['city_id' => $kocaeli->id, 'district_id' => $izmit?->id, 'type' => 'tren-gari', 'name' => 'İzmit Tren Garı', 'slug' => 'izmit-tren-gari'],
            ['city_id' => $istanbul->id, 'district_id' => District::query()->where('slug', 'atasehir')->value('id'), 'type' => 'havalimani', 'name' => 'Sabiha Gökçen Havalimanı', 'slug' => 'sabiha-gokcen-havalimani', 'lat' => 40.8986, 'lng' => 29.3092],
            ['city_id' => $istanbul->id, 'district_id' => District::query()->where('slug', 'atasehir')->value('id'), 'type' => 'avm', 'name' => 'Optimum AVM', 'slug' => 'optimum-avm'],
            ['city_id' => $istanbul->id, 'district_id' => District::query()->where('slug', 'atasehir')->value('id'), 'type' => 'avm', 'name' => 'Viaport AVM', 'slug' => 'viaport-avm'],
        ];

        foreach ($points as $index => $point) {
            LocationPoint::query()->updateOrCreate(
                ['slug' => $point['slug']],
                array_merge(['active' => true, 'sort_order' => $index + 1], $point)
            );
        }
    }
}
