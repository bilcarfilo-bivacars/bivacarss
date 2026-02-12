<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AiPrompt extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'name',
        'system_prompt',
        'user_prompt_template',
        'model',
        'temperature',
        'max_tokens',
        'active',
    ];

    protected $casts = [
        'temperature' => 'float',
        'max_tokens' => 'integer',
        'active' => 'boolean',
    ];
}
