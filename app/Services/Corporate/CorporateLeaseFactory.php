<?php

namespace App\Services\Corporate;

use App\Models\CorporateLead;
use App\Models\CorporateLease;
use App\Models\KmPackage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CorporateLeaseFactory
{
    public function createFromLead(CorporateLead $lead): CorporateLease
    {
        return DB::transaction(function () use ($lead): CorporateLease {
            $kmPackage = $this->resolveKmPackage($lead);

            $lease = CorporateLease::query()->create([
                'company_name' => $lead->company_name,
                'contact_name' => $lead->contact_name,
                'contact_phone' => $lead->contact_phone,
                'contact_email' => $lead->contact_email,
                'km_package_id' => $kmPackage?->id,
                'monthly_price' => $kmPackage?->yearly_price ?? 0,
                'vat_rate' => 20,
                'status' => 'draft',
                'payment_status' => 'pending',
                'created_by' => Auth::id() ?? 1,
                'source_lead_id' => $lead->id,
                'pipeline_stage' => 'qualified',
                'notes' => $this->buildNotes($lead),
            ]);

            $lead->update([
                'converted_to_lease_id' => $lease->id,
            ]);

            return $lease;
        });
    }

    private function resolveKmPackage(CorporateLead $lead): ?KmPackage
    {
        if ((int) $lead->vehicles_needed >= 10) {
            $package = KmPackage::query()->where('km_limit', 30000)->first();
            if ($package) {
                return $package;
            }
        }

        $package = KmPackage::query()->where('km_limit', 20000)->first();
        if ($package) {
            return $package;
        }

        return KmPackage::query()
            ->when($this->hasIsActiveColumn(), fn ($query) => $query->where('is_active', true))
            ->orderBy('id')
            ->first();
    }

    private function hasIsActiveColumn(): bool
    {
        return DB::getSchemaBuilder()->hasColumn('km_packages', 'is_active');
    }

    private function buildNotes(CorporateLead $lead): ?string
    {
        $parts = array_filter([
            $lead->notes,
            $lead->city ? 'Şehir: '.$lead->city : null,
            $lead->district ? 'İlçe: '.$lead->district : null,
        ]);

        return empty($parts) ? null : implode(PHP_EOL, $parts);
    }
}
