<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Industry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class IndustryAdminController extends Controller
{
    public function index(): View
    {
        $industries = Industry::query()->orderBy('sort_order')->orderBy('name')->get();

        return view('admin.industries.index', compact('industries'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'key' => ['required', 'string', 'max:255', 'unique:industries,key'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer'],
            'active' => ['nullable', 'boolean'],
        ]);

        Industry::query()->create($validated + ['active' => $request->boolean('active')]);

        return back()->with('success', 'Sektör eklendi.');
    }

    public function update(Request $request, Industry $industry): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer'],
            'active' => ['nullable', 'boolean'],
        ]);

        $industry->update($validated + ['active' => $request->boolean('active')]);

        return back()->with('success', 'Sektör güncellendi.');
    }
}
