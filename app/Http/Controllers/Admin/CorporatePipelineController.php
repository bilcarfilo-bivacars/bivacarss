<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CorporateLease;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CorporatePipelineController extends Controller
{
    public function index(Request $request): View
    {
        $stage = $request->string('pipeline_stage')->toString();

        $leases = CorporateLease::query()
            ->with(['sourceLead', 'matchedVehicle'])
            ->when($stage !== '', fn ($query) => $query->where('pipeline_stage', $stage))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.corporate-pipeline.index', compact('leases', 'stage'));
    }
}
