@extends('layouts.app')

@section('content')
<div class="mt-2">
    @include('layouts.partials.messages')
</div>
<section class="cart">
    <form class="cart-product" action="{{ route('add.cart.or.add.wishlist') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <legend>{{__('Wish List Items')}}</legend>
        
        @if ($wishlistItems->isNotEmpty())
        @foreach ($wishlistItems as $item)
            
                <div class="wish-items">
                    @php
                      $product = App\Models\Admin\ProductManagement\Product::find($item['product_id']);
                        if ($product && $product->image) {
                            $imagePaths = explode(',', $product->image);
                            $latestImagePath = end($imagePaths);
                        }
                    @endphp
                    <input type="hidden" name="productId" value="{{ $product->id }}">
                    @if (!empty($latestImagePath))
                        <div class="cart-img" style="background-image: url('{{ asset("storage/images/admin/product/{$latestImagePath}") }}')"></div>
                    @endif
    
                    <div class="cart-name">
                        {{ $product ? $product->name : 'Product Not Found' }}
                        @for ($i = 0; $i < $product->rating; $i++)
                            <i class="fa fa-star" style="font-size: 15px; color: #ffb000;"></i>
                        @endfor
                        @for ($i = $product->rating; $i < 5; $i++)
                            <i class="far fa-star" style="font-size: 15px; color: #ffb000;"></i>
                        @endfor
                    </div>

                    <div class="cart-name">
                        {{ $product ? $product->features : 'Product Not Found' }}
                    </div>

                    <div class="wish-qty">
                        <input type="number" name="quantity" min="1" value="{{ $item['quantity'] }}" class="quantity-input" data-product-id="{{ $item['product_id'] }}">
                    </div>
                   
    
                    <div class="cart-price">
                        <div class="pricing">{{ __('Each @ :price', ['price' => $product ? 'UGX: ' . $product->selling : 'Price Not Found']) }}</div>
                    </div>
                    <div class="wish-btn">
                        <button type="submit" class="cart-action" name="action" value="cart"
                        style=" 
                        background-color: #ff6600;
                        border: none;
                        outline: none;
                        border-radius: 6px;
                        color: #fff;
                        margin: 5px;">
                            <i class="fas fa-shopping-cart"></i>
                        </button>
                        <a href="{{ route('view.product', ['id' => $item['product_id']]) }}"
                            class="cart-action btn btn-info"
                            style="margin: 5px; color: #fff; background-color:#0000ff;">
                             <i class="fa fa-eye"></i>
                        </a>
                        <a href="{{ route('remove.from.wish', ['id' => $item['product_id']]) }}"
                            class="cart-action btn btn-danger"
                            style="margin: 5px;"
                            onclick="return confirm('Are you sure you want to delete this item from the wishlist?');">
                             <i class="fas fa-trash"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        @else
            <legend style="text-align: center;">Your wishlist is empty.</legend>
        @endif
        <div class="cart-procedure">
            <a href="javascript:history.go(-2)" class="shop">
                <i class="fa fa-shopping-cart"></i>{{__('Back to Shopping')}}
            </a>  
        </div>
    </form>
</section>

@endsection
