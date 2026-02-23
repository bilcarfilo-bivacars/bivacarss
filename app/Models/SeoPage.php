<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeoPage extends Model
{
    protected $fillable = [
        'page_type',
        'ref_id',
        'locale',
        'slug',
        'title',
        'description',
        'content',
        'faq_json',
        'schema_override',
    ];

    protected $casts = [
        'faq_json' => 'array',
    ];
}
