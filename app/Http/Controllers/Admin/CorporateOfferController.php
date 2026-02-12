<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCorporateOfferRequest;
use App\Models\CorporateOffer;
use App\Models\CorporateModel;
use App\Models\KmPackage;
use App\Services\Pdf\CorporateOfferPdfService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class CorporateOfferController extends Controller
{
    public function index(Request $request): View|JsonResponse
    {
        $offers = CorporateOffer::with('kmPackage')->latest()->paginate(20);

        if ($request->is('api/*')) {
            return response()->json($offers);
        }

        return view('admin.corporate-offers.index', compact('offers'));
    }

    public function create(): View
    {
        return view('admin.corporate-offers.create', [
            'kmPackages' => KmPackage::query()->orderBy('km_limit')->get(),
            'corporateModels' => CorporateModel::query()->orderBy('brand')->orderBy('model')->get(),
        ]);
    }

    public function store(StoreCorporateOfferRequest $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validated();
        $validated['created_by'] = $request->user()->id;
        $validated['contact_phone'] = $this->sanitizePhone($validated['contact_phone'] ?? null);
        $validated['vat_rate'] = $validated['vat_rate'] ?? 20.00;

        $offer = CorporateOffer::create($validated);

        if ($request->is('api/*')) {
            return response()->json($offer, 201);
        }

        return redirect()->route('admin.corporate-offers.show', $offer);
    }

    public function show(CorporateOffer $corporateOffer): View
    {
        $corporateOffer->load('kmPackage');

        $pdfUrl = $corporateOffer->pdf_path ? Storage::disk('public')->url($corporateOffer->pdf_path) : null;

        $signedPdfUrl = $corporateOffer->pdf_path
            ? url()->temporarySignedRoute('public.offer.pdf', now()->addDays(7), ['corporateOffer' => $corporateOffer->id])
            : null;

        $whatsAppText = sprintf(
            'Merhaba %s, %s %s - %s km paketi için teklif PDF: %s',
            $corporateOffer->company_name ?? 'değerli müşterimiz',
            $corporateOffer->brand,
            $corporateOffer->model,
            $corporateOffer->kmPackage?->km_limit,
            $signedPdfUrl ?? $pdfUrl
        );

        return view('admin.corporate-offers.show', [
            'offer' => $corporateOffer,
            'pdfUrl' => $pdfUrl,
            'signedPdfUrl' => $signedPdfUrl,
            'whatsAppLink' => 'https://wa.me/?text=' . urlencode($whatsAppText),
        ]);
    }

    public function generatePdf(CorporateOffer $corporateOffer, CorporateOfferPdfService $pdfService): JsonResponse|RedirectResponse
    {
        $path = $pdfService->generateAndStore($corporateOffer);

        $corporateOffer->forceFill([
            'pdf_path' => $path,
            'status' => 'generated',
        ])->save();

        if (request()->is('api/*')) {
            return response()->json([
                'pdf_path' => $path,
                'url' => Storage::disk('public')->url($path),
            ]);
        }

        return back()->with('status', 'PDF oluşturuldu.');
    }

    public function markSent(CorporateOffer $corporateOffer): JsonResponse|RedirectResponse
    {
        $corporateOffer->forceFill([
            'status' => 'sent',
            'sent_at' => Carbon::now(),
        ])->save();

        if (request()->is('api/*')) {
            return response()->json(['ok' => true]);
        }

        return back()->with('status', 'Teklif gönderildi olarak işaretlendi.');
    }

    protected function sanitizePhone(?string $value): ?string
    {
        if (! $value) {
            return null;
        }

        return preg_replace('/[^\d+]/', '', $value);
    }
}
