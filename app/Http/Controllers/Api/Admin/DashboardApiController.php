<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\DashboardMetricsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashboardApiController extends Controller
{
    public function __construct(private readonly DashboardMetricsService $dashboardMetricsService)
    {
    }

    public function metrics(): JsonResponse
    {
        return response()->json($this->dashboardMetricsService->getMetrics());
    }

    public function recentLeads(Request $request): JsonResponse
    {
        $type = $request->query('type', 'corporate');
        $limit = max((int) $request->query('limit', 10), 1);

        $data = $type === 'partner'
            ? $this->dashboardMetricsService->getRecentPartnerLeads($limit)
            : $this->dashboardMetricsService->getRecentCorporateLeads($limit);

        return response()->json(['type' => $type, 'data' => $data]);
    }

    public function recentLeases(Request $request): JsonResponse
    {
        $limit = max((int) $request->query('limit', 10), 1);

        return response()->json([
            'data' => $this->dashboardMetricsService->getRecentLeases($limit),
        ]);
    }
}
