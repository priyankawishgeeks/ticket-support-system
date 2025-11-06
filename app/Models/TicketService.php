<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketService extends Model
{
    use HasFactory;

    protected $fillable = [
        'subcategory_id',
        'name',
        'is_active',
    ];
    protected $casts = [
        'is_active' => 'boolean',
    ];
    /**
     * Relationship: Service belongs to a subcategory
     */

    

    public function subcategory()
    {
        return $this->belongsTo(TicketSubcategory::class, 'subcategory_id');
    }

    public function users()
    {
        return $this->belongsToMany(SiteUser::class, 'ticket_service_user', 'service_id', 'user_id');
    }
}
