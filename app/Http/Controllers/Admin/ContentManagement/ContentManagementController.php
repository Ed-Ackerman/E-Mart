<?php

namespace App\Http\Controllers\Admin\ContentManagement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\ContentManagement\Banner;

class ContentManagementController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function banners()
    {
        $banners = Banner::latest()-> paginate(10);
        return view('admin.contentmanagement.banner', compact('banners'));
    }

    public function searchbanners(Request $request)
    {
        $query = $request->input('banners-search');
    
        $banners = Banner::where('title', 'like', "%$query%")
            ->paginate(10); // Adjust the pagination limit as needed
    
        return view('admin.contentmanagement.banner', compact('banners'));
    }    

    public function create_banners()
    {
        return view('admin.contentmanagement.contentresources.create');
    }

    public function store_banners(Request $request)
    {
        // Validate the input
        $request->validate([
            'title' => 'nullable|max:255',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
            'description' => 'nullable|string',
            'status' => 'nullable|in:active,inactive',
        ]);

        if ($request->hasFile('banner')) {
            $image = $request->file('banner');
            $imagePath = time() . '-' . $image->getClientOriginalName();
            $image->storeAs('images/admin/banners', $imagePath, 'public');
        }
        
    
        // Create a new banner record in the database
        $banner = new Banner();
        $banner->title = $request->input('title');
        $banner->banner = $imagePath;
        $banner->description = $request->input('description');
        $banner->status = $request->input('status');
        $banner->save();
    
        return redirect()->route('banners')->with('success', 'Banner created successfully');
    }
    

    public function edit_banners($id)
    {
        $banner = Banner::find($id);

        return view('admin.contentmanagement.contentresources.edit', compact('banner'));
    }

    public function update_banners(Request $request, $id)
    {
        // Validate the input
        $request->validate([
            'title' => 'nullable|max:255',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'status' => 'nullable|in:active,inactive',
        ]);

        // Find the banner by its ID
        $banner = Banner::findOrFail($id);

        if ($request->hasFile('banner')) {
            $image = $request->file('banner');
            $imagePath = time() . '-' . $image->getClientOriginalName();
            $image->storeAs('images/admin/banners', $imagePath, 'public');
            $banner->banner = $imagePath;
        }

        // Update other banner details
        $banner->title = $request->input('title');
        $banner->description = $request->input('description');
        $banner->status = $request->input('status');
        $banner->update();

        return redirect()->route('banners')->with('success', 'Banner updated successfully');
    }

    

    public function show_banners($id)
    {
        $banner = Banner::find($id);

        return view('admin.contentmanagement.contentresources.show', compact('banner'));
    }

    public function delete_banners($id)
    {
        $banner = Banner::find($id);
        $banner->delete();

        return redirect()->route('banners')->with('success', 'Banner deleted successfully');
    }

}
