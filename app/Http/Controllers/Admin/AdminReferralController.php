<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReferralClaim;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminReferralController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->string('status')->toString() ?: 'pending';

        $claims = ReferralClaim::query()
            ->with(['partner:id,company_name', 'vehicle:id,plate'])
            ->when(in_array($status, ['pending', 'approved', 'rejected'], true), fn ($q) => $q->where('status', $status))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.referrals', compact('claims', 'status'));
    }

    public function approve(Request $request, ReferralClaim $claim)
    {
        $claim->update([
            'status' => 'approved',
            'admin_note' => $request->input('admin_note'),
            'approved_by' => $request->user()->id,
            'approved_at' => now(),
        ]);

        $partner = $claim->partner;
        if (empty($partner->referral_discount_rate)) {
            $partner->referral_discount_rate = config('bivacars.default_referral_discount_rate', 5);
            $partner->save();
        }

        return back()->with('status', 'Referral talebi onaylandı.');
    }

    public function reject(Request $request, ReferralClaim $claim)
    {
        $claim->update([
            'status' => 'rejected',
            'admin_note' => $request->input('admin_note'),
            'approved_by' => $request->user()->id,
            'approved_at' => now(),
        ]);

        return back()->with('status', 'Referral talebi reddedildi.');
    }

    public function apiIndex(Request $request): JsonResponse
    {
        $status = $request->query('status', 'pending');

        $claims = ReferralClaim::query()
            ->when(in_array($status, ['pending', 'approved', 'rejected'], true), fn ($q) => $q->where('status', $status))
            ->with(['partner:id,company_name', 'vehicle:id,plate'])
            ->latest()
            ->paginate(20);

        return response()->json(['data' => $claims]);
    }

    public function apiApprove(Request $request, ReferralClaim $id): JsonResponse
    {
        $id->update([
            'status' => 'approved',
            'admin_note' => $request->input('admin_note'),
            'approved_by' => $request->user()->id,
            'approved_at' => now(),
        ]);

        $partner = $id->partner;
        if (empty($partner->referral_discount_rate)) {
            $partner->referral_discount_rate = config('bivacars.default_referral_discount_rate', 5);
            $partner->save();
        }

        return response()->json(['data' => $id->fresh()]);
    }

    public function apiReject(Request $request, ReferralClaim $id): JsonResponse
    {
        $id->update([
            'status' => 'rejected',
            'admin_note' => $request->input('admin_note'),
            'approved_by' => $request->user()->id,
            'approved_at' => now(),
        ]);

        return response()->json(['data' => $id->fresh()]);
    }
}
