<?php

use App\Jobs\HelloWorld;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

//This is a test job for Hello world.. Nothing to extreme
Schedule::job(new HelloWorld)->everyFiveSeconds();


Schedule::command('tasks:check-upcoming')->everyMinute();