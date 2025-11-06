<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_track_id',
        'cat_id',
        'services_cat_id',
        'services',
        'service_url',
        'title',
        'ticket_body',
        'ticket_user',
        'user_type',
        'status',
        'priority',
        'assigned_to',
        'assigned_date',
        'is_public',
        'is_open_using_email',
        'is_paid_ticket',
        'is_user_seen_last_reply',
        'reply_counter',
        'ticket_rating',
        'opened_time',
        're_open_time',
        're_open_by',
        're_open_by_type',
        'last_replied_by',
        'last_replied_by_type',
        'last_reply_time',
    ];

    // ----------------------------------------
    // 🔗 Relationships
    // ----------------------------------------

    /** Category */
    public function category()
    {
        return $this->belongsTo(TicketMainCategory::class, 'cat_id');
    }

    /** Subcategory */
    public function subcategory()
    {
        return $this->belongsTo(TicketSubcategory::class, 'services_cat_id');
    }

    /** Service */
    public function service()
    {
        return $this->belongsTo(TicketService::class, 'services');
    }

    /** Ticket owner (user who created it) */
    public function siteUser()
    {
        return $this->belongsTo(SiteUser::class, 'ticket_user');
    }

    /** Assigned admin/staff */
    public function assignee()
    {
        return $this->belongsTo(AppUser::class, 'assigned_to');
    }
public function assignedUser()
{
    return $this->belongsTo(\App\Models\AppUser::class, 'assigned_to');
}

    /** Attachments (multiple files per ticket) */
    public function attachments()
    {
        return $this->hasMany(TicketAttachment::class);
    }

    // ----------------------------------------
    // 🧠 Accessors & Helpers
    // ----------------------------------------

    /** Generate automatic ticket tracking ID */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($ticket) {
            if (empty($ticket->ticket_track_id)) {
                $ticket->ticket_track_id = 'TCK-' . strtoupper(uniqid());
            }

            if (empty($ticket->opened_time)) {
                $ticket->opened_time = now();
            }
        });
    }
    public function adminNotes()
    {
        return $this->hasMany(AdminNote::class, 'ticket_id');
    }
    // app/Models/Ticket.php

    public function replies()
    {
        return $this->hasMany(TicketReply::class, 'ticket_id')->latest();
    }

    /** Get formatted status */
    public function getStatusLabelAttribute(): string
    {
        return ucfirst($this->status ?? 'New');
    }

    /** Check if the ticket is closed */
    public function getIsClosedAttribute(): bool
    {
        return strtolower($this->status) === 'closed';
    }
}
