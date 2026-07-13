<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Todo;
use App\Mail\TaskReminderMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class CheckUpcomingTasks extends Command
{
    protected $signature = 'tasks:check-upcoming';
    
    
    protected $description = 'Send custom email reminders based on user-selected timeframes';

    public function handle()
    {
        $now = Carbon::now();

        
        $tasks = Todo::with('user')
            ->where('email_sent', false)
            ->whereNotNull('reminder_minutes')
            ->where('scheduled_at', '<=', $now->copy()->addMinutes(40))
            ->get();

        Log::info('Checking tasks for custom reminders', ['count' => $tasks->count()]);

        foreach ($tasks as $task) {
           
            // Example: If task is at 12:20 and user chose 15 mins, target time is 12:05
            $reminderTargetTime = $task->scheduled_at->copy()->subMinutes($task->reminder_minutes);

            // If the current server time has hit or passed that calculated target time, fire!
            if ($now->greaterThanOrEqualTo($reminderTargetTime)) {
                if ($task->user && $task->user->email) {
                    Mail::to($task->user->email)->send(new TaskReminderMail($task));
                    
                    
                    $task->update(['email_sent' => true]);
                    
                    $this->info("Custom reminder sent for task: " . $task->description);
                }
            }
        }
    }
}