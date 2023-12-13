<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Admin\ContentManagement\Banner;
use App\Models\Admin\ProductManagement\Product;
use App\Models\Admin\ProductManagement\Category;
use App\Models\Admin\ProductManagement\SubCategory;
use App\Models\Admin\ProductManagement\SubSubCategory;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('layouts.partials.navbar', function ($view) {
            $categories = Category::all();
            $subcategories = SubCategory::all();
            $subsubcategories = SubSubCategory::all();
            $banners = Banner::all();
            
            // Retrieve the product based on the 'id' route parameter
            $id = request()->route('id');
            $product = Product::find($id);
            
            // Pass data to the view
            $view->with('categories', $categories)
                 ->with('subcategories', $subcategories)
                 ->with('subsubcategories', $subsubcategories)
                 ->with('banners', $banners)
                 ->with('product', $product); // Pass the product to the view
        });
    }
    
}
