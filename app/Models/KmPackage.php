<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KmPackage extends Model
{
    protected $fillable = [
        'km_limit',
        'yearly_price',
        'is_active',
    ];

    protected $casts = [
        'km_limit' => 'integer',
        'yearly_price' => 'decimal:2',
        'is_active' => 'boolean',
    ];
}
