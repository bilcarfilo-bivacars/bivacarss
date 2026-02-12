<?php

namespace App\Http\Controllers;

use App\Models\CorporateOffer;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class PublicOfferController extends Controller
{
    public function showPdf(CorporateOffer $corporateOffer): Response
    {
        abort_unless(request()->hasValidSignature(), 403);
        abort_unless($corporateOffer->pdf_path && Storage::disk('public')->exists($corporateOffer->pdf_path), 404);

        return response(Storage::disk('public')->get($corporateOffer->pdf_path), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="offer-' . $corporateOffer->id . '.pdf"',
        ]);
    }
}
