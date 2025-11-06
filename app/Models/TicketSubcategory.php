<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketSubcategory extends Model
{
    use HasFactory;

    protected $fillable = ['main_category_id', 'name', 'is_active'];

    public function mainCategory()
    {
        return $this->belongsTo(TicketMainCategory::class, 'main_category_id');
    }
    public function services()
{
    return $this->hasMany(TicketService::class, 'subcat_id');
}

}
