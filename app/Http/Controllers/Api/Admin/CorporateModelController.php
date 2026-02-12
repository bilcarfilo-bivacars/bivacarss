<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\CorporateModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CorporateModelController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(CorporateModel::query()->orderBy('sort_order')->get());
    }

    public function store(Request $request): JsonResponse
    {
        $model = CorporateModel::query()->create($request->only(['brand', 'model', 'segment', 'active', 'sort_order']));

        return response()->json($model, 201);
    }

    public function update(Request $request, CorporateModel $corporateModel): JsonResponse
    {
        $corporateModel->update($request->only(['brand', 'model', 'segment', 'active', 'sort_order']));

        return response()->json($corporateModel);
    }

    public function toggle(CorporateModel $corporateModel): JsonResponse
    {
        $corporateModel->update(['active' => ! $corporateModel->active]);

        return response()->json($corporateModel);
    }
}
