@extends('layouts.app-master') <!-- Make sure to use the appropriate layout -->

@section('content')
<legend>{{ __('Create Warehouse') }}</legend>
<div class="mt-2">
    @include('layouts.partials.messages')
</div>
<form class="form-product" method="POST" action="{{ route('store.warehouse') }}" enctype="multipart/form-data">
    @csrf
    <div class="form-product-header">
        <a href="{{ route('warehouse') }}">
            <i class="fa fa-arrow-left"></i>
            <span class="back">{{ __('Go Back') }}</span>
        </a>
        {{ __('Add Warehouse') }}
    </div>
    <section class="product-sections">
        <div class="product-sections-header">{{__(('Warehouse Infomation'))}}</div>
        <div class="product-details">
            <div class="product-details-group">
                <label for="name">{{__(('Warehouse Name *'))}}</label>
                <input id="name" type="text" class="@error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" placeholder="Enter Warehouse Name" autofocus>
                @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="product-details-group">
                <label for="code">{{__(('Warehouse Code *'))}}</label>
                <input type="text" id="code" class="@error('code') is-invalid @enderror" name="code" value="{{ old('code') }}" rows="1" placeholder="Enter Warehouse Code/Key If Any">
                @error('code')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="product-details">
            <div class="product-details-group">
                <label for="tel">{{__(('Warehouse Tel *'))}}</label>
                <input id="tel" type="text" class="@error('tel') is-invalid @enderror" name="tel" value="{{ old('tel') }}"  autocomplete="tel" placeholder="Enter Warehouse Phone No.">
                @error('tel')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="product-details-group">
                <label for="email">{{__(('Warehouse Email *'))}}</label>
                <input type="text" id="email" class="@error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" rows="1" placeholder="Enter Warehouse Email">
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="product-details-group">
                <label for="location">{{__(('Warehouse Location *'))}}</label>
                <input type="text" id="location" class="@error('location') is-invalid @enderror" name="location" value="{{ old('location') }}" rows="1" placeholder="Enter Warehouse location">
                @error('location')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
     
        <div class="product-details">

            <div class="product-details-group">
                <label for="name">{{__(('Warehouse Terms Of Usage *'))}}</label>
                <textarea id="terms" class="@error('terms') is-invalid @enderror" name="terms" rows="3" placeholder="Enter Warehouse Terms">{{ old('terms') }}</textarea>
                @error('terms')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

        </div>
    </section>
 
    <section class="product-sections">
        <div class="product-sections-header">{{__(('Payment & Rental Details'))}}</div>
        
        <div class="product-details">
            <div class="product-details-group dropdown-check-list-size" tabindex="100">
                <label for="method">{{__(('Payment Method *'))}}</label>
                <span class="anchor">{{__(('Select Payment Method'))}} <i class="fa fa-chevron-down arrow" style="float: right"></i></span>
                <div class="items">
                    <div class="item"><input type="checkbox" name="method[]" value="mobile_money" /> <div class="label">{{__('Mobile Money')}}</div></div>
                    <div class="item"><input type="checkbox" name="method[]" value="debit" /> <div class="label">{{__('Debit Cards')}}</div></div>
                    <div class="item"><input type="checkbox" name="method[]" value="credit" /> <div class="label">{{__('Credit Cards')}}</div></div>
                    <div class="item"><input type="checkbox" name="method[]" value="bank" /> <div class="label">{{__('Bank Transfers')}}</div></div>
                    <input type="text" name="custom_method" value="{{ old('custom_method') }}" placeholder="Insert Your Payment Method" />
                </div>
                @error('method.*')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            
           
        </div>
        <div class="product-details">
            <div class="product-details-group">
                <label for="name">{{__(('Payment Terms *'))}}</label>
                <textarea id="payment" class="@error('payment') is-invalid @enderror" name="payment" rows="3" placeholder="Enter Payment Terms">{{ old('payment') }}</textarea>
                @error('payment')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>         
    </section>
    <section class="product-sections">
        <div class="product-sections-header">{{__(('Warehouse Product *'))}}</div>
        <div class="product-details">
            <div class="product-details-group dropdown-check-list-categories unique-dropdown" tabindex="100">
                <label for="categories">{{__(('Categories Of Items *'))}}</label>
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
            <div class="product-details-group">
                <label for="capacity">{{__(('Warehouse Capacity *'))}}</label>
                <input type="text" id="capacity" class="@error('capacity') is-invalid @enderror" name="capacity" value="{{ old('capacity') }}" rows="1" placeholder="Enter Warehouse Storage Capacity">
                @error('capacity')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="product-details">
            <div class="product-details-group">
                <label for="products">{{__('Stored Products *')}}</label>
                <textarea id="products" class="@error('product') is-invalid @enderror" name="product" rows="3" placeholder="Enter Products">{{ old('product') }}</textarea>
                @error('product')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>   
        </div>        
    </section>

    

    <button type="submit">
        <i class="fa fa-check"></i>
        {{ __('Create Warehouse') }}
    </button>
</form>
@endsection
