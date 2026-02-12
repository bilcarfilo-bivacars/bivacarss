<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class District extends Model
{
    use HasFactory;

    protected $fillable = ['city_id', 'name', 'slug', 'active', 'sort_order'];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function points(): HasMany
    {
        return $this->hasMany(LocationPoint::class)->orderBy('sort_order')->orderBy('name');
    }
}
