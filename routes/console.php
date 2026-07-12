<?php

use App\Jobs\HelloWorld;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

// Change this to match your needs
Schedule::job(new HelloWorld)->everyFiveMinutes(); 

// This will run once every minute, checking for tasks due within the next 5 minutes
Schedule::command('tasks:check-upcoming')->everyMinute();