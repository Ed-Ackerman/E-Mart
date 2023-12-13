<?php

namespace App\Models\Admin\ProductManagement;

use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\ProductManagement\Product;
use App\Models\Admin\ProductManagement\SubCategory;
use App\Models\Admin\ProductManagement\SubSubCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    public function suppliers()
    {
        return $this->belongsToMany(Supplier::class, 'category_supplier', 'category_id', 'supplier_id');
    }

    public function warehouses()
    {
        return $this->belongsToMany(Warehouse::class, 'category_warehouse', 'category_id', 'warehouse_id');
    }
    
    public function subcategories()
    {
        return $this->belongsToMany(SubCategory::class, 'category_subcategory', 'category_id', 'subcategory_id');
    }

    public function subsubcategories()
    {
        return $this->belongsToMany(SubSubCategory::class, 'subcategory_subsubcategory', 'subcategory_id', 'subsubcategory_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_category', 'category_id', 'product_id');
    }
}

