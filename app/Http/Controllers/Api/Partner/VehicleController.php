<?php

namespace App\Http\Controllers\Api\Partner;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $partner = $request->user()->partner;

        return response()->json(
            Vehicle::query()->where('partner_id', $partner->id)->latest()->paginate(20)
        );
    }

    public function store(Request $request): JsonResponse
    {
        $partner = $request->user()->partner;
        $data = $request->only([
            'brand',
            'model',
            'year',
            'transmission',
            'fuel_type',
            'km',
            'plate',
            'listing_price_monthly',
            'listing_vat_mode',
            'base_price_daily',
            'gps_provider',
            'gps_external_id',
            'gps_login_url',
        ]);
        $data['partner_id'] = $partner->id;
        $data['listing_status'] = 'pending_approval';

        $vehicle = Vehicle::query()->create($data);

        return response()->json($vehicle, 201);
    }

    public function update(Request $request, Vehicle $vehicle): JsonResponse
    {
        $partner = $request->user()->partner;
        abort_if($vehicle->partner_id !== $partner->id, 403);

        $vehicle->update(array_merge(
            $request->only([
                'brand',
                'model',
                'year',
                'transmission',
                'fuel_type',
                'km',
                'plate',
                'listing_price_monthly',
                'listing_vat_mode',
                'base_price_daily',
                'gps_provider',
                'gps_external_id',
                'gps_login_url',
            ]),
            ['listing_status' => 'pending_approval']
        ));

        return response()->json($vehicle);
    }
}
