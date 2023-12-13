<?php

namespace App\Http\Controllers\Client\Categories;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\ContentManagement\Banner;
use App\Models\Admin\ProductManagement\Product;
use App\Models\Admin\ProductManagement\Category;
use App\Models\Admin\ProductManagement\SubCategory;
use App\Models\Admin\ProductManagement\SubSubCategory;
use Mockery\Matcher\Subset;

class CategoriesController extends Controller
{
    public function categories($id)
    {
        $banners = Banner::all();

        // Fetch the category and its sub-categories from your database
        $category = Category::with('subcategories')->find($id);
        if (!$category) {
            return redirect()->back()->with('error', 'Sorry Page not yet available...');
        }
        $products = $category->products()->paginate(60);
        // Get the latest 6 sub-categories for the selected category
        $latestSubCategories = $category->subcategories()->latest()->take(6)->get();
        $SubCategories = $category->subcategories()->latest()->take(3)->get();

        return view('client.categories.categories', compact(
            'banners', 
            'category', 
            'products', 
            'SubCategories', 
            'latestSubCategories'
        ));
    }

    public function subcategories($id)
    {
        $banners = Banner::all();
        
        $subCategory = SubCategory::with('categories')->find($id);

        $category = $subCategory->categories->first();     
        if (!$subCategory) {
            return redirect()->back()->with('error', 'Sorry Page not yet available...');
        }
        // Fetch the products for the selected sub-category
        $products = $subCategory->products()->paginate(60);
    
        // Get the latest 6 sub-sub-categories for the selected sub-category (optional)
        $latestSubsubCategories = $subCategory->subsubcategories()->latest()->take(6)->get();
        $SubsubCategories = $subCategory->subsubcategories()->latest()-> take(3)->get();
        
        return view('client.categories.subcategories', compact(
            'banners', 
            'subCategory', 
            'products', 
            'category', 
            'SubsubCategories', 
            'latestSubsubCategories'
        ));
    }
    

    public function subsubcategories($id)
    {
        $banners = Banner::all();
        $subcategories = SubCategory::all();
        
        $subsubCategory = SubSubCategory::with('categories')->find($id);

        if ($subsubCategory) {
            $subcategory = $subsubCategory->subcategories->first();

            if ($subcategory) {
                $category = $subcategory->categories->first();
            }
        }
        if (!$subsubCategory) {
            return redirect()->back()->with('error', 'Sorry Page not yet available...');
        }       
        // Fetch the products for the selected sub-category
        $products = $subsubCategory->products()->paginate(60);
    
        // Get the latest 6 sub-sub-categories for the selected sub-category (optional)
        $latestCategories = $subsubCategory->categories()->latest()->take(6)->get();
        $SubsubCategories = $subsubCategory->subcategories()->latest()->take(3)->get();
        
        return view('client.categories.subsubcategories', compact(
            'banners', 
            'subsubCategory', 
            'products', 
            'category', 
            'subcategory', 
            'subcategories', 
            'SubsubCategories', 
            'latestCategories'
        ));
    }
    
    
}
