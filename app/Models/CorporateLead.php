<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CorporateLead extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'tax_number',
        'contact_name',
        'contact_phone',
        'contact_email',
        'city',
        'district',
        'sector',
        'vehicles_needed',
        'lease_months',
        'budget_monthly',
        'notes',
        'lead_score',
        'lead_grade',
        'status',
        'converted_to_lease_id',
        'scored_at',
    ];

    protected $casts = [
        'vehicles_needed' => 'integer',
        'lease_months' => 'integer',
        'budget_monthly' => 'decimal:2',
        'lead_score' => 'integer',
        'converted_to_lease_id' => 'integer',
        'scored_at' => 'datetime',
    ];

    public function convertedLease()
    {
        return $this->belongsTo(CorporateLease::class, 'converted_to_lease_id');
    }
}
