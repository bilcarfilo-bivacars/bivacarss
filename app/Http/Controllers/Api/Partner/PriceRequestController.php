<?php

namespace App\Http\Controllers\Api\Partner;

use App\Http\Controllers\Controller;
use App\Models\PriceChangeRequest;
use App\Models\Vehicle;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PriceRequestController extends Controller
{
    public function store(Request $request, Vehicle $vehicle): JsonResponse
    {
        $partner = $request->user()->partner;
        abort_if($vehicle->partner_id !== $partner->id, 403);

        $priceRequest = PriceChangeRequest::query()->create([
            'partner_id' => $partner->id,
            'vehicle_id' => $vehicle->id,
            'request_type' => $request->input('request_type', 'price_drop'),
            'old_price' => $vehicle->listing_price_monthly,
            'new_price' => $request->input('new_price'),
            'old_commission_rate' => $request->input('old_commission_rate'),
            'new_commission_rate' => $request->input('new_commission_rate'),
            'status' => 'pending',
        ]);

        return response()->json($priceRequest, 201);
    }
}
