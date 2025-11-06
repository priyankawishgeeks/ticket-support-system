<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CannedMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'created_by',
        'category_id',
        'subcategory_id',
        'service_id',
        'title',
        'subject',
        'body',
        'type',
        'is_global',
        'status',
    ];

    /**
     * 🔹 The user (AppUser) who created this canned message
     */
    public function createdBy()
    {
        return $this->belongsTo(AppUser::class, 'created_by');
    }

    /**
     * 🔹 The main category this canned message belongs to
     */
    public function category()
    {
        return $this->belongsTo(TicketMainCategory::class, 'category_id');
    }

    /**
     * 🔹 The subcategory this canned message belongs to
     */
    public function subcategory()
    {
        return $this->belongsTo(TicketSubcategory::class, 'subcategory_id');
    }

    /**
     * 🔹 The service this canned message is related to
     */
    public function service()
    {
        return $this->belongsTo(TicketService::class, 'service_id');
    }

    /**
     * 🔹 Scope: Only active messages
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * 🔹 Accessor for short preview of the message body
     */
    public function getPreviewAttribute()
    {
        return str()->limit(strip_tags($this->body), 80);
    }
}
