<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CorporateLead;
use App\Services\Leads\LeadScoringService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CorporateLeadAdminController extends Controller
{
    public function __construct(private readonly LeadScoringService $leadScoringService)
    {
    }

    public function index(Request $request): View
    {
        $status = $request->string('status')->toString();
        $grade = $request->string('grade')->toString();
        $minScore = $request->integer('min_score');

        $leads = CorporateLead::query()
            ->when($status !== '', fn ($query) => $query->where('status', $status))
            ->when($grade !== '', fn ($query) => $query->where('lead_grade', $grade))
            ->when($request->filled('min_score'), fn ($query) => $query->where('lead_score', '>=', $minScore))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.leads.corporate.index', compact('leads', 'status', 'grade', 'minScore'));
    }

    public function show(int $id): View
    {
        $lead = CorporateLead::query()->findOrFail($id);

        return view('admin.leads.corporate.show', compact('lead'));
    }

    public function rescore(int $id): RedirectResponse
    {
        $lead = CorporateLead::query()->findOrFail($id);
        $this->leadScoringService->scoreCorporateLead($lead);

        return redirect()
            ->route('admin.corporate-leads.show', $lead->id)
            ->with('success', 'Kurumsal lead puanı yeniden hesaplandı.');
    }

    public function updateStatus(Request $request, int $id): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:new,contacted,qualified,won,lost'],
        ]);

        $lead = CorporateLead::query()->findOrFail($id);
        $lead->update(['status' => $validated['status']]);

        return redirect()
            ->route('admin.corporate-leads.show', $lead->id)
            ->with('success', 'Kurumsal lead durumu güncellendi.');
    }
}
