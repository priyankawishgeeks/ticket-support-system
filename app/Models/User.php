<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'username', 'email', 'password', 'full_name', 'title', 
        'contact_number', 'profile_img', 'gender', 'dob',
        'address', 'city', 'region', 'zip', 'country', 'timezone',
        'status', 'is_enable_chat'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    // Many-to-Many: User -> Roles
    // public function roles()
    // {
    //     return $this->belongsToMany(Role::class, 'user_roles');
    // }

    // Check if user has a role
    public function hasRole($roleName)
    {
        return $this->roles()->where('role_name', $roleName)->exists();
    }
    public function impersonatedBy()
{
    return $this->belongsTo(User::class, 'impersonated_by');
}
public function roles()
{
    return $this->belongsToMany(Role::class, 'user_roles', 'user_id', 'role_id')
                ->withTimestamps(); // if pivot has timestamps
}
public function ticketServices()
{
    return $this->belongsToMany(TicketService::class, 'ticket_service_user', 'user_id', 'service_id');
}

}
