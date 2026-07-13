<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class TodoController extends Controller
{
    public function index()
    {
        $todos = Todo::with('user')->get(); 
        $unsentTodos = Todo::where('email_sent', false)->get();
        return view('todos.index', compact('todos', 'unsentTodos'));
    }

    public function create()
    {
        $users = User::all();
        return view('todos.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'scheduled_at' => 'required|date',
        ]);

        try {
            $todo = Todo::create([
                'user_id' => $request->input('user_id'),
                'description' => $request->input('description'),
                'scheduled_at' => Carbon::parse($request->input('scheduled_at')),
                'email_sent' => false,
                'reminder_minutes' => null, 
            ]);

            
            $todo->load('user');

            
            Mail::send('emails.new_task', ['todo' => $todo], function ($message) use ($todo) {
                $message->to($todo->user->email)
                        ->subject('New Task Assigned: ' . $todo->description);
            });

            return redirect()->route('todos.index')->with('success', 'Task added and initial email sent!');
        } catch (\Exception $e) {
            Log::error('Error saving task: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Failed to save task: ' . $e->getMessage()]);
        }
    }

    
    public function setReminder(Todo $todo, $minutes)
    {
        
        $todo->update([
            'reminder_minutes' => (int) $minutes
        ]);

        
        return "
            <div style='text-align: center; margin-top: 100px; font-family: sans-serif;'>
                <h1 style='color: #2563eb;'>✔ Reminder Confirmed!</h1>
                <p style='color: #4b5563; font-size: 18px;'>You will receive an email reminder <strong>{$minutes} minutes</strong> before this task is due.</p>
                <a href='".route('todos.index')."' style='color: #2563eb; text-decoration: none;'>Go to To-Do List &rarr;</a>
            </div>
        ";
    }
}