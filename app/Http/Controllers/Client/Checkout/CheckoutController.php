<?php

namespace App\Http\Controllers\Client\Checkout;

use App\Models\User;
use Illuminate\Http\Request;
use App\Mail\OrderPlacedUser;
use App\Mail\OrderPlacedAdmin;
use App\Models\Client\Product\Cart;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Models\Client\Checkout\Checkout;
use App\Models\Admin\ProductManagement\Product;

class CheckoutController extends Controller
{
    //
    public function checkout()
    {
        return view('client.checkout.checkout');
    }

    public function checkout_details(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'tel_1' => 'required|string',
            'tel_2' => 'required|string',
            'city' => 'required|string',
            'shipping_fee' => 'required|string',
            'address' => 'required|string',
            'payment_method' => 'required|string',
            'order_status' => 'required|string',
        ]);
    
        $user = auth()->user();
        $isGuest = !$user; // Determine if it's a guest checkout
    
        // Initialize cart items and user ID
        $cartItems = [];
        $userId = null;
    
        if ($isGuest) {
            // For guests, retrieve cart items from the session
            $cartItems = session('cart', []);
        } else {
            // For authenticated users
            $cartItems = $user->cart;
            $userId = $user->id;
        }
    
        $cartArray = [];
    
        // Process cart items for both authenticated users and guests
        foreach ($cartItems as $cartItem) {
            if ($isGuest) {
                if (is_array($cartItem) && array_key_exists('product_id', $cartItem) && array_key_exists('quantity', $cartItem)) {
                    $cartArray[] = [
                        'product_id' => $cartItem['product_id'],
                        'quantity' => $cartItem['quantity'],
                    ];
                } else {
                    return redirect()->back()->with('error', 'Error: Invalid cart item structure');
                }
            } else {
                $cartArray[] = [
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                ];
            }
        }
    
        // Create a new checkout record
        $checkout = Checkout::create([
            'user_id' => $userId,
            'name' => $request->input('name'),
            'tel_1' => $request->input('tel_1'),
            'tel_2' => $request->input('tel_2'),
            'city' => $request->input('city'),
            'shipping_fee' => $request->input('shipping_fee'),
            'address' => $request->input('address'),
            'payment_method' => $request->input('payment_method'),
            'order_status' => $request->input('order_status'),
            'cart_items' => json_encode($cartArray),
            'is_guest' => $isGuest,
        ]);

          // Send email to the user only if they are authenticated
        if (!$isGuest) {
            Mail::send(new OrderPlacedUser($checkout));
        }

        // Handle clearing the guest cart or any other guest-specific actions
        if ($isGuest) {
            $request->session()->forget('cart');
        } else {
            Cart::where('user_id', $userId)->delete();
        }   
        
        // Send email to the admin
        Mail::send(new OrderPlacedAdmin($checkout));
    

        return redirect()->back()->with('success', 'Order has been placed.');
    }
    
}
