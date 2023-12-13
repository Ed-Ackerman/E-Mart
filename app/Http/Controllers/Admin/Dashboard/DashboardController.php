<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Client\Checkout\Checkout;
use App\Models\Admin\ProductManagement\Product;
use App\Models\Admin\ProductManagement\Category;
use App\Http\Controllers\Google\GoogleAnalyticsController;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function overview()
    {
        $totalUsers = User::count();
        $totalCategories = Category::count();
        $totalProducts = Product::count();
        $totalOrders = Checkout::count();
        $totalSales = Checkout::where('order_status', 'fulfilled')->count();
    
        $totalRevenuePerMonth = $this->calculateTotalRevenuePerMonth();
        $totalEarnings = $this->calculateTotalEarnings();
        
        // Call the cartPage method to get the cart page views
        $cartPageViews = $this->cartPage();
    
        // Ensure to pass 'cartPageViews' to the view
        return view('admin.dashboard.overview', compact(
            'totalUsers',
            'totalCategories',
            'totalProducts',
            'totalOrders',
            'totalSales',
            'totalRevenuePerMonth',
            'totalEarnings',
            'cartPageViews', 
        ));
    }
    
    public function getMonthlySalesData()
    {
        $monthlySales = [];
    
        // Replace 'your_sales_table' with your actual table name
        $checkouts = DB::table('checkouts')
            ->where('order_status', 'fulfilled')
            ->get();
    
        foreach ($checkouts as $checkout) {
            // Decode the cart_items JSON for this checkout.
            $cartItems = json_decode($checkout->cart_items, true);
    
            foreach ($cartItems as $cartItem) {
                // Ensure that 'product_id' and 'quantity' are available in the cart item.
                if (isset($cartItem['product_id']) && isset($cartItem['quantity'])) {
                    // Fetch additional details for the product based on 'product_id'.
                    $product = \App\Models\Admin\ProductManagement\Product::find($cartItem['product_id']);
    
                    if ($product) {
                        // Remove commas and convert to numeric values.
                        $sellingPrice = str_replace(',', '', $product->selling);
                        $quantity = str_replace(',', '', $cartItem['quantity']);
    
                        // Calculate the sales for this cart item based on the product details.
                        $sales = $sellingPrice * $quantity;
    
                        // Extract the month from the checkout date
                        $checkoutDate = Carbon::parse($checkout->created_at);
                        $month = $checkoutDate->format('M');
    
                        // Add the sales to the corresponding month
                        if (!isset($monthlySales[$month])) {
                            $monthlySales[$month] = 0;
                        }
    
                        $monthlySales[$month] += $sales;
                    }
                }
            }
        }
    
        // Ensure all months are included with zero sales and sort by month
        $allMonths = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $monthlySalesData = array_fill_keys($allMonths, 0);
    
        foreach ($monthlySales as $month => $sales) {
            $monthlySalesData[$month] = $sales;
        }
    
        return response()->json(['data' => $monthlySalesData]);
    }
    
    public function getDailySalesData()
    {
        $dailySales = [];
    
        // Replace 'your_sales_table' with your actual table name
        $checkouts = DB::table('checkouts')
            ->where('order_status', 'fulfilled')
            ->whereMonth('created_at', Carbon::now()->month)
            ->get();
    
        foreach ($checkouts as $checkout) {
            // Decode the cart_items JSON for this checkout.
            $cartItems = json_decode($checkout->cart_items, true);
    
            foreach ($cartItems as $cartItem) {
                // Ensure that 'product_id' and 'quantity' are available in the cart item.
                if (isset($cartItem['product_id']) && isset($cartItem['quantity'])) {
                    // Fetch additional details for the product based on 'product_id'.
                    $product = \App\Models\Admin\ProductManagement\Product::find($cartItem['product_id']);
    
                    if ($product) {
                        // Remove commas and convert to numeric values.
                        $sellingPrice = str_replace(',', '', $product->selling);
                        $quantity = str_replace(',', '', $cartItem['quantity']);
    
                        // Calculate the sales for this cart item based on the product details.
                        $sales = $sellingPrice * $quantity;
    
                        // Extract the day from the checkout date
                        $checkoutDate = Carbon::parse($checkout->created_at);
                        $day = $checkoutDate->format('M-d');
    
                        // Add the sales to the corresponding day
                        if (!isset($dailySales[$day])) {
                            $dailySales[$day] = 0;
                        }
    
                        $dailySales[$day] += $sales;
                    }
                }
            }
        }
    
        // Ensure all days are included with zero sales and sort by day
        $daysInMonth = Carbon::now()->daysInMonth;
        $allDays = range(1, $daysInMonth);
    
        $dailySalesData = [];
        foreach ($allDays as $day) {
            $formattedDay = Carbon::now()->format('M-') . str_pad($day, 2, '0', STR_PAD_LEFT);
            $dailySalesData[$formattedDay] = isset($dailySales[$formattedDay]) ? $dailySales[$formattedDay] : 0;
        }
    
        return response()->json(['data' => $dailySalesData]);
    }
    
    
    

    
    public function cartPage()
    {
        // Increment the cart page views count
        if (session()->has('cart_page_views')) {
            $pageViews = session('cart_page_views') + 1;
        } else {
            $pageViews = 1;
        }
        session(['cart_page_views' => $pageViews]);
    
        // Return the updated cart page views count
        return $pageViews;
    }
    
    
    public function calculateTotalRevenuePerMonth()
    {
        $totalRevenuePerMonth = [];
    
        // Get the start and end dates for the current month.
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();
    
        // Use the "whereBetween" clause for the created_at field
        // to filter the checkouts within the date range.
        $checkouts = Checkout::whereBetween('created_at', [$startDate, $endDate])
            ->where('order_status', 'fulfilled')
            ->get();
    
        $totalEarnings = 0; // Initialize the total earnings for this month.
    
        foreach ($checkouts as $checkout) {
            // Decode the cart_items JSON for this checkout.
            $cartItems = json_decode($checkout->cart_items, true);
    
            foreach ($cartItems as $cartItem) {
                // Ensure that 'product_id' and 'quantity' are available in the cart item.
                if (isset($cartItem['product_id']) && isset($cartItem['quantity'])) {
                    // Decode the 'product_id' as an integer.
                    $productId = (int) $cartItem['product_id'];
    
                    // Fetch additional details for the product based on 'product_id'.
                    $product = \App\Models\Admin\ProductManagement\Product::find($productId);
    
                    if ($product) {
                        // Remove commas and convert to numeric values.
                        $buyingPrice = str_replace(',', '', $product->buying);
                        $sellingPrice = str_replace(',', '', $product->selling);
                        $quantity = str_replace(',', '', $cartItem['quantity']);
    
                        // Calculate the earnings for this cart item based on the product details.
                        $earnings = ($sellingPrice - $buyingPrice) * $quantity;
                        $totalEarnings += $earnings;
                    }
                }
            }
        }
    
        $totalRevenuePerMonth[$startDate->format('Y M')] = number_format($totalEarnings);
    
        return $totalRevenuePerMonth;
    }
    
    public function calculateTotalEarnings()
    {
        $totalEarnings = 0; // Initialize the total earnings.
    
        // Retrieve checkouts with the 'fulfilled' order status.
        $checkouts = Checkout::where('order_status', 'fulfilled')->get();
    
        foreach ($checkouts as $checkout) {
            // Decode the cart_items JSON for this checkout.
            $cartItems = json_decode($checkout->cart_items, true);
    
            foreach ($cartItems as $cartItem) {
                // Ensure that 'product_id' and 'quantity' are available in the cart item.
                if (isset($cartItem['product_id']) && isset($cartItem['quantity'])) {
                    // Fetch additional details for the product based on 'product_id'.
                    $product = \App\Models\Admin\ProductManagement\Product::find($cartItem['product_id']);
                    
                    if ($product) {
                        // Remove commas and convert to numeric values.
                        $buyingPrice = str_replace(',', '', $product->buying);
                        $sellingPrice = str_replace(',', '', $product->selling);
                        $quantity = str_replace(',', '', $cartItem['quantity']);
    
                        // Calculate the earnings for this cart item based on the product details.
                        $earnings = ($sellingPrice - $buyingPrice) * $quantity;
                        $totalEarnings += $earnings;
                    }
                }
            }
        }
    
        return number_format($totalEarnings);
    }
    
    
    
    
        
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    // public function realtime()
    // {
    //     return view('admin.dashboard.realtimemetrics');
    // }
}
