<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');

Route::get('/popup-settings', function () {
    return [
        'enabled' => filter_var(Setting::getValue('popup_enabled', 'true'), FILTER_VALIDATE_BOOLEAN),
        'text' => Setting::getValue('popup_text', ''),
        'repeat_hours' => (int) Setting::getValue('popup_repeat_hours', '24'),
    ];
});
