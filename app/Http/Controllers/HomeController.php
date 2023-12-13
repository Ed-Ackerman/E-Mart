<?php

namespace App\Http\Controllers;

use App\Models\Admin\ContentManagement\Banner;
use App\Models\Admin\ProductManagement\Category;
use App\Models\Admin\ProductManagement\Product;
use App\Models\Admin\ProductManagement\SubCategory;
use App\Models\Admin\ProductManagement\SubSubCategory;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }   
   
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function client_index()
    {
        // Cosmetics
        $limitedCategory = Category::where('name', 'Limited-Time Offers')->first();
        $limitedProducts = Product::whereHas('categories', function ($query) {
            $query->where('name', 'Limited-Time Offers');
        })->latest()->take(6)->get();
        // Black Friday
        $blackCategory = Category::where('name', 'black friday')->first();
        $blackProducts = Product::whereHas('categories', function ($query) {
            $query->where('name', 'black friday');
        })->latest()->take(6)->get();
        // Flash Section
        $flashCategory = Category::where('name', 'flash sales')->first();
        $flashProducts = Product::whereHas('categories', function ($query) {
            $query->where('name', 'flash sales');
        })->latest()->take(6)->get();
        // Special Section
        $specialCategory = Category::where('name', 'Seasonal Specials')->first();
        $specialProducts = Product::whereHas('categories', function ($query) {
            $query->where('name', 'Seasonal Specials');
        })->latest()->take(6)->get();
        // Package Section
        $packageCategory = Category::where('name', 'Packages')->first();
        $packageProducts = Product::whereHas('categories', function ($query) {
            $query->where('name', 'Packages');
        })->latest()->take(6)->get();
    
        //products 
        $products = Product::all();
        // banners
        $banners = Banner::all();
        // categories
        $first18Categories = Category::latest()->take(18)->get();
        $categories = Category::latest();
        $subCategories = SubCategory::latest();
        $subsubCategories = SubSubCategory::latest();
        return view('client.index', 
        compact(
            // Limited
            'limitedCategory',
            'limitedProducts',
            // Special
            'specialCategory',
            'specialProducts',
            // Package
            'packageCategory',
            'packageProducts',
            // Black Friday
            'blackCategory',
            'blackProducts',
            // Flash Sales
            'flashCategory',
            'flashProducts',
            // Product
            'products',
            // banners
            'banners',
            // categories
            'first18Categories',
            'categories', 
            'subCategories', 
            'subsubCategories',
        ));
    }

}
