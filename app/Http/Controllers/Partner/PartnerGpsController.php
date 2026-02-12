<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PartnerGpsController extends Controller
{
    public function index(Request $request)
    {
        $vehicles = $request->user()->partner->vehicles()->get(['id', 'plate', 'gps_provider', 'gps_login_url']);

        return view('partner.gps', compact('vehicles'));
    }

    public function apiIndex(Request $request): JsonResponse
    {
        $vehicles = $request->user()->partner->vehicles()->get(['id', 'plate', 'gps_provider', 'gps_login_url']);

        return response()->json(['data' => $vehicles]);
    }
}
