<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class AppUser extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $table = 'app_user';

    protected $fillable = [
        'user',
        'email',
        'password',
        'title',
        'role_id',
        'panel',
        'status',
        'contact_number',
        'gender',
        'country',
        'dob',
        'address',
        'region',
        'city',
        'zip',
        'is_enable_chat',
        'add_date',
        'img_url',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // protected $casts = [
    //     'dob' => 'date',
    //     'is_enable_chat' => 'boolean',
    //     'add_date' => 'datetime',
    // ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }


    // Check roles easily
    public function isAdmin()
    {
        return $this->panel === 'A';
    }

    public function isAgent()
    {
        return $this->$this->panel === 'S';
    }

    // public function isAgent()
    // {
    //     return $this->role_id === 3;
    // }



    public function ticketReplies()
    {
        return $this->hasMany(TicketReply::class, 'app_user_id');
    }
    public function getFullNameAttribute(): string
    {
        return trim($this->title . ' ' . $this->user);
    }
    public function assignedTickets()
    {
        return $this->hasMany(\App\Models\Ticket::class, 'assigned_to');
    }
}
