<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Diary extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'content',
        'mood',
    ];

    public const MOOD_HAPPY = 'happy';
    public const MOOD_SAD = 'sad';
    public const MOOD_PRODUCTIVE = 'productive';
    public const MOOD_TIRED = 'tired';

    public const MOOD_OPTIONS = [
        self::MOOD_HAPPY,
        self::MOOD_SAD,
        self::MOOD_PRODUCTIVE,
        self::MOOD_TIRED,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
