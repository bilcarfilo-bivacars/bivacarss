<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ChatbotFlow extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'name',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function messages(): HasMany
    {
        return $this->hasMany(ChatbotMessage::class, 'flow_id');
    }
}
