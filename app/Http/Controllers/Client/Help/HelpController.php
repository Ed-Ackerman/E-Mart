<?php

namespace App\Http\Controllers\Client\Help;

use Illuminate\Http\Request;
use App\Models\Client\Help\Inquiry;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Models\Admin\CustomerSupportManagement\Help;

class HelpController extends Controller
{
    //
    public function client_help()
    {
        $faqs = Help::all();
        return view('client.help.help', compact(
            'faqs',
        ));
    }

    public function inquiry_search(Request $request)
    {
        $query = $request->input('inquiry-search');
    
        // Update the column name to "inquiry" in your query
        $faqs = Help::where('question', 'like', "%$query%")->get();
    
        return view('client.help.help', compact('faqs'));
    }
    
    
    public function store_inquiry(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'tel' => 'required|max:255',
            'email' => 'required|max:255',
            'inquiry' => 'required',
        ]);
    
        Inquiry::create([
            'name' => $request->input('name'),
            'tel' => $request->input('tel'),
            'email' => $request->input('email'),
            'inquiry' => $request->input('inquiry'),
        ]);
    
        // Set a session variable to indicate a new inquiry
        Session::put('new_inquiry', true);
    
        return redirect()->route('client.help')->with('success', 'Inquiry sent successfully');
    }
    
}
