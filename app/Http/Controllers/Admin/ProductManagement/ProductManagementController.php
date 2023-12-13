<?php

namespace App\Http\Controllers\Admin\ProductManagement;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use SebastianBergmann\GlobalState\Exception;
use App\Models\Admin\ProductManagement\Product;
use App\Models\Admin\ProductManagement\Category;
use App\Models\Admin\InventoryManagement\Supplier;
use App\Models\Admin\ProductManagement\SubCategory;
use App\Models\Admin\ProductManagement\SubSubCategory;

class ProductManagementController extends Controller
{
    

     /**
     * $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
     *Porduct Categories
     *$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
    */ 

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    // Category Index
    public function categories()
    {
        $categories = Category::latest()->paginate(10); // Fetch latest categories from the database.
        return view('admin.productmanagement.categories', compact('categories'));
    }

    // Category Search (Search Form)
    public function searchCategories(Request $request)
    {
        $query = $request->input('category-search');

        $categories = Category::where('name', 'like', "%$query%")
            ->paginate(10); // Adjust the pagination limit as needed

        return view('admin.productmanagement.categories', compact('categories'));
    }

    // Category Create (Show Create Form)
    public function create_categories()
    {
        return view('admin.productmanagement.categoryresources.create');
    }

    // Category Store (Handle Create Form Submission)
    public function store_categories(Request $request)
    {
        // Validation rules
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('create.categories')
                ->withErrors($validator)
                ->withInput();
        }

        Category::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);

        return redirect()->route('categories')->with('success', 'Category created successfully');
    }

    // Category Edit (Show Edit Form)
    public function edit_categories($id)
    {
        $category = Category::find($id); // Find the category by its ID.
        
        if (!$category) {
            return redirect()->route('categories')->with('error', 'Category not found');
        }

        return view('admin.productmanagement.categoryresources.edit', compact('category'));
    }

    // Category Update (Handle Edit Form Submission)
    public function update_categories(Request $request, $id)
    {
        $category = Category::find($id); // Find the category by its ID.
        
        if (!$category) {
            return redirect()->route('categories')->with('error', 'Category not found');
        }

        // Validation rules
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('edit.categories', ['id' => $id]) // Redirect back to the edit form.
                ->withErrors($validator)
                ->withInput();
        }

        // Update the category with the new data.
        $category->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);

        return redirect()->route('categories')->with('success', 'Category updated successfully');
    }

    // Category Show (Show Details)
    public function show_categories($id)
    {
        $category = Category::find($id); // Find the category by its ID.
        $subcategories = SubCategory::all();
        $subsubcategories = SubSubCategory::all();
        if (!$category) {
            return redirect()->route('categories')->with('error', 'Category not found');
        }

        return view('admin.productmanagement.categoryresources.show', compact('category','subcategories','subsubcategories'));
    }

    // Category Delete
    public function delete_categories($id)
    {
        $category = Category::find($id); // Find the category by its ID.
        
        if (!$category) {
            return redirect()->route('categories')->with('error', 'Category not found');
        }

        $category->delete(); // Delete the category.

        return redirect()->route('categories')->with('success', 'Category deleted successfully');
    }

    // $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$

    /**
     * Sub Categories Management
     */
    public function subcategories()
    {
        $subcategories = SubCategory::latest()->paginate(10);
        return view('admin.productmanagement.subcategoryresources.index', compact('subcategories'));
    }

     // SubCategory Search (Search Form)
     public function searchsubCategories(Request $request)
     {
         $query = $request->input('subcategory-search');
 
         $subcategories = SubCategory::where('name', 'like', "%$query%")
             ->paginate(10); // Adjust the pagination limit as needed
 
         return view('admin.productmanagement.subcategoryresources.index', compact('subcategories'));
     }
   // SubCategory and Subcategory Create (Show Create Form)
    public function create_subcategories()
    {
        $categories = Category::all(); 
        return view('admin.productmanagement.subcategoryresources.create', compact('categories'));
    }

    public function store_subcategories(Request $request)
    {
        // Validation rules for subcategories
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_ids' => 'required|array', 
            'category_ids.*' => 'exists:categories,id', 
        ]);

        $subcategory = SubCategory::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);

        // Attach the selected categories to the subcategory
        $subcategory->categories()->attach($request->input('category_ids'));

        return redirect()->route('subcategories')->with('success', 'Subcategory created successfully');
    
    }
         
    
   // SubCategory Show (Show Details)
    public function show_subcategories($id)
    {
        $subcategory = SubCategory::find($id); 
        $categories = Category::all(); 
        $subsubcategories = SubSubCategory::all();
        if (!$subcategory) {
            return redirect()->route('subcategories')->with('error', 'SubCategory not found');
        }

        return view('admin.productmanagement.subcategoryresources.show', compact('subcategory', 'categories', 'subsubcategories'));
    }


    // SubCategory Edit (Show Edit Form)
    public function edit_subcategories($id)
    {
        $subcategory = SubCategory::find($id); 
        $categories = Category::all(); 
        if (!$subcategory) {
            return redirect()->route('subcategories')->with('error', 'SubCategory not found');
        }

        return view('admin.productmanagement.subcategoryresources.edit', compact('subcategory', 'categories'));
    }

    public function update_subcategories(Request $request, $id)
    {
        // Find the subcategory by its ID.
        $subcategory = SubCategory::find($id);

        if (!$subcategory) {
            return redirect()->route('subcategories')->with('error', 'Subcategory not found');
        }

        // Validation rules for updating subcategories
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_ids' => 'required|array',
            'category_ids.*' => 'exists:categories,id',
        ]);

        // Update the subcategory with the new data
        $subcategory->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);

        // Sync the associated categories with the subcategory
        $subcategory->categories()->sync($request->input('category_ids'));

        return redirect()->route('subcategories')->with('success', 'Subcategory updated successfully');
    }


    // SubCategory Delete
    public function delete_subcategories($id)
    {
        $subcategory = SubCategory::find($id); 
        
        if (!$subcategory) {
            return redirect()->route('subcategories')->with('error', 'SubCategory not found');
        }

        $subcategory->delete();

        return redirect()->route('subcategories')->with('success', 'SubCategory deleted successfully');
    }

    // $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$

   /**
     * Sub Categories Management
     */
    public function subsubcategories()
    {
        $subsubcategories = SubSubCategory::latest()->paginate(10);
        return view('admin.productmanagement.subsubcategoryresources.index', compact('subsubcategories'));
    }


    // SubCategory Search (Search Form)
    public function searchsubsubCategories(Request $request)
    {
        $query = $request->input('subsubcategory-search');

        $subsubcategories = SubSubCategory::where('name', 'like', "%$query%")
            ->paginate(10); // Adjust the pagination limit as needed

        return view('admin.productmanagement.subsubcategoryresources.index', compact('subsubcategories'));
    }

   // SubCategory and Subcategory Create (Show Create Form)
    public function create_subsubcategories()
    {
        $subcategories = SubCategory::all(); 
        return view('admin.productmanagement.subsubcategoryresources.create', compact('subcategories'));
    }

    public function store_subsubcategories(Request $request)
    {

        // Validation rules for subcategories
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'subcategory_ids' => 'required|array', 
            'subcategory_ids.*' => 'exists:sub_categories,id', 
        ]);

        $subsubcategory = SubSubCategory::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);

        
        // Attach the selected categories to the subcategory
        $subsubcategory->subcategories()->attach($request->input('subcategory_ids'));


        return redirect()->route('subsubcategories')->with('success', 'Sub-Subcategory created successfully');
    
    }
         
    
    // SubCategory Show (Show Details)
    public function show_subsubcategories($id)
    {
        $subsubcategory = SubSubCategory::find($id); 
        $categories = Category::all();
        $subcategories = SubCategory::all(); 
    
    
        if (!$subsubcategory) {
            return redirect()->route('subsubcategories')->with('error', 'Sub-SubCategory not found');
        }
    
        return view('admin.productmanagement.subsubcategoryresources.show', compact('subsubcategory', 'subcategories', 'categories'));
    }
    

    // SubCategory Edit (Show Edit Form)
    public function edit_subsubcategories($id)
    {
        $subsubcategory = SubSubCategory::find($id); 
        $subcategories = SubCategory::all(); 
        $categories = Category::all();
        if (!$subsubcategory) {
            return redirect()->route('subsubcategories')->with('error', 'Sub-SubCategory not found');
        }

        return view('admin.productmanagement.subsubcategoryresources.edit', compact('subsubcategory', 'subcategories', 'categories'));
    }

    public function update_subsubcategories(Request $request, $id)
    {
        // Find the subcategory by its ID.
        $subsubcategory = SubSubCategory::find($id);

        if (!$subsubcategory) {
            return redirect()->route('subsubcategories')->with('error', 'Sub-Subcategory not found');
        }

        // Validation rules for updating subcategories
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'subcategory_ids' => 'required|array',
            'subcategory_ids.*' => 'exists:sub_categories,id',
        ]);

        // Update the subcategory with the new data
        $subsubcategory->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);

        // Sync the associated categories with the subcategory
        $subsubcategory->subcategories()->sync($request->input('subcategory_ids'));

        return redirect()->route('subsubcategories')->with('success', 'Sub-Subcategory updated successfully');
    }


    // SubCategory Delete
    public function delete_subsubcategories($id)
    {
        $subsubcategory = SubSubCategory::find($id); 
        
        if (!$subsubcategory) {
            return redirect()->route('subsubcategories')->with('error', 'Sub-SubCategory not found');
        }

        $subsubcategory->delete();

        return redirect()->route('subsubcategories')->with('success', 'Sub-SubCategory deleted successfully');
    }

    /**
     * $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
     *Porduct Catalog
     *$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
    */ 
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function products()
    {
        $products = Product::latest()->paginate(10);
        return view('admin.productmanagement.catalog', compact('products'));
    }   


    public function searchproduct(Request $request)
    {
        $query = $request->input('product-search');

        $products = Product::where('name', 'like', "%$query%")
            ->paginate(10); // Adjust the pagination limit as needed

        return view('admin.productmanagement.catalog', compact('products'));
    }

    public function show_product($id)
    {
        $product = Product::find($id); 
        $subsubcategories = SubSubCategory::all(); 
        $categories = Category::all();
        $subcategories = SubCategory::all(); 
    
    
        if (!$product) {
            return redirect()->route('products')->with('error', 'Product not found');
        }
    
        return view('admin.productmanagement.catalogresourcces.show', compact('product','subsubcategories', 'subcategories', 'categories'));
    }
    

    public function create_product()
    {
        $categories = Category::all();
        $subcategories = SubCategory::all(); 
        $subsubcategories = SubSubCategory::all(); 
        $suppliers = Supplier::all();
         return view('admin.productmanagement.catalogresourcces.create', compact('subcategories', 'categories', 'subsubcategories', 'suppliers'));
    }      

    public function store_product(Request $request)
    {

        $request->validate([
            'name' => 'required|string',
            'code' => 'nullable|string',
            'image' => 'nullable|array',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif',
            'description' => 'nullable|string',
            'color' => 'nullable|string',
            'size' => 'nullable|array',
            'size.*' => 'in:small,medium,large,XL,XXL,XXXL,custom',
            'custom_size' => 'nullable|string',
            'material' => 'nullable|string',
            'custom_warranty' => 'nullable|string',
            'warranty' => 'nullable|array',
            'warranty.*' => 'in:1_year,2_years,3_years,5_years,lifetime,custom',
            'brand' => 'nullable|string',
            'weight' => 'nullable|numeric|min:1',
            'custom_condition' => 'nullable|string',
            'condition' => 'nullable|array',
            'condition.*' => 'in:New,Used,Refurbished,custom',
            'custom_availability' => 'nullable|string',
            'availability' => 'nullable|array',
            'availability.*' => 'in:in_stock,out_of_stock,shipping,custom',
            'rating' => 'nullable|numeric|min:0|max:5',
            'expense' => 'nullable|string',
            'features' => 'nullable|string',
            'quantity' => 'nullable|string',
            'buying' => 'nullable|string',
            'selling' => 'nullable|string',
            'discount' => 'nullable|string',
            'alert_threshold' => 'nullable|numeric',
            'total' => 'nullable|string',
            'profit' => 'nullable|string',
            'category_ids' => 'nullable|array',
            'category_ids.*' => 'exists:categories,id',
            'supplier_ids' => 'nullable|array',
            'supplier_ids.*' => 'exists:suppliers,id',
            'subcategory_ids' => 'nullable|array',
            'subcategory_ids.*' => 'exists:sub_categories,id',
            'subsubcategory_ids' => 'nullable|array',
            'subsubcategory_ids.*' => 'exists:sub_sub_categories,id',
        ]);
        
          
        // Create a new Product instance
        $product = new Product();
   
        // Handling img       
        if ($request->hasFile('image')) {
            $imagePaths = []; // Initialize an array to store image paths
            
            foreach ($request->file('image') as $image) {
                $uniqueFilename = time() . '-' . $image->getClientOriginalName();
                $image->storeAs('images/admin/product', $uniqueFilename, 'public');
                $imagePaths[] = $uniqueFilename; // Add the image path to the array
            }
        
            // Store the array of image paths as a comma-separated string
            $product->image = implode(',', $imagePaths);
        }       

        // Basic Information
        $product->name = $request->input('name');
        $product->code = $request->input('code');
        $product->description = $request->input('description');
        $product->color = $request->input('color');

        // Handle size field
        $selectedSizes = $request->input('size', []);
    
        if ($request->filled('custom_size')) {
            $selectedSizes[] = 'custom';
            $product->custom_size = $request->input('custom_size');
        }
    
        $product->size = implode(',', $selectedSizes);
    
        $product->material = $request->input('material');
        
        // Handle warranty field
        $selectedWarranties = $request->input('warranty', []);
    
        if ($request->filled('custom_warranty')) {
            $selectedWarranties[] = 'custom';
            $product->custom_warranty = $request->input('custom_warranty');
        }
    
        $product->warranty = implode(',', $selectedWarranties);
    
        $product->brand = $request->input('brand');
        $product->weight = $request->input('weight');
        
        // Handle condition field
        $selectedConditions = $request->input('condition', []);
    
        if ($request->filled('custom_condition')) {
            $selectedConditions[] = 'custom';
            $product->custom_condition = $request->input('custom_condition');
        }
    
        $product->condition = implode(',', $selectedConditions);
        
        // Handle availability field
        $selectedAvailabilities = $request->input('availability', []);
    
        if ($request->filled('custom_availability')) {
            $selectedAvailabilities[] = 'custom';
            $product->custom_availability = $request->input('custom_availability');
        }
    
        $product->availability = implode(',', $selectedAvailabilities);

        $product->rating = $request->input('rating');
        $product->expense = $request->input('expense');
        $product->features = $request->input('features');
        $product->quantity = $request->input('quantity');
        $product->buying = $request->input('buying');
        $product->selling = $request->input('selling');
        $product->discount = $request->input('discount');
        $product->total = $request->input('total');
        $product->profit = $request->input('profit');
        $product->alert_threshold = $request->input('alert_threshold');
        $product->custom_size = $request->input('custom_size');
        $product->custom_warranty = $request->input('custom_warranty');
        $product->custom_condition = $request->input('custom_condition');
        $product->custom_availability = $request->input('custom_availability');

        // Save the product
  
        $product->save();
    
        // Attach categories, subcategories, and sub-subcategories to the product
        $product->categories()->attach($request->input('category_ids'));
        $product->subcategories()->attach($request->input('subcategory_ids'));
        $product->subsubcategories()->attach($request->input('subsubcategory_ids'));
        $product->suppliers()->attach($request->input('supplier_ids')); 

        return redirect()->route('products')->with('success', 'Product created successfully');
    }
    
     // SubCategory Edit (Show Edit Form)
     public function edit_product($id)
     {
         $product = Product::find($id);
         $subsubcategories = SubSubCategory::all(); 
         $subcategories = SubCategory::all(); 
         $categories = Category::all();
         $suppliers = Supplier::all();
         if (!$product) {
             return redirect()->route('product')->with('error', 'Product not found');
         }
 
         return view('admin.productmanagement.catalogresourcces.edit', compact( 'product','subsubcategories', 'subcategories', 'categories', 'suppliers'));
     }
 

     public function update_product(Request $request, $id)
     {
        $request->validate([
            'name' => 'required|string',
            'code' => 'nullable|string',
            'image' => 'nullable|array',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif',
            'description' => 'nullable|string',
            'color' => 'nullable|string',
            'size' => 'nullable|array',
            'size.*' => 'in:small,medium,large,XL,XXL,XXXL,custom',
            'custom_size' => 'nullable|string',
            'material' => 'nullable|string',
            'custom_warranty' => 'nullable|string',
            'warranty' => 'nullable|array',
            'warranty.*' => 'in:1_year,2_years,3_years,5_years,lifetime,custom',
            'brand' => 'nullable|string',
            'weight' => 'nullable|numeric|min:1',
            'custom_condition' => 'nullable|string',
            'condition' => 'nullable|array',
            'condition.*' => 'in:New,Used,Refurbished,custom',
            'custom_availability' => 'nullable|string',
            'availability' => 'nullable|array',
            'availability.*' => 'in:in_stock,out_of_stock,shipping,custom',
            'rating' => 'nullable|numeric|min:0|max:5',
            'expense' => 'nullable|string',
            'features' => 'nullable|string',
            'quantity' => 'nullable|string',
            'buying' => 'nullable|string',
            'selling' => 'nullable|string',
            'discount' => 'nullable|string',
            'alert_threshold' => 'nullable|numeric',
            'total' => 'nullable|string',
            'profit' => 'nullable|string',
            'category_ids' => 'nullable|array',
            'category_ids.*' => 'exists:categories,id',
            'supplier_ids' => 'nullable|array',
            'supplier_ids.*' => 'exists:suppliers,id',
            'subcategory_ids' => 'nullable|array',
            'subcategory_ids.*' => 'exists:sub_categories,id',
            'subsubcategory_ids' => 'nullable|array',
            'subsubcategory_ids.*' => 'exists:sub_sub_categories,id',
        ]);
        
    
        // Create a new Product instance
        $product = Product::find($id);

        if (!$product) {
            return redirect()->route('products')->with('error', 'Product not found.');
        }
    
        // Handling img
        if ($request->hasFile('image')) {
            $imagePaths = []; // Initialize an array to store image paths
            
            foreach ($request->file('image') as $image) {
                $uniqueFilename = time() . '-' . $image->getClientOriginalName();
                $image->storeAs('images/admin/product', $uniqueFilename, 'public');
                $imagePaths[] = $uniqueFilename; // Add the image path to the array
            }
        
            // Store the array of image paths as a comma-separated string
            $product->image = implode(',', $imagePaths);
        }
        
        

        // Basic Information
        $product->name = $request->input('name');
        $product->code = $request->input('code');
        $product->description = $request->input('description');
        $product->color = $request->input('color');
        
        // Handle size field
        $selectedSizes = $request->input('size', []);
    
        if ($request->filled('custom_size')) {
            $selectedSizes[] = 'custom';
            $product->custom_size = $request->input('custom_size');
        }
    
        $product->size = implode(',', $selectedSizes);
    
        $product->material = $request->input('material');
        
        // Handle warranty field
        $selectedWarranties = $request->input('warranty', []);
    
        if ($request->filled('custom_warranty')) {
            $selectedWarranties[] = 'custom';
            $product->custom_warranty = $request->input('custom_warranty');
        }
    
        $product->warranty = implode(',', $selectedWarranties);
    
        $product->brand = $request->input('brand');
        $product->weight = $request->input('weight');
        
        // Handle condition field
        $selectedConditions = $request->input('condition', []);
    
        if ($request->filled('custom_condition')) {
            $selectedConditions[] = 'custom';
            $product->custom_condition = $request->input('custom_condition');
        }
    
        $product->condition = implode(',', $selectedConditions);
        
        // Handle availability field
        $selectedAvailabilities = $request->input('availability', []);
    
        if ($request->filled('custom_availability')) {
            $selectedAvailabilities[] = 'custom';
            $product->custom_availability = $request->input('custom_availability');
        }
    
        $product->availability = implode(',', $selectedAvailabilities);

        $product->rating = $request->input('rating');
        $product->expense = $request->input('expense');
        $product->features = $request->input('features');
        $product->quantity = $request->input('quantity');
        $product->buying = $request->input('buying');
        $product->selling = $request->input('selling');
        $product->discount = $request->input('discount');
        $product->total = $request->input('total');
        $product->profit = $request->input('profit');
        $product->alert_threshold = $request->input('alert_threshold');
        $product->custom_size = $request->input('custom_size');
        $product->custom_warranty = $request->input('custom_warranty');
        $product->custom_condition = $request->input('custom_condition');
        $product->custom_availability = $request->input('custom_availability');
        // Save the product
        $product->update();
    
        // Attach categories, subcategories, and sub-subcategories to the product
        $product->categories()->sync($request->input('category_ids'));
        $product->subcategories()->sync($request->input('subcategory_ids'));
        $product->subsubcategories()->sync($request->input('subsubcategory_ids'));
        $product->suppliers()->sync($request->input('supplier_ids'));
    
        return redirect()->route('products')->with('success', 'Product updated successfully');
     }

     public function delete_product($id)
     {
         $product = Product::find($id); 
         
         if (!$product) {
             return redirect()->route('products')->with('error', 'Product not found');
         }
 
         $product->delete();
 
         return redirect()->route('products')->with('success', 'Product deleted successfully');
     }
}
