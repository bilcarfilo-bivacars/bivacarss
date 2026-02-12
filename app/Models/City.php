<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'region_group', 'active', 'sort_order'];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function districts(): HasMany
    {
        return $this->hasMany(District::class)->orderBy('sort_order')->orderBy('name');
    }

    public function points(): HasMany
    {
        return $this->hasMany(LocationPoint::class)->orderBy('sort_order')->orderBy('name');
    }
}
