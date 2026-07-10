<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Todo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class CheckUpcomingTasks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:check-upcoming';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email 5 mins before task starts';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get the exact time 5 minutes from right now
        $fiveMinsFromNow = Carbon::now()->addMinutes(5);

        // Find tasks happening at that exact time where no email has been sent yet
        $upcomingTasks = Todo::where('email_sent', false)
            ->whereBetween('scheduled_at', [
                $fiveMinsFromNow->copy()->subSeconds(30), 
                $fiveMinsFromNow->copy()->addSeconds(30)
            ])->get();

        foreach ($upcomingTasks as $task) {
            // Send the raw email
            Mail::raw("Your job '{$task->description}' begins in 5 minutes!", function ($message) use ($task) {
                $message->to($task->user->email)->subject('Task Reminder');
            });

            // Mark as sent so the scheduler doesn't spam them
            $task->update(['email_sent' => true]);
        }
    }
}