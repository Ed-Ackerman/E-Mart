<?php

namespace App\Http\Controllers\Admin\OderManagement;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Client\Custom\Custom;
use App\Models\Client\Returns\Returns;
use App\Models\Client\Checkout\Checkout;
use App\Models\Admin\ProductManagement\Product;

class OderManagementController extends Controller
{
     /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function proccessing()
    {
        $orders = Checkout::latest()->paginate(10);
        return view('admin.odermanagement.processing', compact('orders'));
    }

  
    public function searchOrder(Request $request)
    {
        $query = $request->input('order-search');

        $orders = Checkout::where('order_status', 'like', "%$query%")
            ->paginate(10); // Adjust the pagination limit as needed

        return view('admin.odermanagement.processing', compact('orders'));
    }
    
    public function order_show($id)
    {
        // Get the order based on the provided $orderId
        $order = Checkout::find($id);
        
        if ($order) {
            // Get the user associated with this order
            $user = $order->user;
            
            return view('admin.odermanagement.orderresources.show', compact('user', 'order'));
        } else {
            return redirect()->back()->with('error', 'Order not found.');
        }
    }
    public function updateOrderStatus(Request $request, $id)
    {
        $order = Checkout::find($id);
    
        if (!$order) {
            return redirect()->route('proccessing')->with('error', 'Order not found.');
        }
    
        $newStatus = $request->input('order_status');
        $order->update(['order_status' => $newStatus]); // Update the order status
    
         // Check if the order status is fulfilled
        if ($newStatus === 'fulfilled') {
            // Decode the JSON string to an array
            $cartArray = json_decode($order->cart_items, true);

            // Ensure that $cartArray is an array before looping
            if (is_array($cartArray)) {
                // Update product quantity only when the order is fulfilled
                foreach ($cartArray as $cartItem) {
                    $productId = $cartItem['product_id'];
                    $quantity = $cartItem['quantity'];

                    // Find the product by ID
                    $product = Product::find($productId);

                    if ($product) {
                        // Subtract the quantity from the product's current quantity
                        $product->quantity -= $quantity;

                        // Save the updated product
                        $product->save();
                    }
                }
            } else {
                // Handle the case where $cartArray is not an array
                return redirect()->back()->with('error', 'Invalid cart items structure.');
            }
        }

    
        return redirect()->back()->with('success', 'Order status updated to ' . ucfirst($newStatus) . '.');
    }
    
    
    public function order_delete($id)
    {
        $order = Checkout::find($id);

        if ($order) {
            // Delete the order
            $order->delete();
    
            return redirect()->route('proccessing')->with('success', 'Order has been deleted.');
        } else {
            return redirect()->route('proccessing')->with('error', 'Order not found or already deleted.');
        }
    }
    

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function returns()
    {
        $returns = Returns::latest()->paginate(10);
        return view('admin.odermanagement.returns', compact('returns'));
    }

    public function searchReturn(Request $request)
    {
        $query = $request->input('returns-search');

        $returns = Returns::where('return_status', 'like', "%$query%")
            ->paginate(10); // Adjust the pagination limit as needed

        return view('admin.odermanagement.returns', compact('returns'));
    }
    
    public function client_returns()
    {
        return view('client.returns.returns');
    }

    
    public function return_store(Request $request)
    {
        $data = $request->validate([
            'product_name' => 'nullable|string|max:255',
            'product_code' => 'nullable|string|max:255',
            'return_reason' => 'nullable|string|max:255',
            'name' => 'nullable|string|max:50',
            'tel_1' => 'nullable|string|max:10',
            'tel_2' => 'nullable|string|max:10',
            'city' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:100',
            'return_status' => 'nullable|string|max:100',
            'payment_method' => 'nullable|string|max:100',
            'shipping_fee' => 'nullable|string|max:100',
        ]);

        Returns::create($data);
        return redirect()->back()->with('success', 'Refund Inquiry Sent Successfully');
    }

    public function return_show($id)
    {
        // Get the order based on the provided $orderId
        $return_info = Returns::find($id);
        
        if ($return_info) {
            // Get the user associated with this return_info
            $user = $return_info->user;
            
            return view('admin.odermanagement.returnresources.show', compact('user', 'return_info'));
        } else {
            return redirect()->back()->with('error', 'Return not found.');
        }
    }

    public function updateReturnStatus(Request $request, $id)
    {
        $return_info = Returns::find($id);
    
        if ($return_info) {
            $newStatus = $request->input('return_status');
            $return_info->update(['return_status' => $newStatus]); // Update the return$return_info status
    
            return redirect()->back()->with('success', 'Return status updated to ' . ucfirst($newStatus) . '.');
        } else {
            return redirect()->route('returns')->with('error', 'Return not found.');
        }
    }
    

    public function return_delete($id)
    {
        $return_info = Returns::find($id);

        if ($return_info) {
            // Delete the order
            $return_info->delete();
    
            return redirect()->route('proccessing')->with('success', 'Return has been deleted.');
        } else {
            return redirect()->route('proccessing')->with('error', 'Return not found or already deleted.');
        }
    }


    /**
     * Custom
     */

     public function custom()
     {
         $orders = Custom::latest()->paginate(10);
         return view('admin.odermanagement.custom', compact('orders'));
     }

     public function searchCustom(Request $request)
     {
         $query = $request->input('order-search');
 
         $orders = Custom::where('order_status', 'like', "%$query%")
             ->paginate(10); // Adjust the pagination limit as needed
 
         return view('admin.odermanagement.custom', compact('orders'));
     }

     public function custom_show($id)
     {
         // Get the order based on the provided $orderId
         $order = Custom::find($id);
         
         if ($order) {
             // Get the user associated with this order
             $user = $order->user;
             
             return view('admin.odermanagement.orderresources.customshow', compact('user', 'order'));
         } else {
             return redirect()->back()->with('error', 'Order not found.');
         }
     }
 

     public function updateCustomStatus(Request $request, $id)
     {
         $order = Custom::find($id);
     
         if ($order) {
             $newStatus = $request->input('order_status');
             $order->update(['order_status' => $newStatus]); // Update the order status
     
             return redirect()->back()->with('success', 'Custom Order status updated to ' . ucfirst($newStatus) . '.');
         } else {
             return redirect()->route('custom')->with('error', 'Custom Order not found.');
         }
     }
     
     
     public function custom_delete($id)
     {
         $order = Custom::find($id);
 
         if ($order) {
             // Delete the order
             $order->delete();
     
             return redirect()->route('custom')->with('success', 'Custom Order has been deleted.');
         } else {
             return redirect()->route('custom')->with('error', 'Custom Order not found or already deleted.');
         }
     }
     
}
