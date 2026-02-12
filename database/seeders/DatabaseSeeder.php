<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user seed (MVP)
        User::query()->updateOrCreate(
            ['email' => 'admin@bivacars.com'],
            [
                'name' => 'BivaCars Admin',
                'phone' => '5550000000',
                'password' => Hash::make('Admin12345!'),
                'role' => 'admin',
                'status' => 'active',
            ]
        );

        // Service areas + SEO pages seed
        $this->call([
            ServiceAreasSeeder::class,
        ]);
    }
}
