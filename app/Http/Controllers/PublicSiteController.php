<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class PublicSiteController extends Controller
{
    public function home()
    {
        return view('public.home');
    }

    public function corporateRental()
    {
        $models = DB::table('corporate_models')
            ->where('is_active', true)
            ->orderBy('brand')
            ->orderBy('model')
            ->get();

        $kmPackages = DB::table('km_packages')
            ->whereIn('yearly_km_limit', [10000, 20000, 30000])
            ->orderBy('yearly_km_limit')
            ->get();

        return view('public.corporate-rental', compact('models', 'kmPackages'));
    }
}
