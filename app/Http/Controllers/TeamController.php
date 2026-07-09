<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    /**
     * Display a listing of the teams.
     */
    public function index()
    {
        $teams = Team::all();
        return view('teams.index', compact('teams'));
    }

    /**
     * Store a newly created team in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:teams,slug',
        ]);

        // Create the team and capture the instance
        $team = Team::create($validated);

        // Redirect to the show page of the newly created team
        return redirect()->route('teams.show', $team->id)
                         ->with('success', 'Team created successfully!');
    }

    /**
     * Display the specified team.
     */
    public function show(Team $team)
    {
        // This will now handle the redirect from the store method
        return view('teams.show', compact('team'));
    }
}