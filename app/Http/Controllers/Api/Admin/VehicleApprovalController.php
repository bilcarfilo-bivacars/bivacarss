<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VehicleApprovalController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $status = $request->string('status', 'pending_approval')->toString();
        $vehicles = Vehicle::query()->where('listing_status', $status)->latest()->paginate(20);

        return response()->json($vehicles);
    }

    public function approve(Vehicle $vehicle): JsonResponse
    {
        $vehicle->update(['listing_status' => 'active']);

        return response()->json(['message' => 'Vehicle approved', 'vehicle' => $vehicle]);
    }

    public function reject(Request $request, Vehicle $vehicle): JsonResponse
    {
        $vehicle->update(['listing_status' => 'rejected']);

        return response()->json([
            'message' => 'Vehicle rejected',
            'vehicle' => $vehicle,
            'admin_note' => $request->input('admin_note'),
        ]);
    }
}
