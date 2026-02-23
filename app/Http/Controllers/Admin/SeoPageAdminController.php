<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SeoPage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SeoPageAdminController extends Controller
{
    public function index(Request $request): View
    {
        $pageType = $request->string('page_type')->toString();

        $seoPages = SeoPage::query()
            ->when($pageType !== '', fn ($query) => $query->where('page_type', $pageType))
            ->latest()
            ->paginate(30)
            ->withQueryString();

        return view('admin.seo-pages.index', compact('seoPages', 'pageType'));
    }

    public function update(Request $request, SeoPage $seoPage): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'content' => ['nullable', 'string'],
            'schema_override' => ['nullable', 'string'],
        ]);

        $seoPage->update($validated);

        return back()->with('success', 'SEO sayfası güncellendi.');
    }
}
