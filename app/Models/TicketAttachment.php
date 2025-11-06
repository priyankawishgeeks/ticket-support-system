<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketAttachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'file_name',
        'file_path',
        'file_type',
        'uploaded_by',
    ];


    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function siteUser()
    {
        return $this->belongsTo(SiteUser::class, 'uploaded_by');
    }

  
    public function getFileUrlAttribute()
    {
        return asset('storage/' . $this->file_path);
    }

    public function getFileNameAttribute($value)
    {
        return $value ?? basename($this->file_path);
    }
}
