<?php

namespace App\Http\Controllers\Admin\CustomerSupportManagement;

use Illuminate\Http\Request;
use App\Models\Client\Help\Inquiry;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Models\Admin\CustomerSupportManagement\Help;

class CustomerSupportController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function help()
    {
        $inquiries = Inquiry::latest()->paginate(10);
        return view('admin.customersupportmanagement.help', compact('inquiries'));
    }

    public function index_faq()
    {
        $faqs = Help::latest()->paginate(10);
        return view('admin.customersupportmanagement.index', compact('faqs'));
    }
    
    public function searchfaq(Request $request)
    {
        $query = $request->input('faq-search');
    
        $faqs = Help::where('title', 'like', "%$query%")
            ->paginate(10); // Adjust the pagination limit as needed
    
        return view('admin.customersupportmanagement.index', compact('faqs'));
    }    

 

    public function create_faq()
    {
        return view('admin.customersupportmanagement.create');
    }

    public function store_faq(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'question' => 'required',
            'answer' => 'required',
        ]);

        Help::create([
            'title' => $request->input('title'),
            'question' => $request->input('question'),
            'answer' => $request->input('answer'),
        ]);

        return redirect()->route('index.faq')->with('success', 'FAQ created successfully');

    }

    public function edit_faq($id)
    {
        $faq = Help::find($id);

        if (!$faq) {
            return redirect()->route('index.faq')->with('error', 'FAQ not found');
        }

        return view('admin.customersupportmanagement.edit', compact('faq'));
    }

    public function update_faq(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|max:255',
            'question' => 'required',
            'answer' => 'required',
        ]);

        $faq = Help::find($id);

        if (!$faq) {
            return redirect()->route('index.faq')->with('error', 'FAQ not found');
        }

        $faq->title = $request->input('title');
        $faq->question = $request->input('question');
        $faq->answer = $request->input('answer');
        $faq->save();

        return redirect()->route('index.faq')->with('success', 'FAQ updated successfully');
    }

    public function show_faq($id)
    {
        $faq = Help::find($id);

        if (!$faq) {
            return redirect()->route('index.faq')->with('error', 'FAQ not found');
        }

        return view('admin.customersupportmanagement.show', compact('faq'));
    }

  

    public function delete_faq($id)
    {
        $faq = Help::find($id);

        if ($faq) {
            $faq->delete();
            return redirect()->route('index.faq')->with('success', 'FAQ deleted successfully');
        } else {
            return redirect()->route('index.faq')->with('error', 'FAQ not found');
        }
    }

    public function show_inquiry($id)
    {
        $inquiry = Inquiry::find($id);
        Session::forget('new_inquiry');
        if (!$inquiry) {
            return redirect()->route('help')->with('error', 'Inquiry not found');
        }

        return view('admin.customersupportmanagement.showinquiry', compact('inquiry'));
    }

    public function searchinqiry(Request $request)
    {
        $query = $request->input('inquiry-search');
    
        $inquiries = Inquiry::where('name', 'like', "%$query%")
            ->paginate(10); // Adjust the pagination limit as needed
    
        return view('admin.customersupportmanagement.help', compact('inquries'));
    }    

    public function delete_inquiry($id)
    {
        $inquiry = Inquiry::find($id);

        if ($inquiry) {
            $inquiry->delete();
            return redirect()->route('help')->with('success', 'Inquiry deleted successfully');
        } else {
            return redirect()->route('help')->with('error', 'Inquiry not found');
        }
    }

}
