<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class TodoController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validate that we are actually getting data from the form
        $request->validate([
            'description' => 'required',
            'scheduled_at_string' => 'required',
        ]);

        // 2. Log this so we can see if it's working in the storage/logs/laravel.log
        Log::info('Attempting to save task: ' . $request->input('description'));

        // 3. Save to the database
        try {
            Todo::create([
                'user_id' => auth()->id(),
                'description' => $request->input('description'),
                'scheduled_at' => Carbon::parse($request->input('scheduled_at_string')),
                'email_sent' => false, // Default to false
            ]);

            return redirect()->back()->with('success', 'Task added successfully!');
        } catch (\Exception $e) {
            Log::error('Error saving task: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Failed to save task.']);
        }
    }
}