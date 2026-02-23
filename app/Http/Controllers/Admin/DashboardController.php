<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\DashboardMetricsService;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(private readonly DashboardMetricsService $dashboardMetricsService)
    {
    }

    public function index(): View
    {
        return view('admin.dashboard', [
            'metrics' => $this->dashboardMetricsService->getMetrics(),
            'recentCorporateLeads' => $this->dashboardMetricsService->getRecentCorporateLeads(10),
            'recentPartnerLeads' => $this->dashboardMetricsService->getRecentPartnerLeads(10),
            'recentLeases' => $this->dashboardMetricsService->getRecentLeases(10),
        ]);
    }
}
