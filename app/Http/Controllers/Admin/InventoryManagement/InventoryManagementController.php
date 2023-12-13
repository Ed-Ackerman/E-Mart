<?php

namespace App\Http\Controllers\Admin\InventoryManagement;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Admin\ProductManagement\Product;
use App\Models\Admin\ProductManagement\Category;
use App\Models\Admin\InventoryManagement\Supplier;
use App\Models\Admin\InventoryManagement\Inventory;
use App\Models\Admin\InventoryManagement\Warehouse;
use App\Models\Admin\ProductManagement\SubCategory;
use App\Models\Admin\ProductManagement\SubSubCategory;

class InventoryManagementController extends Controller
{

    /**
     * $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
     * Levels
     *$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
    */ 
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function levels()
    {
        $products = Product::latest()->paginate(10);
        $productsBelowThresholdCount = Product::where('quantity', '<=', DB::raw('alert_threshold'))->count();
        return view('admin.inventorymanagement.levels', compact('products', 'productsBelowThresholdCount'));
    }

    public function searchlevel(Request $request)
    {
        $query = $request->input('level-search');

        $products = Product::where('name', 'like', "%$query%")
            ->paginate(10); // Adjust the pagination limit as needed

        return view('admin.inventorymanagement.levels', compact('products'));
    }

    public function reorder()
    {
        // Filter products that need reordering
        $products = Product::whereRaw('CAST(quantity AS SIGNED) <= CAST(alert_threshold AS SIGNED)')->where('quantity', '>', 0)->latest()->paginate(10);    
        return view('admin.inventorymanagement.levels', compact('products'));
    }
    
    public function outOfStock()
    {
        // Filter products that are out of stock (quantity is 0)
        $products = Product::whereRaw('CAST(quantity AS SIGNED) = 0')->latest()->paginate(10);
        return view('admin.inventorymanagement.levels', compact('products'));
    }
    
    public function inStock()
    {
        $products = Product::whereRaw('CAST(quantity AS SIGNED) > CAST(alert_threshold AS SIGNED)')->latest()->paginate(10);
        return view('admin.inventorymanagement.levels', compact('products'));
    }
    
    

     /**
     * $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
     * Supplier
     *$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
    */ 

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function suppliers()
    {
        $suppliers = Supplier::latest()->paginate(10);
        return view('admin.inventorymanagement.supplier', compact('suppliers'));
    }

    public function searchsupplier(Request $request)
    {
        $query = $request->input('supplier-search');

        $suppliers = Supplier::where('name', 'like', "%$query%")
            ->paginate(10); // Adjust the pagination limit as needed

        return view('admin.inventorymanagement.supplier', compact('suppliers'));
    }

    public function show_suppliers($id)
    {
        $supplier = Supplier::find($id);  
        $categories = Category::all();

        if (!$supplier) {
            return redirect()->route('suppliers')->with('error', 'Supplier not found');
        }
    
        return view('admin.inventorymanagement.supplierresources.show', compact('supplier', 'categories'));
    }
    

    public function create_suppliers()
    {
        $categories = Category::all();
        return view('admin.inventorymanagement.supplierresources.create', compact('categories'));
    }  

    public function store_suppliers(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:255',
            'tel' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255',
            'location' => 'nullable|string|max:255',
            'terms' => 'nullable|string',
            'payment' => 'nullable|string',
            'product' => 'nullable|string',
            'lead' => 'nullable|array',
            'lead.*' => 'in:1_week,2_weeks,3_weeks,4_years',
            'method' => 'nullable|array',
            'method.*' => 'in:mobile_money,debit,credit,bank',
            'category_ids' => 'nullable|array',
            'category_ids.*' => 'exists:categories,id',
        ]);

        $supplier = new Supplier();
        $supplier->name = $request->input('name');
        $supplier->code = $request->input('code');
        $supplier->tel = $request->input('tel');
        $supplier->email = $request->input('email');
        $supplier->location = $request->input('location');
        $supplier->terms = $request->input('terms');
        $supplier->payment = $request->input('payment');
        $supplier->product = $request->input('product');

        
        $selectedLead = $request->input('lead', []);
        if ($request->filled('custom_lead')) {
            $selectedLead[] = 'custom';
            $supplier ->custom_lead = $request->input('custom_lead');
        }

        $supplier->lead = implode(',', $selectedLead);

        $selectedMethod = $request->input('method', []);

        if ($request->filled('custom_method')) {
            $selectedMethod[] = 'custom';
            $supplier -> custom_method = $request->input('custom_method');
        }

        $supplier->method = implode(',', $selectedMethod);

        $supplier->save();

        $supplier->categories()->attach($request->input('category_ids'));

        return redirect()->route('suppliers')->with('success', 'Supplier added successfully');
    }   

    public function edit_suppliers($id)
    {
        $supplier = Supplier::find($id);
        $categories = Category::all();
        if (!$supplier) {
            return redirect()->route('suppliers')->with('error', 'Supplier not found');
        }

        return view('admin.inventorymanagement.supplierresources.edit', compact( 'supplier', 'categories'));
    }

    public function update_suppliers(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:255',
            'tel' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255',
            'location' => 'nullable|string|max:255',
            'terms' => 'nullable|string',
            'payment' => 'nullable|string',
            'product' => 'nullable|string',
            'lead' => 'nullable|array',
            'lead.*' => 'in:1_week,2_weeks,3_weeks,4_years',
            'method' => 'nullable|array',
            'method.*' => 'in:mobile_money,debit,credit,bank',
            'category_ids' => 'nullable|array',
            'category_ids.*' => 'exists:categories,id',
        ]);

        $supplier = Supplier::find($id);
        $supplier->name = $request->input('name');
        $supplier->code = $request->input('code');
        $supplier->tel = $request->input('tel');
        $supplier->email = $request->input('email');
        $supplier->location = $request->input('location');
        $supplier->terms = $request->input('terms');
        $supplier->payment = $request->input('payment');
        $supplier->product = $request->input('product');

        
        $selectedLead = $request->input('lead', []);
        if ($request->filled('custom_lead')) {
            $selectedLead[] = 'custom';
            $supplier ->custom_lead = $request->input('custom_lead');
        }

        $supplier->lead = implode(',', $selectedLead);

        $selectedMethod = $request->input('method', []);

        if ($request->filled('custom_method')) {
            $selectedMethod[] = 'custom';
            $supplier -> custom_method = $request->input('custom_method');
        }

        $supplier->method = implode(',', $selectedMethod);

        $supplier->update();

        $supplier->categories()->sync($request->input('category_ids'));

        return redirect()->route('suppliers')->with('success', 'Supplier Updated successfully');
    }   

    public function delete_suppliers($id)
    {
        $supplier = Supplier::find($id); 
        
        if (!$supplier) {
            return redirect()->route('suppliers')->with('error', 'Supplier not found');
        }

        $supplier->delete();

        return redirect()->route('suppliers')->with('success', 'Supplier deleted successfully');
    }
   /**
     * $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
     * wharehouse
     *$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
    */ 
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function warehouse()
    {
        $warehouses = Warehouse::latest() -> paginate(10);
        return view('admin.inventorymanagement.warehouse', compact('warehouses'));
    }
    public function searchwarehouse(Request $request)
    {
        $query = $request->input('warehouse-search');

        $warehouses = Warehouse::where('name', 'like', "%$query%")
            ->paginate(10); // Adjust the pagination limit as needed

        return view('admin.inventorymanagement.warehouse', compact('warehouses'));
    }
    public function show_warehouse($id)
    {
        $warehouse = Warehouse::find($id);  
        $categories = Category::all();

        if (!$warehouse) {
            return redirect()->route('warehouse')->with('error', 'Warehouse not found');
        }
    
        return view('admin.inventorymanagement.warehouseresources.show', compact('warehouse', 'categories'));
    }
    
    public function create_warehouse()
    {
        $categories = Category::all();
        return view('admin.inventorymanagement.warehouseresources.create', compact( 'categories'));
    }    

    public function store_warehouse(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:255',
            'tel' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255',
            'location' => 'nullable|string|max:255',
            'terms' => 'nullable|string',
            'payment' => 'nullable|string',
            'product' => 'nullable|string',
            'capacity' => 'nullable|string',
            'method' => 'nullable|array',
            'method.*' => 'in:mobile_money,debit,credit,bank',
            'category_ids' => 'nullable|array',
            'category_ids.*' => 'exists:categories,id',
        ]);

        $warehouse = new Warehouse();
        $warehouse->name = $request->input('name');
        $warehouse->code = $request->input('code');
        $warehouse->tel = $request->input('tel');
        $warehouse->email = $request->input('email');
        $warehouse->location = $request->input('location');
        $warehouse->terms = $request->input('terms');
        $warehouse->payment = $request->input('payment');
        $warehouse->product = $request->input('product');
        $warehouse->capacity = $request->input('capacity');

        $selectedMethod = $request->input('method', []);

        if ($request->filled('custom_method')) {
            $selectedMethod[] = 'custom';
            $warehouse -> custom_method = $request->input('custom_method');
        }

        $warehouse->method = implode(',', $selectedMethod);

        $warehouse->save();

        $warehouse->categories()->attach($request->input('category_ids'));

        return redirect()->route('warehouse')->with('success', 'Warehouse added successfully');
    }   
    
    public function edit_warehouse($id)
    {
        $warehouse = Warehouse::find($id);
        $categories = Category::all();
        if (!$warehouse) {
            return redirect()->route('warehouse')->with('error', 'Warehouse not found');
        }

        return view('admin.inventorymanagement.warehouseresources.edit', compact( 'warehouse', 'categories'));
    }

    public function update_warehouse(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:255',
            'tel' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255',
            'location' => 'nullable|string|max:255',
            'terms' => 'nullable|string',
            'payment' => 'nullable|string',
            'product' => 'nullable|string',
            'capacity' => 'nullable|string',
            'method' => 'nullable|array',
            'method.*' => 'in:mobile_money,debit,credit,bank',
            'category_ids' => 'nullable|array',
            'category_ids.*' => 'exists:categories,id',
        ]);

        $warehouse = Warehouse::find($id);
        $warehouse->name = $request->input('name');
        $warehouse->code = $request->input('code');
        $warehouse->tel = $request->input('tel');
        $warehouse->email = $request->input('email');
        $warehouse->location = $request->input('location');
        $warehouse->terms = $request->input('terms');
        $warehouse->payment = $request->input('payment');
        $warehouse->product = $request->input('product');
        $warehouse->capacity = $request->input('capacity');

        $selectedMethod = $request->input('method', []);

        if ($request->filled('custom_method')) {
            $selectedMethod[] = 'custom';
            $warehouse -> custom_method = $request->input('custom_method');
        }

        $warehouse->method = implode(',', $selectedMethod);

        $warehouse->update();

        $warehouse->categories()->sync($request->input('category_ids'));

        return redirect()->route('warehouse')->with('success', 'Warehouse added successfully');
    }   

    public function delete_warehouse($id)
    {
        $warehouse = Warehouse::find($id);
    
        if (!$warehouse) {
            return redirect()->route('warehouse')->with('error', 'Warehouse not found');
        }
    
        if (request()->has('confirmed') && request('confirmed') === 'yes') {
            $warehouse->delete();
            return redirect()->route('warehouse')->with('success', 'Warehouse deleted successfully');
        }
    
        return view('your.delete-warehouse-view', compact('warehouse'));
    }
    
}