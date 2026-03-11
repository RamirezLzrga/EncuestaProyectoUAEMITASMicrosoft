<?php

use App\Models\ActivityLog;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::call(function () {
    $cutoff = now()->subDays(5)->startOfDay();
    ActivityLog::whereNotNull('created_at')
        ->where('created_at', '<', $cutoff)
        ->delete();
})->dailyAt('03:00');
