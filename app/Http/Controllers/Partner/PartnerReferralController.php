<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\ReferralClaim;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PartnerReferralController extends Controller
{
    public function index(Request $request)
    {
        $partner = $request->user()->partner;
        $claims = ReferralClaim::where('partner_id', $partner->id)->latest()->paginate(20);
        $vehicles = $partner->vehicles()->get(['id', 'plate']);

        return view('partner.referral', compact('claims', 'vehicles'));
    }

    public function store(Request $request)
    {
        $partner = $request->user()->partner;

        $data = $request->validate([
            'vehicle_id' => ['nullable', 'exists:vehicles,id'],
            'company_name' => ['nullable', 'string', 'max:255'],
            'contact_name' => ['nullable', 'string', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:50'],
            'details' => ['nullable', 'string'],
        ]);

        $data['partner_id'] = $partner->id;
        $data['status'] = 'pending';

        ReferralClaim::create($data);

        return redirect()->route('partner.referral.index')->with('status', 'Referral talebi oluşturuldu.');
    }

    public function apiIndex(Request $request): JsonResponse
    {
        $claims = ReferralClaim::where('partner_id', $request->user()->partner->id)->latest()->paginate(20);

        return response()->json(['data' => $claims]);
    }

    public function apiStore(Request $request): JsonResponse
    {
        $partner = $request->user()->partner;

        $data = $request->validate([
            'vehicle_id' => ['nullable', 'exists:vehicles,id'],
            'company_name' => ['nullable', 'string', 'max:255'],
            'contact_name' => ['nullable', 'string', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:50'],
            'details' => ['nullable', 'string'],
        ]);

        $data['partner_id'] = $partner->id;
        $data['status'] = 'pending';

        $claim = ReferralClaim::create($data);

        return response()->json(['message' => 'Referral talebi oluşturuldu.', 'data' => $claim], 201);
    }
}
