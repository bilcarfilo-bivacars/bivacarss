<?php

namespace App\Services\Tax;

class NullTaxVerifier implements TaxVerifierInterface
{
    public function isValid(?string $taxNumber): bool
    {
        if ($taxNumber === null) {
            return false;
        }

        $taxNumber = trim($taxNumber);

        return preg_match('/^\d{10}$/', $taxNumber) === 1 || preg_match('/^\d{11}$/', $taxNumber) === 1;
    }
}
