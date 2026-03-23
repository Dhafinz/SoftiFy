<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'subject',
        'description',
        'priority',
        'estimated_minutes',
        'due_date',
        'time',
        'status',
        'is_done',
        'completed_at',
    ];

    protected $casts = [
        'due_date' => 'date',
        'is_done' => 'boolean',
        'completed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
