<?php

namespace App\Services\Corporate;

use App\Models\CorporateLease;
use App\Models\Vehicle;
use Illuminate\Support\Collection;

class VehicleMatchService
{
    public function suggestVehiclesForLease(CorporateLease $lease, int $limit = 10): Collection
    {
        return Vehicle::query()
            ->where('listing_status', 'active')
            ->whereNotNull('listing_price_monthly')
            ->orderByDesc('is_featured')
            ->orderBy('listing_price_monthly')
            ->limit($limit)
            ->get();
    }
}
