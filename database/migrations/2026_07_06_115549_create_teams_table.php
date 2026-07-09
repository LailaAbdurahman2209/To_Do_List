<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Check if the table doesn't exist yet
        if (!Schema::hasTable('teams')) {
            Schema::create('teams', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->nullable();
                $table->string('name');
                $table->string('slug')->unique();
                $table->boolean('personal_team')->default(true);
                $table->boolean('is_archived')->default(false); // Safeguard archiving column
                $table->timestamps();
            });
        } else {
            // If the table already exists, securely add the column if it's missing
            if (!Schema::hasColumn('teams', 'is_archived')) {
                Schema::table('teams', function (Blueprint $table) {
                    $table->boolean('is_archived')->default(false)->after('personal_team');
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // For production safety, we check if the column exists before dropping it, 
        // avoiding dropping the whole table if it holds critical historical data.
        if (Schema::hasTable('teams') && Schema::hasColumn('teams', 'is_archived')) {
            Schema::table('teams', function (Blueprint $table) {
                $table->dropColumn('is_archived');
            });
        }
    }
};