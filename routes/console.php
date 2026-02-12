<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment('BivaCars hazır 🚗');
})->purpose('Display an inspiring quote');
