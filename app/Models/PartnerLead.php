<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartnerLead extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'tax_number',
        'phone',
        'city',
        'brand',
        'model',
        'year',
        'km',
        'vehicles_count',
        'expected_rent',
        'has_damage',
        'notes',
        'photo_path',
        'calculation_json',
        'status',
        'lead_score',
        'lead_grade',
        'scored_at',
    ];

    protected $casts = [
        'has_damage' => 'boolean',
        'year' => 'integer',
        'km' => 'integer',
        'vehicles_count' => 'integer',
        'lead_score' => 'integer',
        'scored_at' => 'datetime',
        'expected_rent' => 'decimal:2',
    ];
}
