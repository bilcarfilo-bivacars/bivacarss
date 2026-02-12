<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChatbotMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'flow_id',
        'trigger',
        'reply_text',
        'reply_type',
        'meta_json',
        'sort_order',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function flow(): BelongsTo
    {
        return $this->belongsTo(ChatbotFlow::class, 'flow_id');
    }

    public function getMetaAttribute(): ?array
    {
        return $this->meta_json ? json_decode($this->meta_json, true) : null;
    }
}
