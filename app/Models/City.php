<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = ['name', 'slug', 'region_group'];

    public function industries()
    {
        return $this->belongsToMany(Industry::class, 'city_industries')
            ->withPivot(['id', 'active', 'sort_order'])
            ->withTimestamps();
    }
}
