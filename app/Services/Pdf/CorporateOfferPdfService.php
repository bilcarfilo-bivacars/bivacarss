<?php

namespace App\Services\Pdf;

use App\Models\CorporateOffer;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class CorporateOfferPdfService
{
    public function generateAndStore(CorporateOffer $offer): string
    {
        $offer->loadMissing('kmPackage');

        $pdf = Pdf::loadView('pdf.corporate-offer', [
            'offer' => $offer,
            'company' => config('bivacars'),
        ]);

        $path = sprintf('corporate-offers/offer-%d-%s.pdf', $offer->id, now()->format('YmdHis'));
        Storage::disk('public')->put($path, $pdf->output());

        return $path;
    }
}
