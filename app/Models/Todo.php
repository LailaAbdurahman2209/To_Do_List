<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    // Added 'reminder_minutes' to allow mass-assignment
    protected $fillable = [
        'user_id', 
        'description', 
        'scheduled_at', 
        'email_sent', 
        'reminder_minutes'
    ];

    // Added 'reminder_minutes' to automatic casting
    protected $casts = [
        'scheduled_at' => 'datetime',
        'email_sent' => 'boolean',
        'reminder_minutes' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}