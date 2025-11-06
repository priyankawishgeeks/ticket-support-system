<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'subscription_id',
        'plan_id',
        'amount',
        'currency',
        'payment_method',
        'payment_reference',
        'invoice_number',
        'payment_intent_id',
        'status',
        'payment_type',
        'renewal_attempt',
        'payment_due_at',
        'paid_at',
        'refunded_at',
        'next_retry_at',
        'retry_count',
        'max_retries',
        'gateway_response',
        'meta',
        'notes',
    ];

    protected $casts = [
        'renewal_attempt' => 'boolean',
        'gateway_response' => 'array',
        'meta' => 'array',
        'payment_due_at' => 'datetime',
        'paid_at' => 'datetime',
        'refunded_at' => 'datetime',
        'next_retry_at' => 'datetime',
    ];

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

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeSuccessful($query)
    {
        return $query->where('status', 'successful');
    }
}
