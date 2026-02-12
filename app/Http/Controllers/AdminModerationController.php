<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class AdminModerationController extends Controller
{
    public function vehicleApprovals()
    {
        $vehicles = DB::table('vehicles')
            ->where('status', 'pending_approval')
            ->orderBy('created_at')
            ->get();

        return view('admin.vehicle-approvals', compact('vehicles'));
    }

    public function priceRequests()
    {
        $requests = DB::table('price_change_requests as pcr')
            ->join('vehicles as v', 'v.id', '=', 'pcr.vehicle_id')
            ->select('pcr.*', 'v.brand', 'v.model', 'v.year', 'v.listing_price_monthly')
            ->where('pcr.status', 'pending')
            ->orderBy('pcr.created_at')
            ->get();

        return view('admin.price-requests', compact('requests'));
    }
}
