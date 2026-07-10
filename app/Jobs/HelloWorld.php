<?php

namespace App\Jobs;

use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class HelloWorld implements ShouldQueue{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(){
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void{
        Log::debug('Hello there I am a job');
    }
}
