<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    protected $fillable = ['user_id', 'description', 'scheduled_at', 'email_sent'];

    // This makes date and boolean handling automatic
    protected $casts = [
        'scheduled_at' => 'datetime',
        'email_sent' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}