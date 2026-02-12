<?php

namespace App\Http\Controllers\Api\Public;

use App\Http\Controllers\Controller;
use App\Models\CorporateModel;
use App\Models\KmPackage;
use App\Models\Vehicle;
use Illuminate\Http\JsonResponse;

class DirectoryController extends Controller
{
    public function corporateModels(): JsonResponse
    {
        $models = CorporateModel::query()->where('active', true)->orderBy('sort_order')->get();

        return response()->json($models);
    }

    public function kmPackages(): JsonResponse
    {
        return response()->json(
            KmPackage::query()->where('active', true)->orderBy('km_limit')->get()
        );
    }

    public function featuredVehicles(): JsonResponse
    {
        return response()->json(
            Vehicle::query()
                ->where('listing_status', 'active')
                ->where('is_featured', true)
                ->where(function ($query) {
                    $query->whereNull('featured_until')->orWhere('featured_until', '>=', now());
                })
                ->latest()
                ->get()
        );
    }
}
