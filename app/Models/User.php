<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'class_level',
        'learning_goal',
        'is_premium',
        'is_admin',
        'is_banned',
        'banned_at',
        'premium_activated_at',
        'premium_verification_email',
        'premium_payment_proof_path',
        'premium_verification_status',
        'premium_payment_submitted_at',
        'password',
        'current_streak',
        'grace_used_month',
        'grace_month',
        'streak_calculated_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'streak_calculated_at' => 'date',
            'is_premium' => 'boolean',
            'is_admin' => 'boolean',
            'is_banned' => 'boolean',
            'banned_at' => 'datetime',
            'premium_activated_at' => 'datetime',
            'premium_payment_submitted_at' => 'datetime',
        ];
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }

    public function studyTargets(): HasMany
    {
        return $this->hasMany(StudyTarget::class);
    }

    public function studySessions(): HasMany
    {
        return $this->hasMany(StudySession::class);
    }

    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }

    public function aiMessages(): HasMany
    {
        return $this->hasMany(AiMessage::class);
    }
}
