<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class PartnerVehiclesController extends Controller
{
    public function index()
    {
        $vehicles = DB::table('vehicles')->orderByDesc('id')->limit(100)->get();

        return view('partner.vehicles.index', compact('vehicles'));
    }

    public function create()
    {
        return view('partner.vehicles.create');
    }

    public function priceRequest(int $id)
    {
        $vehicle = DB::table('vehicles')->where('id', $id)->first();

        abort_if(!$vehicle, 404);

        return view('partner.vehicles.price-request', compact('vehicle'));
    }
}
