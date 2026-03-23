<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TargetLog extends Model
{
    public const UPDATED_AT = null;

    protected $fillable = [
        'target_id',
        'added_hours',
        'note',
        'date',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function target(): BelongsTo
    {
        return $this->belongsTo(StudyTarget::class, 'target_id');
    }
}
