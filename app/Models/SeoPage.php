<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeoPage extends Model
{
    use HasFactory;

    protected $fillable = [
        'page_type',
        'ref_id',
        'h1',
        'title',
        'meta_description',
        'content',
        'faq_json',
        'schema_override',
        'updated_by',
    ];
}
