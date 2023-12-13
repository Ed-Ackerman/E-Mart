<?php

namespace App\Models\Admin\ProductManagement;

use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\ProductManagement\Category;
use App\Models\Admin\ProductManagement\SubSubCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SubCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_subcategory', 'subcategory_id', 'category_id');
    }

    public function subsubcategories()
    {
        return $this->belongsToMany(SubSubCategory::class, 'subcategory_subsubcategory', 'subcategory_id', 'subsubcategory_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_subcategory', 'subcategory_id', 'product_id');
    }
}