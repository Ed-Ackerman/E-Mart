@extends('layouts.app-master') <!-- Make sure to use the appropriate layout -->

@section('content')
<div class="container">
    <legend>{{ __('Product Details') }}</legend>
    <div class="mt-2">
        @include('layouts.partials.messages')
    </div>
    <section class="show-product">
        <div class="product-header">
            <a href="{{ route('products') }}">
                <i class="fa fa-arrow-left"></i>
                <span class="back" >{{__(('Go Back'))}}</span>
            </a>
            {{__(('Product Info'))}}
        </div>
        <div class="product-sections">
            <div class="product-images">
                @if ($product->image)
                    @php
                        $imagePaths = explode(',', $product->image);
                    @endphp
            
                    @foreach ($imagePaths as $imagePath)
                        @if (!empty($imagePath))
                            <div class="product-img" style="background-image: url('{{ asset('/storage/images/admin/product/' . trim($imagePath)) }}');"></div>
                        @endif
                    @endforeach
                @endif
            </div>
            
           
            <div class="product-info">
                <div class="product-details-info">
                    <div class="info-name">{{__(('Product ID No.'))}}</div>
                    <span>{{ $product->id }}</span>
                </div>
                <div class="product-details-info">
                    <div class="info-name">{{__(('Name'))}}</div>
                    <span>{{ $product->name }}</span>
                </div>
                <div class="product-details-info">
                    <div class="info-name">{{__(('Code'))}}</div>
                    <span>{{ $product->code }}</span>
                </div>
                <div class="product-details-info">
                    <div class="info-name">{{__(('Description'))}}</div>
                    <span>{{ $product->description }}</span>
                </div>
                <div class="product-details-info">
                    <div class="info-name">{{__(('Unique Features'))}}</div>
                    <span>{{ $product->features }}</span>
                </div>
                <div class="product-details-info">
                    <div class="info-name">{{__(('Alert_Threshold'))}}</div>
                    <span>{{ $product->alert_threshold }}</span>
                </div>
                <div class="product-details-info">
                    <div class="info-name">{{__(('Status'))}}</div>
                    @if ($product->quantity == 0)
                        <span style="background-color: #ff0000; border-radius: 50px; padding: 3px 6px; color: #fff; width: 90%; text-align: center; ">{{__('Out of Stock')}}</span>
                    @elseif ($product->quantity <= $product->alert_threshold)
                        <span style="background-color: #ffdc17; border-radius: 50px; padding: 3px 6px; color: #000000; width: 90%; text-align: center;">{{__('Needs Reorder')}}</span>
                    @else
                        <span style="background-color: #00ff15; border-radius: 50px; padding: 3px 6px; color: #fff; width: 90%; text-align: center;">{{__('In Stock')}}</span>
                    @endif
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th scope="col">{{__(('Size'))}}</th>
                        <th scope="col">{{__(('Color'))}}</th>
                        <th scope="col">{{__(('Material'))}}</th>
                        <th scope="col">{{__(('Warranty'))}}</th>
                        <th scope="col">{{__(('Brand'))}}</th>
                        <th scope="col">{{__(('Weight'))}}</th>
                        <th scope="col">{{__(('Condition'))}}</th>
                        <th scope="col">{{__(('Availability'))}}</th>
                        <th scope="col">{{__(('Rating'))}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            @foreach(explode(',', $product->size) as $selectedSize)
                                {{ __($selectedSize) }}<br>
                            @endforeach    
                        </td>
                        <td>
                            <input type="color" value="{{  $product -> color }}" readonly>
                        </td>
                        <td>{{ $product -> material }}</td>
                        <td>
                            @foreach(explode(',', $product->warranty) as $selectedwarranty)
                                {{ __($selectedwarranty) }}<br>
                            @endforeach        
                        </td>
                        <td>{{ $product -> brand }}</td>
                        <td>{{ $product -> weight }}</td>
                        <td>
                            @foreach(explode(',', $product->condition) as $selectedcondition)
                                {{ __($selectedcondition) }}<br>
                            @endforeach  
                        </td>
                        <td>
                            @foreach(explode(',', $product->availability) as $selectedavailability)
                                {{ __($selectedavailability) }}<br>
                            @endforeach 
                        </td>
                        <td>{{ $product -> rating }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th scope="col">{{__(('Cust_Size'))}}</th>
                    <th scope="col">{{__(('Cust_Warranty'))}}</th>
                    <th scope="col">{{__(('Cust_Condition'))}}</th>
                    <th scope="col">{{__(('Cust_Availability'))}}</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    
                    <td>{{ $product -> custom_size }}</td>
                    <td>{{ $product -> custom_warranty }}</td>
                    <td>{{ $product -> custom_condition }}</td>
                    <td>{{ $product -> custom_availability }}</td>
                  </tr>
                </tbody>
            </table>
            </div>
            <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th scope="col">{{__(('Suppliers'))}}</th>
                    <th scope="col">{{__(('Categories'))}}</th>
                    <th scope="col">{{__(('Sub Categories'))}}</th>
                    <th scope="col">{{__(('Sub-SubCategories'))}}</th>
                  </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            @foreach($product->suppliers as $supplier)
                                {{ $supplier->name }}<br>
                            @endforeach
                        </td>
                        <td>
                            @foreach($product->categories as $category)
                                {{ $category->name }}<br>
                            @endforeach
                        </td>
                        <td>
                            @foreach($product->subcategories as $subcategory)
                                {{ $subcategory->name }}<br>
                            @endforeach
                        </td>
                        <td>
                            @foreach($product->subsubCategories as $subsubcategory)
                                {{ $subsubcategory->name }}<br>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            </div>
            <div class="product-info">
                <div class="product-details-info">
                    <div class="info-name">{{__(('Quantity'))}}</div>
                    <span>{{ $product->quantity }}</span>
                </div>
                <div class="product-details-info">
                    <div class="info-name">{{__(('Unit Buying Price'))}}</div>
                    <span>{{ $product->buying }}</span>
                </div>
                <div class="product-details-info">
                    <div class="info-name">{{__(('Expenses (Tax & Shipping)'))}}</div>
                    <span>{{ $product->expense }}</span>
                </div>
                <div class="product-details-info">
                    <div class="info-name">{{__(('Unit Selling Price'))}}</div>
                    <span>{{ $product->selling }}</span>
                </div>
                <div class="product-details-info" style="box-shadow: 0 1px 0 rgba(0, 0, 0, 0.1);">
                    <div class="info-name">{{__(('Discount Price'))}}</div>
                    <span>{{ $product->discount }}</span>
                </div>
                <div class="product-details-info">
                    <div class="info-name">{{__(('Total Cost'))}}</div>
                    <span>{{ $product->total }}</span>
                </div>
                <div class="product-details-info">
                    <div class="info-name">{{__(('Profit'))}}</div>
                    <span>{{ $product->profit }}</span>
                </div>

            </div>
        </div>
        <div class="info-action">
            <button class="action btn btn-warning" onclick="location.href='{{ route('edit.product', ['id' => $product->id]) }}'" >
                <i class="fas fa-edit"></i>
            </button>
            {!! Form::open([
                'method' => 'DELETE',
                'route' => ['delete.product', $product->id],
                'style' => 'display:inline',
                'onsubmit' => 'return confirm("Are you sure you want to delete this product?");'
            ]) !!}
            <button type="submit" class="action btn btn-danger">
                <i class="fas fa-trash"></i>
            </button>
            {!! Form::close() !!}
        </div>
    </section>

</div>
@endsection
