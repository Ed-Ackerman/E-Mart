<?php

namespace App\Models\Admin\InventoryManagement;

use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\ProductManagement\Category;
use App\Models\Admin\ProductManagement\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier extends Model
{
    use HasFactory;
    
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_supplier', 'supplier_id', 'product_id');
    }


    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_supplier', 'supplier_id', 'category_id');
    }
    
 
}
