<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Industry;
use App\Models\SeoPage;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class IndustryController extends Controller
{
    public function index(): View
    {
        $industries = Cache::remember('bivacars:industries', now()->addHours(6), fn () => Industry::query()
            ->where('active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get());

        return view('public.industries.index', compact('industries'));
    }

    public function show(string $industrySlug): View
    {
        $industry = Industry::query()->where('key', $industrySlug)->where('active', true)->firstOrFail();
        $seoPage = SeoPage::query()->where('page_type', 'industry')->where('ref_id', $industry->id)->first();

        return view('public.industries.show', compact('industry', 'seoPage'));
    }
}
