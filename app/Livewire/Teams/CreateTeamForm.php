<?php

namespace App\Livewire\Teams;

use Illuminate\Support\Facades\Auth;
use Laravel\Jetstream\Contracts\CreatesTeams;
use Laravel\Jetstream\Http\Livewire\CreateTeamForm as BaseCreateTeamForm;

class CreateTeamForm extends BaseCreateTeamForm
{
  
    public function createTeam(CreatesTeams $creator)
    {
        $this->resetErrorBag();

        
        $creator->create(Auth::user(), $this->state);

        
        $teamId = Auth::user()->fresh()->currentTeam->id;

        
        $this->reset('state');

       
        return redirect()->route('teams.show', $teamId)
                         ->with('flash.banner', 'Team created successfully!');
    }
}