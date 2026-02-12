<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\KmPackage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class KmPackageController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(KmPackage::query()->orderBy('km_limit')->get());
    }

    public function store(Request $request): JsonResponse
    {
        $package = KmPackage::query()->create($request->only(['km_limit', 'yearly_price', 'vat_included', 'active']));

        return response()->json($package, 201);
    }

    public function update(Request $request, KmPackage $kmPackage): JsonResponse
    {
        $kmPackage->update($request->only(['km_limit', 'yearly_price', 'vat_included', 'active']));

        return response()->json($kmPackage);
    }

    public function toggle(KmPackage $kmPackage): JsonResponse
    {
        $kmPackage->update(['active' => ! $kmPackage->active]);

        return response()->json($kmPackage);
    }
}
