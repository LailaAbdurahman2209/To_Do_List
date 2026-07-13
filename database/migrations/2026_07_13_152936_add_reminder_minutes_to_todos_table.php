<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('todos', function (Blueprint $table) {
            // Adds a nullable integer column for the custom reminder time
            $table->integer('reminder_minutes')->nullable()->after('email_sent');
        });
    }

    public function down()
    {
        Schema::table('todos', function (Blueprint $table) {
            $table->dropColumn('reminder_minutes');
        });
    }
};