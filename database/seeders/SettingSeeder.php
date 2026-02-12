<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            'contracts_module_enabled' => 'false',
            'partner_upload_contracts_enabled' => 'false',
            'popup_enabled' => 'true',
            'popup_text' => 'BivaCars sizden kapora veya ödeme talep etmez...',
            'popup_repeat_hours' => '24',
        ];

        foreach ($defaults as $key => $value) {
            Setting::query()->updateOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}
