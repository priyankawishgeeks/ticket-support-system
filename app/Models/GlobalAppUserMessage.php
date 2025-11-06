<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GlobalAppUserMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'ticket_id',
        'message',
        'is_read',
        'read_at',
        'status',
    ];

    public function sender()
    {
        return $this->belongsTo(AppUser::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(AppUser::class, 'receiver_id');
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }
}
