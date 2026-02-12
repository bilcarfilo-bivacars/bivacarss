<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\District;
use App\Models\LocationPoint;
use App\Support\ServiceAreaSeo;
use Illuminate\Support\Facades\Cache;

class ServiceAreaController extends Controller
{
    public function index()
    {
        $cities = Cache::remember('service_areas:cities', 3600, fn () => City::query()
            ->where('active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->withCount('districts')
            ->get());

        return view('public.service-areas.index', ['cities' => $cities]);
    }

    public function city(string $citySlug)
    {
        $city = Cache::remember("service_areas:city:{$citySlug}", 3600, fn () => City::query()
            ->where('slug', $citySlug)
            ->where('active', true)
            ->with(['districts' => fn ($q) => $q->where('active', true), 'points' => fn ($q) => $q->where('active', true)])
            ->firstOrFail());

        $meta = ServiceAreaSeo::build('city', $city->id, $city->name, request()->url());

        return view('public.service-areas.city', compact('city', 'meta'));
    }

    public function district(string $citySlug, string $districtSlug)
    {
        $district = Cache::remember("service_areas:district:{$citySlug}:{$districtSlug}", 3600, fn () => District::query()
            ->where('slug', $districtSlug)
            ->where('active', true)
            ->whereHas('city', fn ($q) => $q->where('slug', $citySlug)->where('active', true))
            ->with([
                'city',
                'points' => fn ($q) => $q->where('active', true),
            ])
            ->firstOrFail());

        $meta = ServiceAreaSeo::build('district', $district->id, $district->name, request()->url());

        return view('public.service-areas.district', compact('district', 'meta'));
    }

    public function point(string $citySlug, string $districtSlug, string $pointSlug)
    {
        $point = LocationPoint::query()
            ->where('slug', $pointSlug)
            ->where('active', true)
            ->whereHas('city', fn ($q) => $q->where('slug', $citySlug)->where('active', true))
            ->whereHas('district', fn ($q) => $q->where('slug', $districtSlug)->where('active', true))
            ->with(['city', 'district'])
            ->firstOrFail();

        $meta = ServiceAreaSeo::build('point', $point->id, $point->name, request()->url());

        return view('public.service-areas.point', compact('point', 'meta'));
    }
}
