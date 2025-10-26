<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

$password = env('DB_PASSWORD');

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

// job whatsapp
Schedule::command('queue:work --stop-when-empty --queue=whatsapp')
    ->sendOutputTo(storage_path() . '/logs/whatsapp.log')
    ->withoutOverlapping()
    ->everyMinute();
// --stop-when-empty
