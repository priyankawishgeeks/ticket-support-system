<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TicketReply extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ticket_replies';

    protected $fillable = [
        'ticket_id',
        'ticket_track_id',
        'app_user_id',
        'site_user_id',
        'reply_body',
        'attachments',
        'reply_type',
        'parent_reply_id',
        'is_read',
        'read_at',
        'created_by_type',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'attachments' => 'array',
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    // Each reply belongs to one ticket
    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }

    // Reply may be written by an internal admin/staff user
    public function appUser()
    {
        return $this->belongsTo(AppUser::class, 'app_user_id');
    }

    // Reply may be written by a site (client) user
    public function siteUser()
    {
        return $this->belongsTo(SiteUser::class, 'site_user_id');
    }

    // Parent reply (for threaded conversations)
    public function parent()
    {
        return $this->belongsTo(TicketReply::class, 'parent_reply_id');
    }

    // Child replies (threaded)
    public function children()
    {
        return $this->hasMany(TicketReply::class, 'parent_reply_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors / Helpers
    |--------------------------------------------------------------------------
    */

    // Check if the reply was sent by staff
    public function isFromAdmin(): bool
    {
        return $this->created_by_type === 'app_user';
    }

    // Check if the reply was sent by client
    public function isFromClient(): bool
    {
        return $this->created_by_type === 'site_user';
    }
}
