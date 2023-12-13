@extends('layouts.app-master')

@section('content')
<legend>{{ __('Custom Orders Details') }}</legend>
<div class="mt-2">
    @include('layouts.partials.messages')
</div>

<section class="orders">
    <div class="form-product-header" style="width:100%;">
        <a href="{{ route('custom') }}">
            <i class="fa fa-arrow-left"></i>
            <span class="back">{{ __('Go Back') }}</span>
        </a>
        {{ __('Custm Order Information') }}
    </div>

    <div class="custom-products">
        <?php $totalSum = 0; ?>
        @foreach(json_decode($order->custom_order) as $item)
            <div class="custom-profile">
                <div class="custom-img" style="background-image: url('{{ asset('storage/images/admin/custom/' . $item->custom_img) }}');">
                    @if (!$item->custom_img)
                        <p>No Image</p>
                    @endif
                </div>                
                <div class="custom-name">{{ $item->custom_name }}</div>
                <div class="custom-description">{{ $item->custom_description }}</div>
                <div class="custom-qty"> QTY :{{ $item->custom_qty }}</div>
                <div class="custom-price"> {{ __('UGX: :price', ['price' => $item->custom_price]) }}</div>
                <div class="custom-total"> {{ __('UGX: :total', ['total' => $item->custom_total]) }}</div>
                @php
                // Remove commas from the current item's total and add it to the sum
                $totalSum = number_format((float) str_replace(',', '', $totalSum) + (float) str_replace(',', '', $item->custom_total), 2);
            @endphp
            </div>
        @endforeach
        <div class="custom-total">
            <span class="label">{{__('Total : ')}}</span>
            <span class="value">UGX {{ $totalSum }}</span>
        </div>
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
            <form method="post" action="{{ route('update.custom.status', $order->id) }}" class="deliver-form">
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
</section>

@endsection
@section('custom-scripts')
<script>
    $(document).ready(function() {
        $('.order-price').each(function(index) {
            // Get the selling price and quantity
            var sellingPriceStr = $(this).text(); // Get the text from the element
            var quantityStr = $('.order-qty').eq(index).text(); // Get the text from the corresponding quantity element

            // Remove commas and convert to numeric values
            var sellingPrice = parseFloat(sellingPriceStr.replace(/,/g, '').replace('UGX:', '')) || 0;
            var quantity = parseFloat(quantityStr.replace('Qty:', '')) || 0;

            // Calculate the total
            var total = sellingPrice * quantity;

            // Format the total as currency with commas and 'UGX' as the currency symbol
            var formattedTotal = total.toLocaleString('en-US', {
                style: 'currency',
                currency: 'UGX'
            });

            // Display the formatted total
            $('.order-total').eq(index).text(formattedTotal);
        });
    });
</script>

@endsection