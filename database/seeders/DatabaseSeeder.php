<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Team;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        
        $user = User::updateOrCreate(['email' => 'admin@example.com'], [
            'name' => 'Laila Admin',
            'password' => Hash::make('password123'),
        ]);

        
        DB::table('teams')->updateOrInsert(
            ['slug' => 'marketing'],
            [
                'name' => 'Marketing',
                'user_id' => $user->id,
                'personal_team' => false,
                'created_at' => now(),
                'updated_at' => now()
            ]
        );
    }
}