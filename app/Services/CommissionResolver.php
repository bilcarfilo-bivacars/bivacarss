<?php

namespace App\Services;

use App\Models\Partner;
use App\Models\Vehicle;

class CommissionResolver
{
    public function resolve(Vehicle $vehicle, Partner $partner): float
    {
        $approvedRequestRate = $vehicle->priceChangeRequests()
            ->where('status', 'approved')
            ->whereNotNull('new_commission_rate')
            ->latest('approved_at')
            ->value('new_commission_rate');

        if ($approvedRequestRate !== null) {
            return (float) $approvedRequestRate;
        }

        if ($vehicle->custom_commission_rate !== null) {
            return (float) $vehicle->custom_commission_rate;
        }

        if ($partner->custom_commission_rate !== null) {
            return (float) $partner->custom_commission_rate;
        }

        return (float) config('bivacars.default_commission_rate', 15);
    }

    public function calculateNetIncome(float $price, float $commissionRate): float
    {
        return round($price - ($price * $commissionRate / 100), 2);
    }
}
