<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Todo;
use App\Mail\TaskReminderMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class CheckUpcomingTasks extends Command
{
    protected $signature = 'tasks:check-upcoming';
    protected $description = 'Send email reminders for tasks starting in 5 minutes';

    public function handle()
    {
        // Calculate the 5-minute window
        $now = Carbon::now();
        $targetTime = $now->copy()->addMinutes(5);

        // Find pending tasks in that window
        $tasks = Todo::where('email_sent', false)
            ->where('scheduled_at', '>=', $targetTime->copy()->subSeconds(30))
            ->where('scheduled_at', '<=', $targetTime->copy()->addSeconds(30))
            ->get();

        foreach ($tasks as $task) {
            if ($task->user && $task->user->email) {
                Mail::to($task->user->email)->send(new TaskReminderMail($task));
                
                $task->update(['email_sent' => true]);
                
                $this->info("Reminder sent for task: " . $task->description);
            }
        }
    }
