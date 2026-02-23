<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = [
        'brand',
        'model',
        'year',
        'km',
        'listing_status',
        'listing_price_monthly',
        'is_featured',
    ];

    protected $casts = [
        'year' => 'integer',
        'km' => 'integer',
        'listing_price_monthly' => 'decimal:2',
        'is_featured' => 'boolean',
    ];
}
