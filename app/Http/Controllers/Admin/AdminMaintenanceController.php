<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\VehicleMaintenanceRecord;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminMaintenanceController extends Controller
{
    public function index(Request $request)
    {
        $vehicleId = $request->integer('vehicle_id');
        $vehicles = Vehicle::query()->orderBy('plate')->get(['id', 'plate']);

        $records = VehicleMaintenanceRecord::query()
            ->with('vehicle:id,plate')
            ->when($vehicleId, fn ($q) => $q->where('vehicle_id', $vehicleId))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.maintenance', compact('records', 'vehicles', 'vehicleId'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'vehicle_id' => ['required', 'exists:vehicles,id'],
            'type' => ['required', 'in:maintenance,insurance,mtv,tires,gps,other'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'due_date' => ['nullable', 'date'],
            'cost_estimate' => ['nullable', 'numeric', 'min:0'],
        ]);

        $data['created_by'] = $request->user()->id;
        VehicleMaintenanceRecord::create($data);

        return back()->with('status', 'Bakım kaydı oluşturuldu.');
    }

    public function markDone(VehicleMaintenanceRecord $record)
    {
        $record->update(['status' => 'done', 'completed_at' => now()]);

        return back()->with('status', 'Kayıt tamamlandı olarak işaretlendi.');
    }

    public function apiIndex(Request $request): JsonResponse
    {
        $records = VehicleMaintenanceRecord::with('vehicle:id,plate')->paginate(20);

        return response()->json(['data' => $records]);
    }

    public function apiStore(Request $request): JsonResponse
    {
        $data = $request->validate([
            'vehicle_id' => ['required', 'exists:vehicles,id'],
            'type' => ['required', 'in:maintenance,insurance,mtv,tires,gps,other'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'due_date' => ['nullable', 'date'],
            'cost_estimate' => ['nullable', 'numeric', 'min:0'],
            'status' => ['sometimes', 'in:open,done,cancelled'],
        ]);

        $data['created_by'] = $request->user()->id;
        $record = VehicleMaintenanceRecord::create($data);

        return response()->json(['data' => $record], 201);
    }

    public function apiShow(VehicleMaintenanceRecord $maintenance): JsonResponse
    {
        return response()->json(['data' => $maintenance->load('vehicle:id,plate')]);
    }

    public function apiUpdate(Request $request, VehicleMaintenanceRecord $maintenance): JsonResponse
    {
        $data = $request->validate([
            'type' => ['sometimes', 'in:maintenance,insurance,mtv,tires,gps,other'],
            'title' => ['sometimes', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'due_date' => ['nullable', 'date'],
            'cost_estimate' => ['nullable', 'numeric', 'min:0'],
            'status' => ['sometimes', 'in:open,done,cancelled'],
        ]);

        if (($data['status'] ?? null) === 'done') {
            $data['completed_at'] = now();
        }

        $maintenance->update($data);

        return response()->json(['data' => $maintenance->fresh()]);
    }

    public function apiDestroy(VehicleMaintenanceRecord $maintenance): JsonResponse
    {
        $maintenance->delete();

        return response()->json([], 204);
    }
}
