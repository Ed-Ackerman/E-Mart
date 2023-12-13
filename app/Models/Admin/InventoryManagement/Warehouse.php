<?php

namespace App\Models\Admin\InventoryManagement;

use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\ProductManagement\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Warehouse extends Model
{
    use HasFactory;
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_warehouse', 'warehouse_id', 'category_id');
    }    
}
