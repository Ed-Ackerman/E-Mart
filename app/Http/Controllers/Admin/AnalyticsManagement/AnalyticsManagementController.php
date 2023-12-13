<?php

namespace App\Http\Controllers\Admin\AnalyticsManagement;

use \PDF;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Client\Checkout\Checkout;
use App\Models\Client\Custom\Custom;

class AnalyticsManagementController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function sales()
    {
        // Fetch only fulfilled orders
        $orders = Checkout::where('order_status', 'fulfilled')->latest()->paginate(10);
    
        return view('admin.analyticamanagement.sales', compact('orders'));
    }
    

    public function salesreport(Request $request)
    {
        $pdf = app('dompdf.wrapper');
        
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        
        // Retrieve sales data based on your specific criteria
        $salesData = Checkout::where(function ($query) use ($startDate, $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate])
                ->orWhereDate('created_at', $startDate)
                ->orWhereDate('created_at', $endDate);
        })
        ->where('order_status', 'fulfilled')
        ->latest()
        ->get();
        
    
        // dd($salesData);
        // Decode the cart items JSON for each checkout
        $salesData->each(function ($checkout) {
            $checkout->cart_items = json_decode($checkout->cart_items, true);
        });
        
        $pdf = PDF::loadView('admin.analyticamanagement.salesreport', [
            'salesData' => $salesData,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);
        
        // Optional: Set paper size and orientation
        $pdf->setPaper('A4', 'landscape');
        
        // Return the PDF for viewing in the browser
        return $pdf->stream();
        // To download the PDF directly, use the following line instead:
        // return $pdf->download('sales_report.pdf');
    }
    
    

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function customsales()
    {
        $orders = Custom::where('order_status', 'fulfilled')->latest()->paginate(10);
    
        return view('admin.analyticamanagement.customs', compact('orders'));
    }

    public function customsalesreport(Request $request)
    {
        $pdf = app('dompdf.wrapper');
        
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        
        // Retrieve sales data based on your specific criteria
        $salesData = Custom::where(function ($query) use ($startDate, $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate])
                ->orWhereDate('created_at', $startDate)
                ->orWhereDate('created_at', $endDate);
        })
        ->where('order_status', 'fulfilled')
        ->latest()
        ->get();
        
    
        // dd($salesData);
        // Decode the cart items JSON for each checkout
        $salesData->each(function ($custom) {
            $custom->custom_order = json_decode($custom->custom_order, true);
        });
        
        $pdf = PDF::loadView('admin.analyticamanagement.customsalesreport', [
            'salesData' => $salesData,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);
        
        // Optional: Set paper size and orientation
        $pdf->setPaper('A4', 'landscape');
        
        // Return the PDF for viewing in the browser
        return $pdf->stream();
        // To download the PDF directly, use the following line instead:
        // return $pdf->download('sales_report.pdf');
    }
    
}
