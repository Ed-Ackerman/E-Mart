<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use App\Models\Client\Help\Inquiry;
use App\Models\Client\Product\Cart;
use App\Models\Client\Product\Wishlist;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use App\Models\Client\Checkout\Checkout;
use App\Models\Admin\ProductManagement\Product;
use App\Models\Client\Custom\Custom;

class ProductsCountViewComposerServiceProvider extends ServiceProvider
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
        view()->composer('*', function ($view) {
            $productsBelowThresholdCount = Product::whereRaw('CAST(quantity AS SIGNED) <= CAST(alert_threshold AS SIGNED)')->count();
            $view->with('productsBelowThresholdCount', $productsBelowThresholdCount);
        });
        view()->composer('*', function ($view) {
            $newInquiryCount = Session::has('new_inquiry') ? 1 : 0;
            $view->with('newInquiryCount', $newInquiryCount);
        });
        view()->composer('*', function ($view) {
            $newOrderCount = Checkout::where('order_status', 'pending')->count();
            $view->with('newOrderCount', $newOrderCount);
        });
        view()->composer('*', function ($view) {
            $newCustomOrderCount = Custom::where('order_status', 'pending')->count();
            $view->with('newCustomOrderCount', $newCustomOrderCount);
        });
        view()->composer('*', function ($view) {
            $cartCount = 0;
            $wishCount = 0;
        
            if (auth()->check()) {
                $user = auth()->user();
        
                // Count the number of cart items for the logged-in user
                $cartCount = Cart::where('user_id', $user->id)->count();
        
                // Count the number of wishlist items for the logged-in user
                $wishCount = Wishlist::where('user_id', $user->id)->count();
            } elseif (Session::has('cart')) {
                // If a cart session exists for guests, count the cart items in the session
                $cartCount = count(Session::get('cart'));
            }
        
            $view->with('cartCount', $cartCount);
            $view->with('wishCount', $wishCount);
        });
        
        
    }
}
