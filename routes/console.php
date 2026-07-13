<?php

use App\Jobs\HelloWorld;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;



Schedule::command('tasks:check-upcoming')->everyMinute();