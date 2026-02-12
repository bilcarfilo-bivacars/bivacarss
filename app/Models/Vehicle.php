<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'partner_id',
        'brand',
        'model',
        'year',
        'transmission',
        'fuel_type',
        'km',
        'plate',
        'listing_status',
        'listing_price_monthly',
        'listing_vat_mode',
        'base_price_daily',
        'is_featured',
        'featured_until',
        'custom_commission_rate',
        'gps_provider',
        'gps_external_id',
        'gps_login_url',
    ];

    protected $casts = [
        'featured_until' => 'datetime',
        'is_featured' => 'boolean',
    ];

    public function partner(): BelongsTo
    {
        return $this->belongsTo(Partner::class);
    }

    public function priceChangeRequests(): HasMany
    {
        return $this->hasMany(PriceChangeRequest::class);
    }
}
