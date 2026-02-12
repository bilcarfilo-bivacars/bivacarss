<?php

namespace App\Http\Controllers\PublicApi;

use App\Http\Controllers\Controller;
use App\Models\CorporateModel;
use App\Models\KmPackage;
use Illuminate\Http\JsonResponse;

class CorporatePricingController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json([
            'models' => CorporateModel::query()->get(),
            'km_packages' => KmPackage::query()->get(['id', 'km_limit', 'yearly_price']),
        ]);
    }
}
