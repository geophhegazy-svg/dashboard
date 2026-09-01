<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;


Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
// ->everyMinute();

Schedule::command('subscriptions:auto-renew')
    ->dailyAt('00:05')
    ->withoutOverlapping();

Schedule::command('subscriptions:auto-grace')
    ->dailyAt('00:10')
    ->withoutOverlapping();

Schedule::command('subscriptions:auto-expire')
    ->dailyAt('00:15')
    ->withoutOverlapping();
