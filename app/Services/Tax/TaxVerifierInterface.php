<?php

namespace App\Services\Tax;

interface TaxVerifierInterface
{
    public function isValid(?string $taxNumber): bool;
}
