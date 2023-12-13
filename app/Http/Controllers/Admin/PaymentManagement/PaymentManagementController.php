<?php

namespace App\Http\Controllers\Admin\PaymentManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentManagementController extends Controller
{
   /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function payment_get()
    {
        return view('admin.paymentmanagement.payment_get');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function payment_pro()
    {
        return view('admin.paymentmanagement.payment_pro');
    }
}
