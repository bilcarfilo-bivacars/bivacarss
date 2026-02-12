<?php

namespace App\Http\Controllers\PublicWeb;

use App\Http\Controllers\Controller;
use App\Models\CorporateModel;
use App\Models\KmPackage;

class CorporateRentalPageController extends Controller
{
    public function __invoke()
    {
        return view('public.corporate.rental', [
            'models' => CorporateModel::query()->get(),
            'packages' => KmPackage::query()->get(['id', 'km_limit', 'yearly_price']),
        ]);
    }
}
