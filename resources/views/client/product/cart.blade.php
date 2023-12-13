@extends('layouts.app')

@section('content')
<div class="mt-2">
    @include('layouts.partials.messages')
</div>
<section class="cart">
    <div class="cart-product">
        <legend>{{__('Cart Items')}}</legend>
        @if ($cartItems->isNotEmpty())
            @foreach ($cartItems as $item)
                <div class="cart-items">
                    @php
                        $product = App\Models\Admin\ProductManagement\Product::find($item['product_id']); // Fetch the product details
                        if ($product && $product->image) {
                            $imagePaths = explode(',', $product->image);
                            $latestImagePath = end($imagePaths);
                        }
                    @endphp
    
                    @if (!empty($latestImagePath))
                        <div class="cart-img" style="background-image: url('{{ asset("storage/images/admin/product/{$latestImagePath}") }}')"></div>
                    @endif
    
                    <div class="cart-name">
                        @if ($product)
                            {{ $product->name }}
                            @for ($i = 0; $i < $product->rating; $i++)
                                <i class="fa fa-star" style="font-size: 15px; color: #ffb000;"></i>
                            @endfor
                            @for ($i = $product->rating; $i < 5; $i++)
                                <i class="far fa-star" style="font-size: 15px; color: #ffb000;"></i>
                            @endfor
                        @else
                            Product Not Found
                        @endif
                    </div>
                    <div class="cart-qty">
                        <input type="number" name="quantity" min="1" value="{{ $item['quantity'] }}" class="quantity-input" data-product-id="{{ $item['product_id'] }}">
                    </div>
    
                    <div class="cart-price">
                        <div class="pricing">{{ __('Each @ :price', ['price' => $product ? 'UGX: ' . $product->selling : 'Price Not Found']) }}</div>
                        <div class="total-price-{{ $item['product_id'] }}" style="font-weight: 600;">
                            @php
                                $productPrice = $product ? str_replace(',', '', $product->selling) : 'Price Not Found';
                                $quantity = str_replace(',', '', $item['quantity']);
                                $totalPrice = 'Price Not Found';
    
                                // Check if both price and quantity are in the expected format (numeric strings)
                                if (is_numeric($productPrice) && is_numeric($quantity)) {
                                    $totalPrice = 'UGX: ' . number_format(floatval($productPrice) * intval($quantity), 0);
                                }
                            @endphp
                            {{ __('Total -> :price', ['price' => $totalPrice]) }}
                        </div>
                    </div>
                    <a href="{{ route('view.product', ['id' => $item['product_id']]) }}"
                        class="cart-action btn"
                        style="margin: 5px; color: #fff; background-color:#0000ff;">
                         <i class="fa fa-eye"></i>
                    </a>
                    <a href="{{ route('remove.from.cart', ['id' => $item['product_id']]) }}"
                        class="cart-action btn btn-danger"
                        style="margin: 5px;"
                        onclick="return confirm('Are you sure you want to delete this item from the cart?');">
                         <i class="fas fa-trash"></i>
                     </a>
                    
                </div>
            @endforeach
        @else
            <legend style="text-align: center;">Your cart is empty.</legend>
        @endif
        <div class="cart-procedure">
            <a href="javascript:history.go(-2)" class="shop">
                <i class="fa fa-shopping-cart"></i>{{__('Back to Shopping')}}
            </a>            
            <a href="{{ route('check.out') }}" class="payment">
                {{__('Check Out')}}<i class="fa fa-check"></i>
            </a>
        </div>
    </div>

    <div class="cart-card">
        <div class="cart-card-header">{{__('Summary')}}</div>
        <div class="cart-card-items">
            <div class="card-item" style="font-weight: 600;">{{__('Total Quantity')}}</div>
            <div class="card-value" style="font-weight: 600;"></div>
        </div>
        <div class="cart-card-items">
            <div class="card-item" style="font-weight: 600;">{{__('Total Price')}}</div>
            <div class="card-value" style="font-weight: 600;"></div>
        </div>
        <hr>
        <a href="{{ route('check.out') }}" class="card-pay">{{__('Check Out')}}<i class="fa fa-check" ></i></a>
    </div>
</section>
@endsection

@section('custom-scripts')

<script>
   function updateSubtotal() {
    var quantityInput = $(this);
    var quantity = parseFloat(quantityInput.val().replace(/,/g, ''));

    var cartItem = quantityInput.closest('.cart-items');
    var priceElement = cartItem.find('.cart-price .pricing');
    var totalElement = cartItem.find('.total-price-' + quantityInput.data('product-id'));

    var priceText = priceElement.text();
    var priceNumber = parseFloat(priceText.replace(/[^0-9.]/g, ''));

    if (!isNaN(quantity) && !isNaN(priceNumber)) {
      var newTotalPrice = quantity * priceNumber;
      totalElement.text("Total -> UGX: " + newTotalPrice.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ','));
    } else {
      totalElement.text("Total -> UGX: Price Not Found");
    }
  }

  $(document).ready(function() {
    var quantityInputs = $('.quantity-input');
    quantityInputs.each(function() {
      updateSubtotal.call(this);
    });

    quantityInputs.on('input', updateSubtotal);
  });
    // card
    function updateSubtotal() {
        var quantityInput = $(this);
        var quantity = parseFloat(quantityInput.val().replace(/,/g, ''));

        var cartItem = quantityInput.closest('.cart-items');
        var priceElement = cartItem.find('.cart-price .pricing');
        var totalElement = cartItem.find('.total-price-' + quantityInput.data('product-id'));

        var priceText = priceElement.text();
        var priceNumber = parseFloat(priceText.replace(/[^0-9.]/g, ''));

        if (!isNaN(quantity) && !isNaN(priceNumber)) {
        var newTotalPrice = quantity * priceNumber;
        totalElement.text("Total -> UGX: " + newTotalPrice.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ','));
        } else {
        totalElement.text("Total -> UGX: Price Not Found");
        }

        // Calculate total quantity and final total price
        updateSummaryCard();
    }

  function updateSummaryCard() {
    var totalItems = 0;
    var totalPrice = 0;

    $('.cart-items').each(function() {
      var newQuantity = parseFloat($(this).find('.quantity-input').val().replace(/,/g, ''));
      var productPrice = parseFloat($(this).find('.cart-price .pricing').text().replace(/[^0-9.]/g, ''));

      if (!isNaN(newQuantity) && !isNaN(productPrice)) {
        totalItems += newQuantity;
        totalPrice += newQuantity * productPrice;
      }
    });

    $('.card-value').eq(0).text(totalItems + " Items");
    $('.card-value').eq(1).text("UGX: " + totalPrice.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ','));
  }

  $(document).ready(function() {
    var quantityInputs = $('.quantity-input');
    quantityInputs.each(function() {
      updateSubtotal.call(this);
    });

    quantityInputs.on('input', updateSubtotal);
  });
</script>

@endsection