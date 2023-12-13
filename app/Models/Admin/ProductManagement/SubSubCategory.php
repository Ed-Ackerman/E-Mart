<?php

namespace App\Models\Admin\ProductManagement;

use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\ProductManagement\Product;
use App\Models\Admin\ProductManagement\Category;
use App\Models\Admin\ProductManagement\SubCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SubSubCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    public function subcategories()
    {
        return $this->belongsToMany(SubCategory::class, 'subcategory_subsubcategory', 'subsubcategory_id', 'subcategory_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_subcategory', 'subcategory_id', 'category_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_subsubcategory', 'subsubcategory_id', 'product_id');
    }
}