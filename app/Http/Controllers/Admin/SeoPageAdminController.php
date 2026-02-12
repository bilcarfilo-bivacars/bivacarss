<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SeoPage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SeoPageAdminController extends Controller
{
    public function index()
    {
        $pages = SeoPage::query()->orderByDesc('updated_at')->paginate(50);

        return view('admin.seo-pages.index', compact('pages'));
    }

    public function store(Request $request): RedirectResponse
    {
        SeoPage::query()->updateOrCreate(
            $request->validate([
                'page_type' => 'required|in:city,district,point',
                'ref_id' => 'required|integer|min:1',
            ]),
            array_merge(
                $request->validate([
                    'h1' => 'nullable|string|max:255',
                    'title' => 'nullable|string|max:255',
                    'meta_description' => 'nullable|string|max:500',
                    'content' => 'nullable|string',
                    'faq_json' => 'nullable|string',
                    'schema_override' => 'nullable|string',
                ]),
                ['updated_by' => optional($request->user())->id]
            )
        );

        return back();
    }
}
