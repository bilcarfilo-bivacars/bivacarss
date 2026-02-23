<?php

namespace Database\Factories;

use App\Models\CorporateLead;
use Illuminate\Database\Eloquent\Factories\Factory;

class CorporateLeadFactory extends Factory
{
    protected $model = CorporateLead::class;

    public function definition(): array
    {
        return [
            'company_name' => fake()->company(),
            'contact_name' => fake()->name(),
            'contact_phone' => fake()->numerify('5#########'),
            'contact_email' => fake()->safeEmail(),
            'city' => fake()->city(),
            'district' => fake()->streetName(),
            'vehicles_needed' => fake()->numberBetween(1, 20),
            'budget_monthly' => fake()->numberBetween(20000, 150000),
            'status' => 'qualified',
            'lead_score' => fake()->numberBetween(40, 100),
            'lead_grade' => 'high',
        ];
    }
}
