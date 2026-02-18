<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\CorporateLead;
use App\Services\Leads\LeadScoringService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CorporateLeadController extends Controller
{
    public function __construct(private readonly LeadScoringService $leadScoringService)
    {
    }

    public function show(): View
    {
        return view('public.corporate-lead');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'company_name' => ['required', 'string', 'max:255'],
            'tax_number' => ['nullable', 'string', 'max:20'],
            'contact_name' => ['nullable', 'string', 'max:255'],
            'contact_phone' => ['required', 'string', 'max:50'],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'district' => ['nullable', 'string', 'max:255'],
            'sector' => ['nullable', 'string', 'max:255'],
            'vehicles_needed' => ['nullable', 'integer', 'min:0'],
            'lease_months' => ['nullable', 'integer', 'min:1'],
            'budget_monthly' => ['nullable', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string', 'max:5000'],
        ]);

        $lead = CorporateLead::query()->create($validated + [
            'status' => 'new',
        ]);

        $this->leadScoringService->scoreCorporateLead($lead);

        return redirect()
            ->route('public.corporate-lead.show')
            ->with('success', 'Kurumsal teklif talebiniz alındı. Ekibimiz kısa sürede iletişime geçecektir.');
    }
}
