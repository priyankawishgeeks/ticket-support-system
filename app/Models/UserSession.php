<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSession extends Model
{
    protected $table = 'user_sessions';

    protected $fillable = [
        'user_id',
        'login_at',
        'logout_at',
        'impersonated_by',
    ];

    protected $dates = [
        'login_at',
        'logout_at',
        'created_at',
        'updated_at',
    ];

    /**
     * The user who owns this session
     */
    public function user()
    {
        return $this->belongsTo(SiteUser::class, 'user_id');
    }

    /**
     * The admin who impersonated this user (if any)
     */
    public function impersonator()
    {
        return $this->belongsTo(SiteUser::class, 'impersonated_by');
    }
}
