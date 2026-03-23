<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StudyTarget extends Model
{
    public const STATUS_ACTIVE = 'active';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_EXPIRED = 'expired';

    protected $fillable = [
        'user_id',
        'title',
        'period_type',
        'target_hours',
        'current_hours',
        'start_date',
        'end_date',
        'status',
        'deadline',
        'is_completed',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'deadline' => 'date',
        'is_completed' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function logs(): HasMany
    {
        return $this->hasMany(TargetLog::class, 'target_id');
    }

    public function resolveStatus(?Carbon $today = null): string
    {
        $today = $today ?: now()->startOfDay();

        if ((int) $this->current_hours >= (int) $this->target_hours) {
            return self::STATUS_COMPLETED;
        }

        if ($this->end_date && $today->gt(Carbon::parse($this->end_date)->startOfDay())) {
            return self::STATUS_EXPIRED;
        }

        return self::STATUS_ACTIVE;
    }

    public function syncStatus(): void
    {
        $status = $this->resolveStatus();
        $isCompleted = $status === self::STATUS_COMPLETED;

        $this->fill([
            'status' => $status,
            'is_completed' => $isCompleted,
            'deadline' => $this->end_date,
        ]);

        if ($this->isDirty()) {
            $this->save();
        }
    }

    public static function syncStatusesForUser(User $user): void
    {
        $targets = $user->studyTargets()->get();

        foreach ($targets as $target) {
            $target->syncStatus();
        }
    }
}
