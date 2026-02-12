<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\District;
use App\Models\LocationPoint;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ServiceAreaAdminController extends Controller
{
    public function index()
    {
        $cities = City::query()->with('districts.points')->orderBy('sort_order')->get();

        return view('admin.service-areas.index', compact('cities'));
    }

    public function storeCity(Request $request): RedirectResponse
    {
        City::query()->create($request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:cities,slug',
            'region_group' => 'required|string|max:255',
            'active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]));

        return back();
    }

    public function storeDistrict(Request $request): RedirectResponse
    {
        District::query()->create($request->validate([
            'city_id' => 'required|exists:cities,id',
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]));

        return back();
    }

    public function storePoint(Request $request): RedirectResponse
    {
        LocationPoint::query()->create($request->validate([
            'city_id' => 'nullable|exists:cities,id',
            'district_id' => 'nullable|exists:districts,id',
            'type' => 'required|in:otogar,tren-gari,avm,havalimani',
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'lat' => 'nullable|numeric',
            'lng' => 'nullable|numeric',
            'active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]));

        return back();
    }

    public function toggleCity(City $city): RedirectResponse
    {
        $city->update(['active' => ! $city->active]);

        return back();
    }

    public function toggleDistrict(District $district): RedirectResponse
    {
        $district->update(['active' => ! $district->active]);

        return back();
    }

    public function togglePoint(LocationPoint $point): RedirectResponse
    {
        $point->update(['active' => ! $point->active]);

        return back();
    }
}
