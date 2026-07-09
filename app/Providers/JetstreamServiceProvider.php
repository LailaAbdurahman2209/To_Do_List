<?php

namespace App\Providers;

use App\Actions\Jetstream\AddTeamMember;
use App\Actions\Jetstream\CreateTeam;
use App\Actions\Jetstream\DeleteTeam;
use App\Actions\Jetstream\DeleteUser;
use App\Actions\Jetstream\InviteTeamMember;
use App\Actions\Jetstream\RemoveTeamMember;
use App\Actions\Jetstream\UpdateTeamName;
use Illuminate\Support\ServiceProvider;
use Laravel\Jetstream\Jetstream;
use Laravel\Jetstream\Contracts\CreatesTeamResponse;
use Laravel\Jetstream\Contracts\SwitchTeamResponse as SwitchTeamResponseContract;

class JetstreamServiceProvider extends ServiceProvider
{
    
    public function register(): void
    {
        
    }

    
    public function boot(): void
    {
        $this->configurePermissions();

        Jetstream::updateTeamNamesUsing(UpdateTeamName::class);
        Jetstream::addTeamMembersUsing(AddTeamMember::class);
        Jetstream::inviteTeamMembersUsing(InviteTeamMember::class);
        Jetstream::removeTeamMembersUsing(RemoveTeamMember::class);
        Jetstream::deleteTeamsUsing(DeleteTeam::class);
        Jetstream::deleteUsersUsing(DeleteUser::class);

        
        Jetstream::createTeamsUsing(CreateTeam::class);

        
        \Livewire\Livewire::component('teams.create-team-form', \App\Livewire\Teams\CreateTeamForm::class);

        
        $this->app->singleton(CreatesTeamResponse::class, function () {
            return new class implements CreatesTeamResponse {
                public function toResponse($request) {
                    $team = $request->user()->currentTeam;
                    session(['flash.banner' => 'Team created successfully! You can now add members below.']);
                    return redirect()->route('teams.show', $team->id);
                }
            };
        });

       
        $this->app->singleton(SwitchTeamResponseContract::class, function () {
            return new class implements SwitchTeamResponseContract {
                public function toResponse($request) {
                    return redirect()->back();
                }
            };
        });
    }

    
    protected function configurePermissions(): void
    {
        Jetstream::defaultApiTokenPermissions(['read']);

        Jetstream::role('admin', 'Admin', [
            'create',
            'read',
            'update',
            'delete',
        ])->description('Admin users can perform any action and manage team logistics.');

        Jetstream::role('operations', 'Operations', [
            'read',
            'update',
        ])->description('Operations members can view and update dashboard activities.');
    }
}