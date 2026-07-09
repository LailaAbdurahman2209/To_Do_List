<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Team;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    
    public function run(): void
    {
        
        $user = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Laila Admin',
                'password' => Hash::make('password123'),
            ]
        );

        
        $marketing = Team::firstOrCreate(['slug' => 'marketing'], ['name' => 'Marketing']);
        $dev = Team::firstOrCreate(['slug' => 'development'], ['name' => 'Development']);

       
        if (!$user->teams()->where('team_id', $marketing->id)->exists()) {
            $user->teams()->attach($marketing->id, ['role' => 'owner']);
        }

        
        $user->team_id = $marketing->id;
        $user->save();
    }
}