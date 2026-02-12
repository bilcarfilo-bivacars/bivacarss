<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class PartnerDashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('partner.dashboard');
    }
}
