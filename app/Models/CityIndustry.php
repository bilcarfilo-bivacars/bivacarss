<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CityIndustry extends Model
{
    protected $fillable = ['city_id', 'industry_id', 'active', 'sort_order'];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function industry()
    {
        return $this->belongsTo(Industry::class);
    }
}
