<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CorporateLease;
use App\Models\CorporateModel;
use App\Models\KmPackage;
use App\Services\Corporate\VehicleMatchService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CorporateLeaseController extends Controller
{
    public function __construct(private readonly VehicleMatchService $vehicleMatchService)
    {
    }

    public function index(Request $request)
    {
        $leases = CorporateLease::query()
            ->with(['model', 'kmPackage', 'sourceLead'])
            ->latest()
            ->paginate(20);

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json($leases);
        }

        return view('admin.corporate-leases.index', compact('leases'));
    }

    public function create()
    {
        return view('admin.corporate-leases.form', [
            'lease' => new CorporateLease(),
            'models' => CorporateModel::query()->get(),
            'packages' => KmPackage::query()->get(),
            'vehicleSuggestions' => collect(),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $this->validated($request);
        $package = KmPackage::query()->findOrFail($data['km_package_id']);
        $data['monthly_price'] = $data['monthly_price'] ?? $package->yearly_price;
        $data['created_by'] = $request->user()->id;

        $lease = CorporateLease::query()->create($data);

        return response()->json($lease->load(['model', 'kmPackage']), 201);
    }

    public function edit(CorporateLease $corporateLease)
    {
        return view('admin.corporate-leases.form', [
            'lease' => $corporateLease,
            'models' => CorporateModel::query()->get(),
            'packages' => KmPackage::query()->get(),
            'vehicleSuggestions' => $this->vehicleMatchService->suggestVehiclesForLease($corporateLease),
        ]);
    }

    public function update(Request $request, CorporateLease $corporateLease): JsonResponse
    {
        $data = $this->validated($request, true);

        if (empty($data['monthly_price']) && isset($data['km_package_id'])) {
            $data['monthly_price'] = KmPackage::query()->findOrFail($data['km_package_id'])->yearly_price;
        }

        if (($data['payment_status'] ?? null) === 'paid' && ! $corporateLease->paid_at) {
            $data['paid_at'] = now();
        }

        $corporateLease->update($data);

        return response()->json($corporateLease->fresh(['model', 'kmPackage']));
    }

    public function markPaid(CorporateLease $corporateLease): JsonResponse
    {
        $corporateLease->update([
            'payment_status' => 'paid',
            'paid_at' => now(),
        ]);

        return response()->json($corporateLease->fresh(['model', 'kmPackage']));
    }

    public function matchVehicle(Request $request, CorporateLease $corporateLease): RedirectResponse
    {
        $data = $request->validate([
            'vehicle_id' => ['required', 'exists:vehicles,id'],
        ]);

        $corporateLease->update([
            'matched_vehicle_id' => $data['vehicle_id'],
        ]);

        return redirect()
            ->route('admin.corporate-leases.edit', $corporateLease)
            ->with('success', 'Araç kiralama ile eşleştirildi.');
    }

    private function validated(Request $request, bool $isUpdate = false): array
    {
        $rules = [
            'company_name' => [$isUpdate ? 'sometimes' : 'required', 'string', 'max:255'],
            'contact_name' => ['nullable', 'string', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:40'],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'corporate_model_id' => ['nullable', 'exists:corporate_models,id'],
            'vehicle_id' => ['nullable', 'exists:vehicles,id'],
            'km_package_id' => [$isUpdate ? 'sometimes' : 'required', 'exists:km_packages,id'],
            'monthly_price' => ['nullable', 'numeric', 'min:0'],
            'vat_rate' => ['nullable', 'numeric', 'min:0'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'status' => ['nullable', 'in:draft,active,ended,cancelled'],
            'payment_status' => ['nullable', 'in:pending,paid'],
            'pipeline_stage' => ['nullable', 'in:new,contacted,qualified,proposal_sent,won,lost'],
            'notes' => ['nullable', 'string'],
        ];

        return $request->validate($rules);
    }
}
