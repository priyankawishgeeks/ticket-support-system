<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'plan_id',
        'status',
        'amount',
        'currency',
        'payment_method',
        'payment_reference',
        'started_at',
        'expires_at',
        'trial_ends_at',
        'cancelled_at',
        'renewed_at',
        'renewal_type',
        'notes',
        'meta',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'expires_at' => 'datetime',
        'trial_ends_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'renewed_at' => 'datetime',
        'meta' => 'array',
    ];

    /**
     * Relationships
     */
   public function siteUser()
{
    return $this->belongsTo(SiteUser::class, 'user_id');
}


    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    /**
     * Helpers
     */
    public function isActive(): bool
    {
        return $this->status === 'active' && $this->expires_at?->isFuture();
    }

    public function isTrial(): bool
    {
        return $this->status === 'trial' && $this->trial_ends_at?->isFuture();
    }

    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    public function startTrial(): void
    {
        if ($this->plan && $this->plan->trial_days > 0) {
            $this->status = 'trial';
            $this->started_at = now();
            $this->trial_ends_at = now()->addDays($this->plan->trial_days);
            $this->expires_at = $this->trial_ends_at;
            $this->save();
        }
    }
}
