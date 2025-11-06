<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['role_name', 'description'];

    // Many-to-Many: Role -> Users
    // public function users()
    // {
    //     return $this->belongsToMany(User::class, 'user_roles');
    // }

    public function users()
{
    return $this->belongsToMany(SiteUser::class, 'user_roles', 'role_id', 'user_id')
                ->withTimestamps();
}

}
