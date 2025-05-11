<?php

use Illuminate\Support\Facades\Schedule;

// Schedule::command('app:send-daily-reports')
//     ->dailyAt('23:55')
//     ->timezone('America/Sao_Paulo');

Schedule::command('app:send-daily-reports')->everyFourMinutes();
