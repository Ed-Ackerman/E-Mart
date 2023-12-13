<?php

namespace App\Http\Controllers\Client\Custom;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Client\Custom\Custom;

class CustomOrderController extends Controller
{
    //
    public function customorder()
    {
        return view('client.custom.customorder');
    }

    public function placecustomorder(Request $request)
    {
        $request->validate([
            // Receiver's info validation
            'name' => 'required|string',
            'city' => 'required|string',
            'address' => 'required|string',
            'tel_1' => 'required|string',
            'tel_2' => 'required|string',
    
            // Shipping fee validation
            'shipping_fee' => 'required|string',
    
            // Payment method validation
            'payment_method' => 'required|string',
    
            // Custom order items validation (assuming you allow up to 5 items)
            'custom_name.*' => 'nullable|string',
            'custom_qty.*' => 'nullable|string|min:1',
            'custom_price.*' => 'nullable|string|min:1',
            'custom_total.*' => 'nullable|string|min:1',
            'custom_description.*' => 'nullable|string',
            'custom_img.*' => 'image|mimes:jpeg,png,jpg,gif,svg',
        ]);
    
        // Process the custom order items
        $orderItemData = collect($request->input('custom_name'))->map(function ($name, $index) use ($request) {
            // Get the image path for the item
            $imagePath = null;

            if ($request->hasFile("custom_img.$index")) {
                $image = $request->file("custom_img.$index");
                $uniqueFilename = time() . '-' . $image->getClientOriginalName();
                $image->storeAs('images/admin/custom', $uniqueFilename, 'public');
                $imagePath = $uniqueFilename;
            }

            return [
                'custom_name' => $name,
                'custom_qty' => $request->input("custom_qty.$index"),
                'custom_price' => $request->input("custom_price.$index"),
                'custom_total' => $request->input("custom_total.$index"),
                'custom_description' => $request->input("custom_description.$index"),
                'custom_img' => $imagePath,
            ];
        })->toArray();

        if (empty($orderItemData)) {
            return redirect()->back()->with('error', 'Invalid Entries');
        }

    
        $custom = new Custom();
    
        // Create a new Product instance
        $custom->order_status = $request->input('order_status');
        $custom->name = $request->input('name');
        $custom->city = $request->input('city');
        $custom->address = $request->input('address');
        $custom->tel_1 = $request->input('tel_1');
        $custom->tel_2 = $request->input('tel_2');
        $custom->shipping_fee = $request->input('shipping_fee');
        $custom->payment_method = $request->input('payment_method');
        $custom->custom_order = json_encode($orderItemData);
    
        $custom->save();
    
        // Redirect or return a response as needed
        return redirect()->back()->with('success', 'Custom orders have been placed.');
    }
    
    
}



