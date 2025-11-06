<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'border_color',
        'title_color',
        'background_color',
        'badge_label',
        'price',
        'currency',
        'duration_days',
        'billing_cycle',
        'features',
        'trial_days',
        'max_users',
        'max_storage_gb',
        'max_projects',
        'renewal_type',
        'is_featured',
        'is_active',
    ];

    protected $casts = [
        'features' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Relationships
     */
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    /**
     * Accessor for displaying formatted price
     */
    public function getFormattedPriceAttribute()
    {
        return $this->currency . ' ' . number_format($this->price, 2);
    }

    /**
     * Determine if plan has trial period
     */
    public function hasTrial(): bool
    {
        return $this->trial_days > 0;
    }
}
