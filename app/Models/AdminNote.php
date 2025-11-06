<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'client_id',
        'created_by',
        'title',
        'body',
        'note_type',
        'visibility',
        'status',
        'has_attachments',
        'ticket_track_id',
    ];

    /*
    |--------------------------------------------------------------------------
    | 🔗 Relationships
    |--------------------------------------------------------------------------
    */

    /** Ticket this note belongs to */
    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }

    /** Client (site user) this note refers to */
    public function client()
    {
        return $this->belongsTo(SiteUser::class, 'client_id');
    }

    /** Admin (app user) who created the note */
    public function creator()
    {
        return $this->belongsTo(AppUser::class, 'created_by');
    }

    /*
    |--------------------------------------------------------------------------
    | 🔍 Scopes
    |--------------------------------------------------------------------------
    */

    /** Only active notes */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /** Filter notes visible to all admins (team-wide) */
    public function scopeTeamVisible($query)
    {
        return $query->where('visibility', 'team');
    }

    /** Filter notes visible to client */
    public function scopePublicVisible($query)
    {
        return $query->where('visibility', 'public');
    }

   

    /** Get a short preview of the note */
    public function getPreviewAttribute()
    {
        return str(strip_tags($this->body))->limit(80);
    }

    /** Check if note is private */
    public function getIsPrivateAttribute()
    {
        return $this->visibility === 'private';
    }

    /** Get formatted creator name */
    public function getCreatorNameAttribute()
    {
        return $this->creator?->name ?? 'Unknown Admin';
    }
}
