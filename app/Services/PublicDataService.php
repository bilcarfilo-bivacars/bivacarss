<?php

namespace App\Services;

use App\Support\CacheKeys;
use Illuminate\Support\Facades\Cache;

class PublicDataService
{
    public function corporateModels(): array
    {
        return Cache::remember(CacheKeys::CORPORATE_MODELS, now()->addHour(), fn () => []);
    }

    public function kmPackages(): array
    {
        return Cache::remember(CacheKeys::KM_PACKAGES, now()->addHour(), fn () => []);
    }

    public function featuredVehicles(): array
    {
        return Cache::remember(CacheKeys::FEATURED_VEHICLES, now()->addMinutes(10), fn () => []);
    }

    public function serviceAreas(): array
    {
        return Cache::remember(CacheKeys::SERVICE_AREAS, now()->addHour(), fn () => []);
    }
}
