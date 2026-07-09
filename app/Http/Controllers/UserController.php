<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Display listing with Team Filter and Search.
     */
    public function index(Request $request)
    {
        
        $query = User::query()->with('currentTeam');

        Log::debug('Whats this');

        // 1. Filter by current_team_id (using Jetstream's active context)
        if ($request->filled('team_id')) {
            $query->where('current_team_id', $request->team_id);
        }

        // 2. Apply Search
        $this->applySearchFilters($query, $request);

        $users = $query->latest('created_at')->paginate(10)->appends($request->query());
        
        return view('users.index', compact('users'));
    }

    /**
     * Store new user.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'team_id' => ['nullable', 'exists:teams,id'], 
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'current_team_id' => $validated['team_id'] ?? null, 
        ]);

        // Link to the team in the pivot table for Jetstream consistency
        if ($request->filled('team_id')) {
            $user->teams()->attach($validated['team_id'], ['role' => 'editor']);
        }

        return response()->json(['success' => true, 'message' => 'User created!']);
    }

    /**
     * Data for Edit modal.
     */
    public function edit(User $user)
    {
        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'team_id' => $user->current_team_id
        ]);
    }

    /**
     * Update user details.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8'],
            'team_id' => ['nullable', 'exists:teams,id'], 
        ]);

        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'current_team_id' => $validated['team_id'] ?? null, 
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $user->update($updateData);
        
        // Sync the pivot table
        if ($request->filled('team_id')) {
            $user->teams()->syncWithoutDetaching([$validated['team_id'] => ['role' => 'editor']]);
        }

        return response()->json(['success' => true, 'message' => 'User updated!']);
    }

    /**
     * Delete user account.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted!');
    }

    /**
     * Helper for search.
     */
    protected function applySearchFilters($query, Request $request)
    {
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('email', 'LIKE', "%{$searchTerm}%");
            });
        }
    }
}