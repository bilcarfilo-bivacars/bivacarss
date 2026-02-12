<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\PriceChangeRequest;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PriceChangeRequestController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $status = $request->string('status', 'pending')->toString();
        $requests = PriceChangeRequest::query()->where('status', $status)->with('vehicle')->latest()->paginate(20);

        return response()->json($requests);
    }

    public function approve(Request $request, PriceChangeRequest $priceRequest): JsonResponse
    {
        $priceRequest->update([
            'status' => 'approved',
            'admin_note' => $request->input('admin_note'),
            'approved_by' => $request->user()?->id,
            'approved_at' => Carbon::now(),
        ]);

        if ($priceRequest->request_type === 'price_drop' && $priceRequest->new_price !== null) {
            $priceRequest->vehicle->update(['listing_price_monthly' => $priceRequest->new_price]);
        }

        if ($priceRequest->request_type === 'feature_request') {
            $priceRequest->vehicle->update([
                'is_featured' => true,
                'featured_until' => Carbon::now()->addDays(30),
            ]);
        }

        return response()->json(['message' => 'Price request approved', 'request' => $priceRequest]);
    }

    public function reject(Request $request, PriceChangeRequest $priceRequest): JsonResponse
    {
        $priceRequest->update([
            'status' => 'rejected',
            'admin_note' => $request->input('admin_note'),
            'approved_by' => $request->user()?->id,
            'approved_at' => Carbon::now(),
        ]);

        return response()->json(['message' => 'Price request rejected', 'request' => $priceRequest]);
    }
}
