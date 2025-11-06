<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketServiceUser extends Model
{
    use HasFactory;

    protected $table = 'ticket_service_user';

    protected $fillable = [
        'service_id',
        'user_id',
    ];

    public function service()
    {
        return $this->belongsTo(TicketService::class, 'service_id');
    }

    public function SiteUser()
    {
        return $this->belongsTo(SiteUser::class, 'user_id');
    }
}
