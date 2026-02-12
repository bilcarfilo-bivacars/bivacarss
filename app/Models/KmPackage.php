<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KmPackage extends Model
{
    use HasFactory;

    protected $fillable = [
        'km_limit',
        'yearly_price',
        'vat_included',
        'active',
    ];

    protected $casts = [
        'vat_included' => 'boolean',
        'active' => 'boolean',
    ];
}
