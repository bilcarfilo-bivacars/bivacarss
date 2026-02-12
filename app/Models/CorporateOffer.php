<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CorporateOffer extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'contact_person',
        'contact_phone',
        'contact_email',
        'brand',
        'model',
        'km_package_id',
        'monthly_price',
        'vat_rate',
        'notes',
        'pdf_path',
        'status',
        'created_by',
        'sent_at',
    ];

    protected $casts = [
        'monthly_price' => 'decimal:2',
        'vat_rate' => 'decimal:2',
        'sent_at' => 'datetime',
    ];

    public function kmPackage(): BelongsTo
    {
        return $this->belongsTo(KmPackage::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
