<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VehicleMaintenanceRecord extends Model
{
    protected $fillable = [
        'vehicle_id',
        'type',
        'title',
        'description',
        'due_date',
        'cost_estimate',
        'status',
        'created_by',
        'completed_at',
    ];

    protected $casts = [
        'due_date' => 'date',
        'completed_at' => 'datetime',
        'cost_estimate' => 'decimal:2',
    ];

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
