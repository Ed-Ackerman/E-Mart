<?php

namespace App\Http\Controllers\Client\Product;

use Illuminate\Http\Request;
use App\Models\Client\Product\Cart;
use App\Http\Controllers\Controller;
use App\Models\Client\Product\Wishlist;
use App\Models\Admin\ContentManagement\Banner;
use App\Models\Admin\ProductManagement\Product;
use App\Models\Admin\ProductManagement\Category;
use App\Models\Admin\ProductManagement\SubCategory;
use App\Models\Admin\ProductManagement\SubSubCategory;

class ProductController extends Controller
{
    //

    
    public function search_for_product(Request $request)
    {
        $search = $request->input('search');
        $banners = Banner::all();
        
        // Load the products based on the search query
        $products = Product::where('name', 'like', "%$search%")
            ->orWhere('name', 'like', "%$search%")
            ->paginate(60);
        
            $categories = Category::whereHas('products', function ($query) use ($search) {
                $query->where('name', 'like', "%$search%")
                    ->orWhere('description', 'like', "%$search%");
            })->latest()->get();
        
            $subCategories = SubCategory::whereHas('products', function ($query) use ($search) {
                $query->where('name', 'like', "%$search%")
                    ->orWhere('description', 'like', "%$search%");
            })->latest()->get();
        
            $subsubCategories = SubSubCategory::whereHas('products', function ($query) use ($search) {
                $query->where('name', 'like', "%$search%")
                    ->orWhere('description', 'like', "%$search%");
            })->latest()->get();
        
        
        // dd($categories, $subCategories, $subsubCategories);

        return view('client.product.search', compact(
            'search',
            'banners',
            'categories',
            'subCategories',
            'subsubCategories',
            'products'
        ));
    }
    
    public function view_product($id)
    {
        $product = Product::with('subcategories')->find($id);

        if (!$product) {
            return redirect()->back()->with('error', 'Product not found');
        }
        
        // Load the suppliers for this product.
        $suppliers = $product->suppliers;

        // Fetch the 3 latest subcategories associated with the product
        $SubCategories = SubCategory::whereIn('id', $product->subcategories->pluck('id'))->latest()->take(3)->get();

        return view('client.product.product', compact('product', 'suppliers', 'SubCategories'));
    }

    public function cart(Request $request)
    {
        $user = auth()->user();
        $sessionCart = $request->session()->get('cart', []);
    
        if ($user) {
            $databaseCart = Cart::where('user_id', $user->id)->get();
        } else {
            $databaseCart = collect([]);
        }
    
        // Convert the sessionCart array to a collection
        $sessionCartCollection = collect($sessionCart);
    
        // Concatenate the collections
        $cartItems = $sessionCartCollection->concat($databaseCart);
    
        return view('client.product.cart', ['cartItems' => $cartItems]);
    }
        
    public function addToCartOrWishlist(Request $request)
    {
        $productId = $request->input('productId');
        $quantity = $request->input('quantity');
        $action = $request->input('action');
    
        if (auth()->check()) {
            // For authenticated users
            $user = auth()->user();
    
            if ($action === 'cart') {
                $cartItem = Cart::where('user_id', $user->id)
                    ->where('product_id', $productId)
                    ->first();
    
                if ($cartItem) {
                    $cartItem->quantity += $quantity;
                    $cartItem->save();
                } else {
                    Cart::create([
                        'user_id' => $user->id,
                        'product_id' => $productId,
                        'quantity' => $quantity,
                    ]);
                }
    
               // Remove the item from the wishlist
               Wishlist::where('user_id', $user->id)
               ->where('product_id', $productId)
               ->delete();

                // $request->session()->forget("wishlist.{$productId}");
                return redirect()->back()->with('success', 'Product Added to Cart Successfully');

            } 
            elseif ($action === 'wishlist') {
                $wishlistItem = Wishlist::where('user_id', $user->id)
                    ->where('product_id', $productId)
                    ->first();
    
                if ($wishlistItem) {
                    return redirect()->back()->with('info', 'Product is already in your wishlist.');
                } else {
                    Wishlist::create([
                        'user_id' => $user->id,
                        'product_id' => $productId,
                        'quantity' => $quantity,
                    ]);
                    return redirect()->back()->with('success', 'Product Added to Wishlist Successfully');
                }
            } 
            else {
                return redirect()->back()->with('error', 'Invalid action specified.');
            }
        }  
        else {
            // For guests, store cart in the session
            $cart = $request->session()->get('cart', []);
    
            if ($action === 'cart') {
                $productExistsInCart = false;
    
                foreach ($cart as &$item) {
                    if (isset($item['product_id']) && isset($item['quantity']) && $item['product_id'] == $productId) {
                        $item['quantity'] += $quantity;
                        $productExistsInCart = true;
                        break;
                    }
                }
    
                if (!$productExistsInCart) {
                    $cart[] = [
                        'product_id' => $productId,
                        'quantity' => $quantity,
                    ];
                }
    
                $request->session()->put('cart', $cart);
                return redirect()->back()->with('success', 'Product Added to Cart Successfully');
            } 
            else {
                return redirect()->back()->with('error', 'You Must Login to Access This Feature.');
            }
        }
    
    }

    public function removeFromCart($id)
    {
        $user = auth()->user();
        $cart = session('cart', []);
    
        // Remove the item from the session cart
        $cart = array_filter($cart, function ($item) use ($id) {
            return $item['product_id'] != $id;
        });
    
        session(['cart' => $cart]);
    
        // If a user is authenticated, remove the item from the database cart
        if ($user) {
            Cart::where('user_id', $user->id)->where('product_id', $id)->delete();
        }
    
        return redirect()->back()->with('error', 'Product Removed From Cart');
    }
    

    /**
     *  Wish
     *  */ 
    public function wishlist(Request $request)
    {
        $user = auth()->user();
        $sessionWishlist = $request->session()->get('wishlist', []);
    
        if ($user) {
            $databaseWishlist = Wishlist::where('user_id', $user->id)->get();
        } else {
            $databaseWishlist = collect([]);
        }
    
        // Convert the sessionWishlist array to a collection
        $sessionWishlistCollection = collect($sessionWishlist);
    
        // Concatenate the collections
        $wishlistItems = $sessionWishlistCollection->concat($databaseWishlist);
    
        return view('client.product.wichlist', ['wishlistItems' => $wishlistItems]);
    }
    

    public function removeFromWish($id)
    {
        $user = auth()->user();
        $wishlist = session('wishlist', []);
    
        // Remove the item from the session wishlist
        $wishlist = array_filter($wishlist, function ($item) use ($id) {
            return $item['product_id'] != $id;
        });
    
        session(['wishlist' => $wishlist]);
    
        // If a user is authenticated, remove the item from the database wishlist
        if ($user) {
            Wishlist::where('user_id', $user->id)->where('product_id', $id)->delete();
        }
    
        return redirect()->back()->with('error', 'Product Removed From Wishist');
    }
    

}
