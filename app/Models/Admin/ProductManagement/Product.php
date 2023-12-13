<?php

namespace App\Models\Admin\ProductManagement;

use App\Models\Admin\InventoryManagement\Supplier as InventoryManagementSupplier;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\ProductManagement\Category;
use App\Models\Admin\InventoryManagement\Supplier;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];
    
    public function suppliers()
    {
        return $this->belongsToMany(Supplier::class, 'product_supplier', 'product_id', 'supplier_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_category', 'product_id', 'category_id');
    }

    public function subcategories()
    {
        return $this->belongsToMany(Subcategory::class, 'product_subcategory', 'product_id', 'subcategory_id');
    }

    public function subsubcategories()
    {
        return $this->belongsToMany(Subsubcategory::class, 'product_subsubcategory', 'product_id', 'subsubcategory_id');
    }
}
