@extends('layouts.app-master') <!-- Make sure to use the appropriate layout -->

@section('content')
<legend>{{ __('Create Product') }}</legend>
<div class="mt-2">
    @include('layouts.partials.messages')
</div>
<?php

function generateProductCode() {
    // Define a prefix for your product code
    $prefix = 'PROD';

    // Generate a unique code using timestamp and a random component
    $code = $prefix . '_' . time() . '_' . mt_rand(1000, 9999);

    return $code;
}
?>

<form class="form-product" action="{{ route('store.product') }}" enctype="multipart/form-data" method="POST" >
    @csrf
    <div class="form-product-header">
        <a href="{{ route('products') }}">
            <i class="fa fa-arrow-left"></i>
            <span class="back">{{ __('Go Back') }}</span>
        </a>
        {{ __('Add Product') }}
    </div>
    <section class="product-sections">
        <div class="product-sections-header">{{__(('Basic Infomation'))}}</div>
        <div class="product-details">
            <div class="product-details-group">
                <label for="name">{{__(('Product Name *'))}}</label>
                <input id="name" type="text" class="@error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" placeholder="Enter Product Name">
                @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="product-details-group">
                <label for="description">{{__(('Product Code *'))}}</label>
                <input type="text" id="description" class="@error('code') is-invalid @enderror" name="code" value="{{ generateProductCode() }}" rows="1" placeholder="Automatically Generated" readonly>
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
                <input type="file" name="image[]" id="image" class="image-input" multiple>
                <label for="image">
                    <li class="fas fa-upload"></li> 
                    {{__(('Upload'))}}
                </label>
                <img id="preview" class="preview" width="100" height="100" />
                @error('image')
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
                <textarea id="description" class="@error('description') is-invalid @enderror" name="description" rows="3" placeholder="Enter Product Description">{{ old('description') }}</textarea>
                @error('description')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

        </div>
        <div class="product-details">
            <div class="product-details-group dropdown-check-list-size" tabindex="100">
                <label for="name">{{__(('Size *'))}}</label>
                <span class="anchor">{{__(('Select Size'))}} <i class="fa fa-chevron-down arrow"  style="float: right"></i></span>
                <div class="items">
                  <div class="item"><input type="checkbox" name="size[]" value="small" /> <div class="label">{{__(('Small'))}}</div></div>
                  <div class="item"><input type="checkbox" name="size[]" value="medium" /> <div class="label">{{__(('Medium'))}}</div></div>
                  <div class="item"><input type="checkbox" name="size[]" value="large" /> <div class="label">{{__(('Large'))}}</div></div>
                  <div class="item"><input type="checkbox" name="size[]" value="XL" /> <div class="label">{{__(('XL'))}}</div></div>
                  <div class="item"><input type="checkbox" name="size[]" value="XXL" /> <div class="label">{{__(('XXL'))}}</div></div>
                  <div class="item"><input type="checkbox" name="size[]" value="XXXL" /> <div class="label">{{__(('XXXL'))}}</div></div>
                  <div class="item"><input type="checkbox" name="size[]" value="custom" /> <div class="label">{{__(('Custom'))}}</div></div>
                  <input type="text" name="custom_size" value="{{ old('custom_size') }}" placeholder="Insert Your Dimentions" />
                </div>
                @error('size.*')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="product-details-group">
                <label for="name">{{__(('Color *'))}}</label>
                <input type="color" name="color" value="{{ old('color') }}" placeholder="Product Color">
                @error('color')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="product-details-group">
                <label for="name">{{__(('Material *'))}}</label>
                <input type="text" name="material" value="{{ old('material') }}" placeholder="Product Material">
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
                    <div class="item"><input type="checkbox" name="warranty[]" value="1_year" /> <div class="label">{{__(('Within 1 Year'))}}</div></div>
                    <div class="item"><input type="checkbox" name="warranty[]" value="2_years" /> <div class="label">{{__(('Within 2 Years'))}}</div></div>
                    <div class="item"><input type="checkbox" name="warranty[]" value="3_years" /> <div class="label">{{__(('Within 3 Years'))}}</div></div>
                    <div class="item"><input type="checkbox" name="warranty[]" value="5_years" /> <div class="label">{{__(('Within 5 Years'))}}</div></div>
                    <div class="item"><input type="checkbox" name="warranty[]" value="lifetime" /> <div class="label">{{__(('Lifetime Warranty'))}}</div></div>
                    <input type="text" name="custom_warranty" value="{{ old('custom_warranty') }}"  placeholder="Insert Your Warranty Time" />
                </div>
                @error('warranty.*')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
    
            <div class="product-details-group">
                <label for="name">{{__(('Brand *'))}}</label>
                <input type="text" name="brand"  value="{{ old('brand') }}"  placeholder="Product Brand">
                @error('brand')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror              
            </div>

            <div class="product-details-group">
                <label for="name">{{__(('Weight *'))}}</label>
                <input type="text" name="weight" value="{{ old('weight') }}"  min="1" placeholder="Product Weight">
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
                    <div class="item"><input type="checkbox" name="condition[]" value="New" /> <div class="label">{{__(('New'))}}</div></div>
                    <div class="item"><input type="checkbox" name="condition[]" value="Used" /> <div class="label">{{__(('Used'))}}</div></div>
                    <div class="item"><input type="checkbox" name="condition[]" value="Refurbished" /> <div class="label">{{__(('Refurbished'))}}</div></div>
                    <input type="text" name="custom_condition" value="{{ old('custom_condition') }}"  placeholder="Insert Your Condition" />
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
                    <div class="item"><input type="checkbox" name="availability[]" value="in_stock" /> <div class="label">{{__(('In Stock'))}}</div></div>
                    <div class="item"><input type="checkbox" name="availability[]" value="out_of_stock" /> <div class="label">{{__(('Out Of Stock'))}}</div></div>
                    <div class="item"><input type="checkbox" name="availability[]" value="shipping" /> <div class="label">{{__(('Pending Shipment'))}}</div></div>
                    <input type="text" name="custom_availability" value="{{ old('custom_availability') }}"  placeholder="Insert Your Availablity" />
                </div>
                @error('availability.*')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
             
            <div class="product-details-group">
                <label for="name">{{__(('Star Ratings(0-5)*'))}}</label>
                <input type="text" name="rating" value="{{ old('rating') }}" max="5" placeholder="Enter Star Ratings(0-5)">
                @error('rating')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="product-details">
            <div class="product-details-group unique-dropdown" tabindex="100">
                <label for="categories">{{__(('Suppliers *'))}}</label>
                <span class="anchor">{{__(('Select Suppliers'))}} <i class="fa fa-chevron-down arrow" style="float: right"></i></span>
                <div class="items">
                    @foreach($suppliers as $supplier)
                    <div class="item">
                        <input type="checkbox" class="item" id="supplier_{{ $supplier->id }}" name="supplier_ids[]" value="{{ $supplier->id }}">
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
                <textarea id="features" class="@error('features') is-invalid @enderror" name="features" rows="3" placeholder="Enter Product Unique Features">{{ old('features') }}</textarea>
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
                <label for="categories">{{__(('Categories *'))}}</label>
                <span class="anchor">{{__(('Select Categories'))}} <i class="fa fa-chevron-down arrow" style="float: right"></i></span>
                <div class="items">
                    @foreach($categories as $category)
                    <div class="item">
                        <input type="checkbox" class="item" id="category_{{ $category->id }}" name="category_ids[]" value="{{ $category->id }}">
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
                        <input type="checkbox" class="item" id="subcategory_{{ $subcategory->id }}" name="subcategory_ids[]" value="{{ $subcategory->id }}">
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
                        <input type="checkbox" class="item" id="subsubcategory_{{ $subsubcategory->id }}" name="subsubcategory_ids[]" value="{{ $subsubcategory->id }}">
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
                <input id="quantity" type="text" class="number" name="quantity" value="{{ old('quantity') }}" required autocomplete="quantity" placeholder="Enter Quantity">
                @error('quantity')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="product-details-group">
                <label for="buying">{{__(('Unit Buying (UGX :) *'))}}</label>
                <input id="buying" type="text" class="number" name="buying" value="{{ old('buying') }}" required autocomplete="buying" placeholder="Enter Unit Buying Price">
                @error('buying')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="product-details-group">
                <label for="total">{{__(('Total (UGX :) *'))}}</label>
                <textarea id="total_cost" class="@error('total') is-invalid @enderror" name="total" rows="1" placeholder="Total" readonly>{{ old('total') }}</textarea>
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
                <input id="selling" type="text"  class="number" name="selling" value="{{ old('selling') }}" required autocomplete="selling" placeholder="Enter Selling">
                @error('selling')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="product-details-group">
                <label for="discount">{{__(('Discount Price (UGX :) *'))}}</label>
                <input id="discount" type="text"  class="number" name="discount" value="{{ old('discount') }}" autocomplete="discount" placeholder="Enter Unit Buying Price">
                @error('discount')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="product-details-group">
                <label for="profit">{{__(('Unit Profit (UGX :) *'))}}</label>
                <textarea id="profit" class="@error('profit') is-invalid @enderror" name="profit" rows="1" placeholder="Profit" style="border: 1px solid green;" readonly>{{ old('profit') }}</textarea>

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
                <input id="expense" type="text"  class="number" name="expense" value="{{ old('expense') }}" autocomplete="expense" placeholder="Enter Costs">
                @error('expense')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>   
            <div class="product-details-group">
                <label for="alert_threshold">{{__(('Alert Threshold *'))}}</label>
                <input id="alert_threshold" class="number" type="text" name="alert_threshold" value="{{ old('alert_threshold') }}" required autocomplete="alert_threshold" placeholder="Enter Alert_threshold">
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
        {{ __('Create Product') }}
    </button>
</form>

@endsection
