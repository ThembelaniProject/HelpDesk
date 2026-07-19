<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
 use App\Models\ActivityLog;

class Ticket extends Model
{
    protected $fillable = [
    'title',
    'description',
    'priority',
    'status',
    'category_id',
    'user_id',
    'technician_id',

    // SLA fields
    'due_date',
    'resolved_at',
    'sla_breached',
];

    /**
     * User who created the ticket
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Assigned technician
     */
    public function technician(): BelongsTo
    {
        return $this->belongsTo(User::class, 'technician_id');
    }

    /**
     * Ticket category
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Ticket comments
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Ticket attachments
     */
    public function attachments(): HasMany
    {
        return $this->hasMany(Attachment::class);
    }

   

public function activities()
{
    return $this->hasMany(ActivityLog::class)
                ->latest();
}
}
