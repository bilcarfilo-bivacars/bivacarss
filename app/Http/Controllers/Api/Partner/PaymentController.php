<?php

namespace App\Http\Controllers\Api\Partner;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $partner = $request->user()->partner;

        return response()->json(
            Payment::query()->where('partner_id', $partner->id)->latest()->paginate(20)
        );
    }
}
