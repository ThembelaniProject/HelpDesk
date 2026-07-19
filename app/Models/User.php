<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable([
    'name',
    'email',
    'password',
    'role_id',
    'profile_photo',
])]

#[Hidden([
    'password',
    'remember_token',
])]

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Attribute casting
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * User belongs to a role.
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Tickets created by this user.
     */
    
    public function tickets()
{
    return $this->hasMany(Ticket::class, 'user_id');
}

    /**
     * Tickets assigned to this technician.
     */
    public function assignedTickets(): HasMany
    {
        return $this->hasMany(Ticket::class, 'technician_id');
    }

    /**
     * Comments written by this user.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Activity logs created by this user.
     */
    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class);
    }

    public function notifications()
{
    return $this->hasMany(Notification::class)
                ->latest();
}

 
}