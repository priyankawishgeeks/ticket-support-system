<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpiredSubscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'subscription_id',
        'plan_id',
        'plan_title',
        'plan_slug',
        'currency',
        'amount',
        'started_at',
        'expires_at',
        'cancelled_at',
        'expired_at',
        'renewal_attempted_at',
        'renewal_type',
        'renewal_attempted',
        'renewal_successful',
        'retry_count',
        'max_retries',
        'next_retry_at',
        'payment_method',
        'payment_reference',
        'invoice_number',
        'last_payment_amount',
        'last_payment_date',
        'last_payment_status',
        'status',
        'expiry_reason',
        'admin_notes',
        'meta',
        'gateway_response',
        'notified_user',
        'notified_at',
    ];

    protected $casts = [
        'meta' => 'array',
        'gateway_response' => 'array',
        'renewal_attempted' => 'boolean',
        'renewal_successful' => 'boolean',
        'notified_user' => 'boolean',
        'started_at' => 'datetime',
        'expires_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'expired_at' => 'datetime',
        'renewal_attempted_at' => 'datetime',
        'last_payment_date' => 'datetime',
        'next_retry_at' => 'datetime',
        'notified_at' => 'datetime',
    ];

    // 🔗 Relationships
    public function user()
    {
        return $this->belongsTo(SiteUser::class);
    }

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
