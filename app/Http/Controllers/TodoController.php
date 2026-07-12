<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class TodoController extends Controller
{
    // 1. Show the list of Todos
    public function index()
    {
        // Showing all tasks so you can see assignments
        $todos = Todo::with('user')->get(); 
        return view('todos.index', compact('todos'));
    }

    // 2. Show the "Create" form
    public function create()
    {
        $users = User::all(); // Fetch users to populate the dropdown
        return view('todos.create', compact('users'));
    }

    // 3. Save the Todo to the database
    public function store(Request $request)
    {
        // Validation: Ensure the names here match your form inputs
        $request->validate([
            'description' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'scheduled_at' => 'required|date',
        ]);

        try {
            Todo::create([
                'user_id' => $request->input('user_id'), // Assign to the selected user
                'description' => $request->input('description'),
                'scheduled_at' => Carbon::parse($request->input('scheduled_at')),
                'email_sent' => false,
            ]);

            return redirect()->route('todos.index')->with('success', 'Task added successfully!');
        } catch (\Exception $e) {
            Log::error('Error saving task: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Failed to save task: ' . $e->getMessage()]);
        }
    }
}