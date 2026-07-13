<?php

namespace App\Providers;

use App\Models\Team;
use App\Models\User;
use Livewire\Livewire; 
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Gate; 
use App\Livewire\Teams\CreateTeamForm; 
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    

    public function register(): void
    {
        
    }

   
    public function boot(): void
    {
       
        View::composer('users.index', function ($view) {
            $view->with('corporateTeams', Team::all());
        });

      
        Livewire::component('create-team-form', CreateTeamForm::class);

        
        Gate::define('manage-operations', function (User $user) {
            return (bool) $user->is_admin;
        });
    }
}
