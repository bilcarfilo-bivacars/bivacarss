<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CorporateLease extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'contact_name',
        'contact_phone',
        'contact_email',
        'corporate_model_id',
        'vehicle_id',
        'km_package_id',
        'monthly_price',
        'vat_rate',
        'start_date',
        'end_date',
        'status',
        'payment_status',
        'paid_at',
        'notes',
        'created_by',
        'source_lead_id',
        'pipeline_stage',
        'matched_vehicle_id',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'paid_at' => 'datetime',
        'monthly_price' => 'decimal:2',
        'vat_rate' => 'decimal:2',
        'source_lead_id' => 'integer',
        'matched_vehicle_id' => 'integer',
    ];

    public function model()
    {
        return $this->belongsTo(CorporateModel::class, 'corporate_model_id');
    }

    public function kmPackage()
    {
        return $this->belongsTo(KmPackage::class, 'km_package_id');
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function matchedVehicle()
    {
        return $this->belongsTo(Vehicle::class, 'matched_vehicle_id');
    }

    public function sourceLead()
    {
        return $this->belongsTo(CorporateLead::class, 'source_lead_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
