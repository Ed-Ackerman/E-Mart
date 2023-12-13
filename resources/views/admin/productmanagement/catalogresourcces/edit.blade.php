@extends('layouts.app-master') <!-- Make sure to use the appropriate layout -->

@section('content')
<legend>{{ __('Update Product') }}</legend>
<div class="mt-2">
    @include('layouts.partials.messages')
</div>
<form class="form-product" method="POST" action="{{ route('update.product', ['id' => $product->id]) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="form-product-header">
        <a href="{{ route('products') }}">
            <i class="fa fa-arrow-left"></i>
            <span class="back">{{ __('Go Back') }}</span>
        </a>
        {{ __('Edit Product') }}
    </div>
    <section class="product-sections">
        <div class="product-sections-header">{{__(('Basic Infomation'))}}</div>
        <div class="product-details">
            <div class="product-details-group">
                <label for="name">{{__(('Product Name *'))}}</label>
                <input id="name" type="text" class="@error('name') is-invalid @enderror" name="name" value="{{ old('name', $product -> name) }}" required autocomplete="name" placeholder="Enter Product Name" autofocus>
                @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="product-details-group">
                <label for="description">{{__(('Product Code *'))}}</label>
                <input type="text" id="description" class="@error('code') is-invalid @enderror" name="code" value="{{ old('name', $product -> code) }}" placeholder="Enter Product Code/Key If Any">
                @error('code')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
    </section>
    <section class="product-sections">
        <div class="product-sections-header">{{__(('Product Images *'))}}</div>
        <div class="product-details images">
            <div class="product-details-group image-input-container" id="img">
                <label for="image">{{__('Images')}}</label>
                <input type="file" name="images[]" id="images" class="image-input" multiple>
                <label for="images">
                    <i class="fas fa-upload"></i>
                    {{__('Upload')}}
                </label>
        
                @if ($product->image)
                    @php
                        $imagePaths = explode(',', $product->image);
                    @endphp
                    @foreach ($imagePaths as $imagePath)
                        <img class="preview" src="{{ asset('/storage/images/admin/product/' . trim($imagePath)) }}"/>
                    @endforeach
                @endif
            

                @error('images.*')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
           <div class="product-details-action-btn">
                <a href="#" class="add-field" type="button">
                    <li class="fa fa-plus"></li>
                </a>
                <a href="#" class="remove-field" type="button">
                    <li class="fa fa-minus"></li>
                </a>
            </div>
        </div>
        
    </section>
    <section class="product-sections">
        <div class="product-sections-header">{{__(('Product Details'))}}</div>
        <div class="product-details">

            <div class="product-details-group">
                <label for="name">{{__(('Product Description *'))}}</label>
                <textarea id="description" class="@error('description') is-invalid @enderror" name="description" rows="3" placeholder="Enter Product Description">{{ old('description', $product -> description) }}</textarea>
                @error('description')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

        </div>
        <div class="product-details">
            <div class="product-details-group dropdown-check-list-size" tabindex="100">
                <label for="name">{{ __('Size *') }}</label>
                <span class="anchor">{{ __('Select Size') }} <i class="fa fa-chevron-down arrow" style="float: right"></i></span>
                <div class="items">
                    <div class="item">
                        <input type="checkbox" name="size[]" value="small" {{ in_array('small', old('size', explode(',', $product->size))) ? 'checked' : '' }} />
                        <div class="label">{{ __('Small') }}</div>
                    </div>
                    <div class="item">
                        <input type="checkbox" name="size[]" value="medium" {{ in_array('medium', old('size', explode(',', $product->size))) ? 'checked' : '' }} />
                        <div class="label">{{ __('Medium') }}</div>
                    </div>
                    <div class="item">
                        <input type="checkbox" name="size[]" value="large" {{ in_array('large', old('size', explode(',', $product->size))) ? 'checked' : '' }} />
                        <div class="label">{{ __('Large') }}</div>
                    </div>
                    <div class="item">
                        <input type="checkbox" name="size[]" value="XL" {{ in_array('XL', old('size', explode(',', $product->size))) ? 'checked' : '' }} />
                        <div class="label">{{ __('XL') }}</div>
                    </div>
                    <div class="item">
                        <input type="checkbox" name="size[]" value="XXL" {{ in_array('XXL', old('size', explode(',', $product->size))) ? 'checked' : '' }} />
                        <div class="label">{{ __('XXL') }}</div>
                    </div>
                    <div class="item">
                        <input type="checkbox" name="size[]" value="XXXL" {{ in_array('XXXL', old('size', explode(',', $product->size))) ? 'checked' : '' }} />
                        <div class="label">{{ __('XXXL') }}</div>
                    </div>
                    <div class="item">
                        <input type="checkbox" name="size[]" value="custom" {{ in_array('custom', old('size', explode(',', $product->size))) ? 'checked' : '' }} />
                        <div class="label">{{ __('Custom') }}</div>
                    </div>
                    <input type="text" name="custom_size" value="{{ old('custom_size', $product -> custom_size) }}" placeholder="Insert Your Dimentio" />
                </div>
                @error('size.*')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            

            <div class="product-details-group">
                <label for="name">{{__(('Color *'))}}</label>
                <input type="color" name="color" value="{{ old('color', $product -> color) }}" placeholder="Product Color">
                @error('color')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="product-details-group">
                <label for="name">{{__(('Material *'))}}</label>
                <input type="text" name="material" value="{{ old('material', $product -> material) }}" placeholder="Product Material">
                @error('material')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="product-details">
            <div class="product-details-group dropdown-check-list-warranty" tabindex="100">
                <label for="warranty">{{__(('Warranty *'))}}</label>
                <span class="anchor">{{__(('Select Warranty'))}} <i class="fa fa-chevron-down arrow" style="float: right"></i></span>
                <div class="items">
                    <div class="item"><input type="checkbox" name="warranty[]" value="1_year" {{ in_array('1_year', old('warranty', explode(',', $product->warranty))) ? 'checked' : '' }} /> <div class="label">{{__(('Within 1 Year'))}}</div></div>
                    <div class="item"><input type="checkbox" name="warranty[]" value="2_years" {{ in_array('2_years', old('warranty', explode(',', $product->warranty))) ? 'checked' : '' }} /> <div class="label">{{__(('Within 2 Years'))}}</div></div>
                    <div class="item"><input type="checkbox" name="warranty[]" value="3_years" {{ in_array('3_years', old('warranty', explode(',', $product->warranty))) ? 'checked' : '' }} /> <div class="label">{{__(('Within 3 Years'))}}</div></div>
                    <div class="item"><input type="checkbox" name="warranty[]" value="5_years" {{ in_array('5_years', old('warranty', explode(',', $product->warranty))) ? 'checked' : '' }} /> <div class="label">{{__(('Within 5 Years'))}}</div></div>
                    <div class="item"><input type="checkbox" name="warranty[]" value="lifetime" {{ in_array('lifetime', old('warranty', explode(',', $product->warranty))) ? 'checked' : '' }} /> <div class="label">{{__(('Lifetime Warranty'))}}</div></div>
                    <input type="text" name="custom_warranty"  value="{{ old('custom_warranty', $product -> custom_warranty) }}" placeholder="Insert Your Warranty Timeli" />
                </div>
                @error('warranty.*')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
    
            <div class="product-details-group">
                <label for="name">{{__(('Brand *'))}}</label>
                <input type="text" name="brand" value="{{ old('brand', $product -> brand) }}" placeholder="Product Brand">
                @error('brand')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror              
            </div>

            <div class="product-details-group">
                <label for="name">{{__(('Weight *'))}}</label>
                <input type="number" name="weight" min="1"  value="{{ old('weight', $product -> weight) }}"  placeholder="Product Weight">
                @error('weight')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror     
            </div>
            
        </div>
        <div class="product-details">
            <div class="product-details-group dropdown-check-list-condition" tabindex="100">
                <label for="condition">{{__(('Condition *'))}}</label>
                <span class="anchor">{{__(('Select Condition'))}} <i class="fa fa-chevron-down arrow" style="float: right"></i></span>
                <div class="items">
                    <div class="item"><input type="checkbox" name="condition[]" value="New"{{ in_array('New', old('condition', explode(',', $product->condition))) ? 'checked' : '' }} /> <div class="label">{{__(('New'))}}</div></div>
                    <div class="item"><input type="checkbox" name="condition[]" value="Used"{{ in_array('Used', old('condition', explode(',', $product->condition))) ? 'checked' : '' }} /> <div class="label">{{__(('Used'))}}</div></div>
                    <div class="item"><input type="checkbox" name="condition[]" value="Refurbished"{{ in_array('Refurbished', old('condition', explode(',', $product->condition))) ? 'checked' : '' }} /> <div class="label">{{__(('Refurbished'))}}</div></div>
                    <input type="text" name="custom_condition" value="{{ old('custom_condition', $product -> custom_condition) }}" placeholder="Insert Your Condition" />
                </div>
                @error('condition.*')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        
            <div class="product-details-group dropdown-check-list-availability" tabindex="100">
                <label for="availability">{{__(('Availablity *'))}}</label>
                <span class="anchor">{{__(('Select Availablity'))}} <i class="fa fa-chevron-down arrow" style="float: right"></i></span>
                <div class="items">
                    <div class="item"><input type="checkbox" name="availability[]" value="in_stock"{{ in_array('in_stock', old('availability', explode(',', $product->availability))) ? 'checked' : '' }}  /> <div class="label">{{__(('In Stock'))}}</div></div>
                    <div class="item"><input type="checkbox" name="availability[]" value="out_of_stock"{{ in_array('out_of_stock', old('availability', explode(',', $product->availability))) ? 'checked' : '' }}  /> <div class="label">{{__(('Out Of Stock'))}}</div></div>
                    <div class="item"><input type="checkbox" name="availability[]" value="shipping"{{ in_array('shipping', old('availability', explode(',', $product->availability))) ? 'checked' : '' }}  /> <div class="label">{{__(('Pending Shipment'))}}</div></div>
                    <input type="text" name="custom_availability" value="{{ old('custom_availability', $product -> custom_availability) }}" placeholder="Insert Your Availablity" />
                </div>
                @error('availability.*')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
             
            <div class="product-details-group">
                <label for="name">{{__(('Star Ratings(0-5)*'))}}</label>
                <input type="number" name="rating" value="{{ old('rating', $product -> rating) }}" max="5"   placeholder="Enter Star Ratings(0-5)">
                @error('rating')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="product-details">
            <div class="product-details-group unique-dropdown" tabindex="100">
                <label for="suppliers">{{ __('Suppliers *') }}</label>
                <span class="anchor">{{ __('Select Suppliers') }} <i class="fa fa-chevron-down arrow" style="float: right"></i></span>
                <div class="items">
                    @foreach ($suppliers as $supplier)
                    <div class="item">
                        <input type="checkbox" class="item" id="supplier_{{ $supplier->id }}" name="supplier_ids[]" value="{{ $supplier->id }}"
                        {{ in_array($supplier->id, old('supplier_ids', $product->suppliers->pluck('id')->toArray())) ? 'checked' : '' }}>
                        <label class="label" for="supplier_{{ $supplier->id }}">{{ $supplier->name }}</label>
                    </div>
                    @endforeach
                </div>
                @error('supplier_ids')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="product-details">
            <div class="product-details-group">
                <label for="name">{{__(('Product Unique Features *'))}}</label>
                <textarea id="features" class="@error('features') is-invalid @enderror" name="features" rows="3" placeholder="Enter Product Unique Features">{{ old('features' , $product -> features) }}</textarea>
                @error('features')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
    </section>
    <section class="product-sections">
        <div class="product-sections-header">{{__(('Product Category *'))}}</div>
        <div class="product-details">
            <div class="product-details-group dropdown-check-list-categories" tabindex="100">
                <label for="category_ids">{{ __('Categories *') }}</label>
                <span class="anchor">{{ __('Select Categories') }} <i class="fa fa-chevron-down arrow" style="float: right"></i></span>
                <div class="items">
                    @foreach($categories as $category)
                    <div class="item">
                        <input type="checkbox" class="item" id="category_{{ $category->id }}" name="category_ids[]" value="{{ $category->id }}" 
                               {{ in_array($category->id, old('category_ids', $product->categories->pluck('id')->toArray())) ? 'checked' : '' }}>
                        <label class="label" for="category_{{ $category->id }}">{{ $category->name }}</label>
                    </div>
                    @endforeach
                </div>
                @error('category_ids')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
                     
            <div class="product-details-group dropdown-check-list-subcategories" tabindex="100">
                <label for="categories">{{__(('Sub Categories *'))}}</label>
                <span class="anchor">{{__(('Select Sub Categories'))}} <i class="fa fa-chevron-down arrow" style="float: right"></i></span>
                <div class="items">
                    @foreach($subcategories as $subcategory)
                    <div class="item">
                        <input type="checkbox" class="item" id="subcategory_{{ $subcategory->id }}" name="subcategory_ids[]" value="{{ $subcategory->id }}"
                        {{ in_array($subcategory->id, old('subcategory_ids', $product->subcategories->pluck('id')->toArray())) ? 'checked' : '' }}/>
                        <label class="label" for="subcategory_{{ $subcategory->id }}">{{ $subcategory->name }}</label>
                    </div>
                    @endforeach
                </div>
                @error('subcategory_ids')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>                      
            <div class="product-details-group dropdown-check-list-subsubcategories" tabindex="100">
                <label for="categories">{{__(('Sub-SubCategories *'))}}</label>
                <span class="anchor">{{__(('Select Sub-SubCategories'))}} <i class="fa fa-chevron-down arrow" style="float: right"></i></span>
                <div class="items">
                    @foreach($subsubcategories as $subsubcategory)
                    <div class="item">
                        <input type="checkbox" class="item" id="subsubcategory_{{ $subsubcategory->id }}" name="subsubcategory_ids[]" value="{{ $subsubcategory->id }}"
                        {{ in_array($subsubcategory->id, old('subsubcategory_ids', $product->subsubcategories->pluck('id')->toArray())) ? 'checked' : '' }}/>
                        <label class="label" for="subsubcategory_{{ $subsubcategory->id }}">{{ $subsubcategory->name }}</label>
                    </div>
                    @endforeach
                </div>
                @error('subsubcategory_ids')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>                      
        </div>
    </section>

    <section class="product-sections">
        <div class="product-sections-header">{{__(('Product Pricing *'))}}</div>
        <div class="product-details">
            <div class="product-details-group">
                <label for="quantity">{{__(('Quantity *'))}}</label>
                <input id="quantity" type="text" class="number" name="quantity" value="{{ old('quantity', $product -> quantity) }}" required autocomplete="quantity" placeholder="Enter Quantity">
                @error('quantity')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="product-details-group">
                <label for="buying">{{__(('Unit Buying (UGX :) *'))}}</label>
                <input id="buying" type="text" class="number" name="buying" value="{{ old('buying', $product -> buying) }}" required autocomplete="buying" placeholder="Enter Unit Buying Price">
                @error('buying')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="product-details-group">
                <label for="total">{{__(('Total (UGX :) *'))}}</label>
                <textarea id="total_cost" class="@error('total') is-invalid @enderror" name="total" rows="1" placeholder="Total" readonly>{{ old('total', $product -> total) }}</textarea>
                @error('total')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="product-details">
            <div class="product-details-group">
                <label for="selling">{{__(('Unit Selling (UGX :) *'))}}</label>
                <input id="selling" type="text"  class="number" name="selling" value="{{ old('selling', $product -> selling) }}" required autocomplete="selling" placeholder="Enter Selling">
                @error('selling')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="product-details-group">
                <label for="discount">{{__(('Discount Price (UGX :) *'))}}</label>
                <input id="discount" type="text"  class="number" name="discount" value="{{ old('discount', $product -> discount) }}" autocomplete="discount" placeholder="Enter Unit Buying Price">
                @error('discount')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="product-details-group">
                <label for="profit">{{__(('Unit Profit (UGX :) *'))}}</label>
                <textarea id="profit" class="@error('profit') is-invalid @enderror" name="profit" rows="1" placeholder="Profit" style="border: 1px solid green;" readonly>{{ old('profit', $product -> profit) }}</textarea>

                @error('profit')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="product-details">
           
            <div class="product-details-group">
                <label for="expense">{{__(('Expenses (Tax & Shipping) (UGX :) *'))}}</label>
                <input id="expense" type="text"  class="number" name="expense" value="{{ old('expense', $product -> expense) }}" autocomplete="expense" placeholder="Enter Costs">
                @error('expense')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>   
            <div class="product-details-group">
                <label for="alert_threshold">{{__(('Alert Threshold *'))}}</label>
                <input id="alert_threshold" type="text" class="number" name="alert_threshold" value="{{ old('alert_threshold', $product -> alert_threshold) }}" required autocomplete="alert_threshold" placeholder="Enter Alert_threshold">
                @error('alert_threshold')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
    </section>

    <button type="submit">
        <i class="fa fa-check"></i>
        {{ __('Update Product') }}
    </button>
</form>
@endsection
