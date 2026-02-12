<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PartnerLead;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PartnerLeadAdminController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->string('status')->toString();

        $leads = PartnerLead::query()
            ->when($status !== '', fn ($query) => $query->where('status', $status))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.partner-leads.index', [
            'leads' => $leads,
            'status' => $status,
        ]);
    }

    public function show(int $id): View
    {
        $lead = PartnerLead::query()->findOrFail($id);

        return view('admin.partner-leads.show', compact('lead'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:new,contacted,converted,archived'],
        ]);

        $lead = PartnerLead::query()->findOrFail($id);
        $lead->update(['status' => $validated['status']]);

        return redirect()
            ->route('admin.partner-leads.show', $lead->id)
            ->with('success', 'Lead durumu güncellendi.');
    }
}
