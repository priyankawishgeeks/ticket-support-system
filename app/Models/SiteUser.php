<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class SiteUser extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable, SoftDeletes;

    protected $table = 'site_user';

    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'email',
        'password',
        'email_verified_at',
        'gender',
        'dob',
        'phone',
        'address',
        'city',
        'region',
        'zip',
        'country',
        'profile_url',
        'photo_url',
        'bio',
        'website',
        'login_type',
        'social_id',
        'social_data',
        'status',
        'user_type',
        'timezone',
        'last_login_at',
        'last_ip',
        'device_info',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
        'two_factor_recovery_codes',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'social_data' => 'array',
        'last_login_at' => 'datetime',
        'dob' => 'date',
    ];
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'user_id');
    }
public function plan()
{
    return $this->belongsTo(Plan::class);
}

    public function activeSubscription()
    {
        return $this->hasOne(Subscription::class, 'user_id')
            ->where('status', 'active')
            ->where(function ($query) {
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            });
    }

    public function currentPlan()
    {
        // Access plan through active subscription
        return $this->hasOneThrough(
            Plan::class,          // final model
            Subscription::class,  // intermediate model
            'user_id',            // FK on subscriptions table
            'id',                 // FK on plans table
            'id',                 // local key on site_users
            'plan_id'             // local key on subscriptions
        )->where('subscriptions.status', 'active');
    }

    /**
     * Accessor: Get full name dynamically
     */
    public function ticketReplies()
    {
        return $this->hasMany(TicketReply::class, 'site_user_id');
    }
    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->last_name}");
    }
    public function tickets()
    {
        return $this->hasMany(\App\Models\Ticket::class, 'ticket_user');
    }
}
