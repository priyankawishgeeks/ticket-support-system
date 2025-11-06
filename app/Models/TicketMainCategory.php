<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketMainCategory extends Model
{
    use HasFactory;

      protected $fillable = [
        'name',
        'is_active',
    ];
    public function subcategories()
    {
        return $this->hasMany(TicketSubcategory::class, 'main_category_id');
    }
    
}
