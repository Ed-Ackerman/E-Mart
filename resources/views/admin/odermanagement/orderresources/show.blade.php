@extends('layouts.app-master')

@section('content')
<legend>{{ __('Orders Details') }}</legend>
<div class="mt-2">
    @include('layouts.partials.messages')
</div>

<section class="orders">
    <div class="form-product-header" style="width:100%;">
        <a href="{{ route('proccessing') }}">
            <i class="fa fa-arrow-left"></i>
            <span class="back">{{ __('Go Back') }}</span>
        </a>
        {{ __('Order Information') }}
    </div>
    @if ($order)
        @php
        $cartItems = json_decode($order->cart_items);
        @endphp

        @if (!empty($cartItems))
            @foreach ($cartItems as $cartItem)
                @php
                $product = App\Models\Admin\ProductManagement\Product::find($cartItem->product_id);
                if ($product && $product->image) {
                    $imagePaths = explode(',', $product->image);
                    $latestImagePath = end($imagePaths);
                }
                @endphp
                <div class="order">
                    @if (!empty($latestImagePath))
                        <div class="order-img" style="background-image: url('{{ asset("storage/images/admin/product/{$latestImagePath}") }}')"></div>
                    @endif
                    <div class="order-details">
                        <div class="order-name">{{ $product->name }}</div>
                        <div class="order-rating">
                            @for ($i = 0; $i < $product->rating; $i++)
                                <i class="fa fa-star" style="font-size: 15px; color: #ffb000;"></i>
                            @endfor
                            @for ($i = $product->rating; $i < 5; $i++)
                                <i class="far fa-star" style="font-size: 15px; color: #ffb000;"></i>
                            @endfor
                        </div>
                        <div class="order-feature">{{ $product->features }}</div>
                    </div>
                    <div class="order-description">{{ $product->description }}</div>
                    <div class="order-pricing">
                        <div class="order-price">
                            {{ __('UGX: :price', ['price' => $product->selling]) }}
                        </div>
                        <div class="order-qty">
                            {{ __('Qty: :quantity', ['quantity' => $cartItem->quantity]) }}
                        </div>
                        <div class="order-total">
                        </div>
                    </div>
                    
                </div>
            @endforeach
        @endif
        <div class="custom-total">
            <span class="label">{{__('Total : ')}}</span>
            <span class="value">UGX </span>
        </div>
        <div class="delivery-info">
            <div class="delivery">
                <div class="deliver" id="deliver">{{__('ID No.')}}</div>
                <div class="deliver">{{ $order->id }}</div>
            </div>
            <div class="delivery">
                <div class="deliver" id="deliver">{{__('Name.')}}</div>
                <div class="deliver">{{ $order->name }}</div>
            </div>
            <div class="delivery">
                <div class="deliver" id="deliver">{{__('Tel.')}}</div>
                <div class="deliver">
                    <div class="deliver"> {{ $order->tel_1 }}</div>
                    <div class="deliver">{{ $order->tel_2 }}</div> 
                </div>
           </div>
            <div class="delivery">
                <div class="deliver" id="deliver">{{__('City.')}}</div>
                <div class="deliver">{{ $order->city }}</div>
            </div>
            <div class="delivery">
                <div class="deliver" id="deliver">{{__('Address.')}}</div>
                <div class="deliver">{{ $order->address }}</div>
            </div>
            <div class="delivery">
                <div class="deliver" id="deliver">{{__('Shipping Fee.')}}</div>
                <div class="deliver">{{ $order->shipping_fee }}</div>
            </div>
            <div class="delivery">
                <div class="deliver" id="deliver">{{__('Payment.')}}</div>
                <div class="deliver">{{ $order->payment_method }}</div>
            </div>
            <div class="delivery">
                <div class="deliver" id="deliver">{{__('Order Status.')}}</div>
                <div class="deliver">
                    <div class="span {{ $order->order_status === 'fulfilled' ? 'fulfilled-status' : 'pending-status' }}">{{ $order->order_status }}</div>
                </div>
            </div>            
            <div class="delivery" style="background-color: #f6f6f6">
                <div class="deliver" id="deliver">{{__('Order Status Update.')}}</div>
                <form method="post" action="{{ route('update.order.status', $order->id) }}" class="deliver-form">
                    @csrf
                    @method('PATCH')
                    <select name="order_status" id="order_status" class="form-control">
                        <option value="" selected disabled>{{ __('Set Status') }}</option>
                        <option value="pending" {{ $order->order_status === 'pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                        <option value="fulfilled" {{ $order->order_status === 'fulfilled' ? 'selected' : '' }}>{{ __('Fulfilled') }}</option>
                        <option value="canceled" {{ $order->order_status === 'canceled' ? 'selected' : '' }}>{{ __('Canceled') }}</option>
                    </select>
                    <button type="submit" class="btn btn-primary" style="width: 100%;  margin: 10px;">{{__('Update Order Status')}}</button>
                </form>
            </div>
            
        </div>
    @else
        <p>No order found for this user.</p>
    @endif
</section>

@endsection
@section('custom-scripts')
<script>
    $(document).ready(function() {
        // Initialize the overall total
        var overallTotal = 0;

        // Iterate over each order item
        $('.order-price').each(function(index) {
            // Get the selling price and quantity
            var sellingPriceStr = $(this).text(); // Get the text from the element
            var quantityStr = $('.order-qty').eq(index).text(); // Get the text from the corresponding quantity element

            // Remove commas and convert to numeric values
            var sellingPrice = parseFloat(sellingPriceStr.replace(/,/g, '').replace('UGX:', '')) || 0;
            var quantity = parseFloat(quantityStr.replace('Qty:', '')) || 0;

            // Calculate the total for the current item
            var total = sellingPrice * quantity;

            // Add the total for the current item to the overall total
            overallTotal += total;

            // Format the total as currency with commas and 'UGX' as the currency symbol
            var formattedTotal = total.toLocaleString('en-US', {
                style: 'currency',
                currency: 'UGX'
            });

            // Display the formatted total for the current item
            $('.order-total').eq(index).text(formattedTotal);
        });

        // Format the overall total as currency with commas and 'UGX' as the currency symbol
        var formattedOverallTotal = overallTotal.toLocaleString('en-US', {
            style: 'currency',
            currency: 'UGX'
        });

        // Display the formatted overall total
        $('.custom-total .value').text(formattedOverallTotal);
    });

</script>

@endsection