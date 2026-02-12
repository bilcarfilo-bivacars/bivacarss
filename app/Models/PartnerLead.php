<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartnerLead extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'phone',
        'city',
        'brand',
        'model',
        'year',
        'km',
        'expected_rent',
        'has_damage',
        'notes',
        'photo_path',
        'calculation_json',
        'status',
    ];

    protected $casts = [
        'has_damage' => 'boolean',
        'year' => 'integer',
        'km' => 'integer',
        'expected_rent' => 'decimal:2',
    ];
}
