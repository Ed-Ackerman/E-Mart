@extends('layouts.app')

@section('content')
<div class="category-top">
    <a href="{{ route('client_index') }}">{{ __('Home') }}</a>

    @if ($categories->isNotEmpty())
        &gt; <a href="{{ route('client.categories', ['id' => $categories->last()->id]) }}">{{ $categories->last()->name }}</a>
    @endif

    @if ($subCategories->isNotEmpty())
        &gt; <a href="{{ route('client.subcategories', ['id' => $subCategories->last()->id]) }}">{{ $subCategories->last()->name }}</a>
    @endif

    @if ($subsubCategories->isNotEmpty())
        &gt; {{ $subsubCategories->last()->name }}
    @endif
</div>

<div class="mt-2">
    @include('layouts.partials.messages')
</div>

<section class="category-banner" >
    <a href="">
        <div class="category-banner-image" style="background-image: url('{{ count($banners) > 0 ? asset("storage/images/admin/banners/" . $banners[4]->banner) : asset('admin/imgs/e-mart-1.PNG')  }}');"></div>
    </a>
</section>

<section class="category-products">
    <div class="category-header">
        @if ($subCategories->isNotEmpty())
            {{ $subCategories->last()->name }}
        @else
            No subcategories available
        @endif
    </div>
     
    <hr>
    
    @if ($products->isEmpty())
        <div class="no-products-found">
        {{__('No products found for your search.')}} 
        </div>
    @else
        <div class="category-product-profile">
            @foreach ($products as $product)
                <a href="{{ route('view.product', ['id' => $product->id]) }}" class="profile-details">
                    <form action="{{ route('add.cart.or.add.wishlist') }}" method="POST" enctype="multipart/form-data" >
                        @csrf
                        <input type="hidden" name="productId" value="{{ $product->id }}">
                        <input type="hidden" name="quantity" value="1"> 
                        @if ($product->image)
                            @php
                                $imagePaths = explode(',', $product->image);
                                $latestImagePath = end($imagePaths);
                            @endphp
                        
                            @if (!empty($latestImagePath))
                                <div class="profile-img" style="background-image: url('{{ asset("storage/images/admin/product/{$latestImagePath}") }}')"></div>
                            @endif
                        @endif
                        <div class="profile-name">{{ $product->name }}</div>
                        <div class="profile-features">{{ $product->features }}</div>
                        <del class="profile-discount">{{ __('UGX: :price', ['price' => $product->discount]) }}</del>
                        <div class="profile-price">{{ __('UGX: :price', ['price' => $product->selling]) }}</div>
                        <div class="profile-rating">
                            @for ($i = 0; $i < $product->rating; $i++)
                                <i class="fa fa-star"></i>
                            @endfor
                            @for ($i = $product->rating; $i < 5; $i++)
                                <i class="far fa-star"></i>
                            @endfor
                        </div>
                        <div class="profile-features">{{ $product->quantity }} left</div>
                        @php
                            $progressValue = 0; 
                            if (is_numeric($product->quantity) && is_numeric($product->alert_threshold) && $product->alert_threshold > 0) {
                                $progressValue = ($product->quantity / $product->alert_threshold) * 100;
                            }
                        @endphp
                        <progress id="file" value="{{ $progressValue }}" max="100"></progress>
                        
                        
                        <div class="profile-actions">
                            <button class="add-cart" name="action" value="cart">
                                <i class="fa fa-shopping-cart"></i>
                                {{ __('ADD TO CART') }}
                            </button>
                            <button class="add-list" name="action" value="wishlist">
                                <i class="fa fa-heart"></i>
                            </button>
                        </div>
                    </form>
                </a>
            @endforeach
        </div>
    @endif
    <div class="paginate">
        {{ $products->links() }}
    </div> 
</section>

@foreach ($subCategories as $subcategory)
    <section class="products">
        <div class="products-top-bar" style="background-color: #000;">
            <div class="product-top-title">
                {{ $subcategory->name }} {{ __('| Related Items') }}
            </div>
            <a href="{{ route('client.subcategories', ['id' => $subcategory->id]) }}">{{ __('More >') }}</a>
        </div>
        <div class="products-listings">
            @php
                $subcategoryProducts = $subcategory->products()->latest()->take(6)->get();
            @endphp
            @foreach ($subcategoryProducts as $product)
                <a href="{{ route('view.product', ['id' => $product->id]) }}" class="product-profile">
                    @if ($product->image)
                        @php
                            $imagePaths = explode(',', $product->image);
                            $latestImagePath = end($imagePaths);
                        @endphp
                    
                        @if (!empty($latestImagePath))
                            <div class="profile-img" style="background-image: url('{{ asset("storage/images/admin/product/{$latestImagePath}") }}')"></div>
                        @endif
                    @endif
                    <div class="product-details">
                        <div class="details">{{ $product->name }}</div>
                        <div class="details">{{ __('UGX: :price', ['price' => $product->selling]) }}</div>
                        <del class="del">{{ __('UGX: :price', ['price' => $product->discount]) }}</del>
                        <div class="del">{{ $product->quantity . ' ' . __('items') }}</div>
                    </div>
                </a>
            @endforeach
        </div>
    </section>
@endforeach

@endsection