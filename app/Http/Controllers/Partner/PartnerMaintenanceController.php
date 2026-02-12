<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\VehicleMaintenanceRecord;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PartnerMaintenanceController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->string('status')->toString();

        $query = VehicleMaintenanceRecord::query()
            ->whereHas('vehicle', fn ($q) => $q->where('partner_id', $request->user()->partner->id))
            ->with('vehicle:id,plate')
            ->orderByRaw('CASE WHEN due_date IS NULL THEN 1 ELSE 0 END')
            ->orderBy('due_date');

        if (in_array($status, ['open', 'done'], true)) {
            $query->where('status', $status);
        }

        $records = $query->paginate(20)->withQueryString();

        return view('partner.maintenance', compact('records', 'status'));
    }

    public function apiIndex(Request $request): JsonResponse
    {
        $status = $request->string('status')->toString();

        $query = VehicleMaintenanceRecord::query()
            ->whereHas('vehicle', fn ($q) => $q->where('partner_id', $request->user()->partner->id))
            ->with('vehicle:id,plate')
            ->orderBy('due_date');

        if (in_array($status, ['open', 'done'], true)) {
            $query->where('status', $status);
        }

        return response()->json(['data' => $query->paginate(20)]);
    }
}
