<?php

namespace App\Services\Leads;

use App\Models\CorporateLead;
use App\Models\PartnerLead;
use App\Services\Tax\NullTaxVerifier;
use App\Services\Tax\TaxVerifierInterface;
use Illuminate\Support\Facades\Schema;

class LeadScoringService
{
    private const SANAYI_CITIES = [
        'Kocaeli', 'İstanbul', 'Bursa', 'Ankara', 'İzmir', 'Gaziantep', 'Konya', 'Kayseri', 'Tekirdağ',
        'Manisa', 'Sakarya', 'Adana', 'Mersin', 'Eskişehir', 'Denizli', 'Hatay', 'Kahramanmaraş', 'Şanlıurfa',
    ];

    public function __construct(private readonly ?TaxVerifierInterface $taxVerifier = null)
    {
    }

    public function scorePartnerLead(PartnerLead $lead): array
    {
        $score = 0;
        $vehiclesCount = (int) ($lead->vehicles_count ?? 0);

        if ($vehiclesCount >= 10) {
            $score += 40;
        } elseif ($vehiclesCount >= 3) {
            $score += 20;
        }

        if ($this->isIndustrialCity($lead->city)) {
            $score += 15;
        }

        if (Schema::hasColumn('partner_leads', 'expected_rent') && $lead->expected_rent !== null && (float) $lead->expected_rent >= 40000) {
            $score += 10;
        }

        if (Schema::hasColumn('partner_leads', 'has_damage') && $lead->has_damage === false) {
            $score += 5;
        }

        if (Schema::hasColumn('partner_leads', 'phone') && filled($lead->phone)) {
            $score += 5;
        }

        return $this->persistScore($lead, $score);
    }

    public function scoreCorporateLead(CorporateLead $lead): array
    {
        $score = 0;
        $vehiclesNeeded = (int) ($lead->vehicles_needed ?? 0);

        if ($vehiclesNeeded >= 20) {
            $score += 45;
        } elseif ($vehiclesNeeded >= 10) {
            $score += 30;
        }

        if ((float) ($lead->budget_monthly ?? 0) >= 1000000) {
            $score += 20;
        }

        if (filled($lead->sector)) {
            $score += 10;
        }

        if ($this->isIndustrialCity($lead->city)) {
            $score += 15;
        }

        if ($this->taxVerifier()->isValid($lead->tax_number)) {
            $score += 10;
        }

        return $this->persistScore($lead, $score);
    }

    private function persistScore(PartnerLead|CorporateLead $lead, int $score): array
    {
        $score = max(0, min(100, $score));
        $grade = $score >= 70 ? 'high' : ($score >= 40 ? 'medium' : 'low');

        $lead->forceFill([
            'lead_score' => $score,
            'lead_grade' => $grade,
            'scored_at' => now(),
        ])->save();

        return ['score' => $score, 'grade' => $grade];
    }

    private function taxVerifier(): TaxVerifierInterface
    {
        return $this->taxVerifier ?? new NullTaxVerifier();
    }

    private function isIndustrialCity(?string $city): bool
    {
        if (! filled($city)) {
            return false;
        }

        $normalizedCity = $this->normalize($city);

        foreach (self::SANAYI_CITIES as $sanayiCity) {
            if ($normalizedCity === $this->normalize($sanayiCity)) {
                return true;
            }
        }

        return false;
    }

    private function normalize(?string $value): string
    {
        $value = trim((string) $value);
        $value = str_replace(["\t", "\n", "\r"], ' ', $value);
        $value = preg_replace('/\s+/', ' ', $value) ?? $value;

        return mb_convert_case($value, MB_CASE_LOWER, 'UTF-8');
    }
}
