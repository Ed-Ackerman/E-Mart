@extends('layouts.app')

@section('content')
<div class="mt-2">
    @include('layouts.partials.messages')
</div>
<form class="product" action="{{ route('add.cart.or.add.wishlist') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="productId" value="{{ $product->id }}">
    <div class="product-images">
        <div class="product-main-image"></div>
        <div class="product-sub-images">
            @if ($product->image)
            @php
                $imagePaths = explode(',', $product->image);
            @endphp
    
            @foreach ($imagePaths as $imagePath)
                @if (!empty($imagePath))
                    <div class="sub-images" style="background-image: url('{{ asset('/storage/images/admin/product/' . trim($imagePath)) }}');"></div>
                @endif
            @endforeach
        @endif
        </div>
    </div>
    <div class="product-specs">
        <div class="pdt-name">{{ $product -> name }}</div>
        <div class="profile-rating" style="font-size: 20px; margin: 20px auto;">
            @for ($i = 0; $i < $product->rating; $i++)
                <i class="fa fa-star" style="font-size: 18px;"></i>
            @endfor
            @for ($i = $product->rating; $i < 5; $i++)
                <i class="far fa-star" style="font-size: 18px;"></i>
            @endfor
        </div>
        <div class="pdt-pricing">
            <div class="ptd-price">{{ __('UGX: :price', ['price' => $product->selling]) }}</div>
            <del class="ptd-discount">{{ __('UGX: :price', ['price' => $product->discount]) }}</del>
        </div>
        <hr>
        <div class="pdt-details">
            <div class="name">{{__('Supplier')}}</div>
            <div class="detail-info">
                @if ($suppliers->isNotEmpty())
                    @foreach ($suppliers as $supplier)
                        {{ $supplier->name }}
                    @endforeach
                @else
                    Supplier not specified
                @endif
            </div>          
        </div>
        <div class="pdt-details">
            <div class="name">{{__('Product Number')}}</div>
            <div class="detail-info">{{ $product -> code }}</div>
        </div>
        <div class="pdt-details">
            <div class="name">{{__('Return Schedule')}}</div>
            <div class="detail-info">{{__('5 Days')}}</div>
        </div>
        <div class="pdt-details">
            <div class="name">{{__('Pay Via')}}</div>
            <div class="detail-img" style="background-image: url('{{ asset('client/imgs/mtn.png') }}')" ></div>
            <div class="detail-img" style="background-image: url('{{ asset('client/imgs/bank.png') }}')" ></div>
            <div class="detail-img" style="background-image: url('{{ asset('client/imgs/Airtel_Uganda.jpg') }}')" ></div>
        </div>
        <hr>
        <div class="pdt-details">
            <input type="number" name="quantity" min="1" placeholder="Qty" required autofocus>
            <button class="product-cart" name="action" value="cart">
                <i class="fa fa-shopping-cart"></i>
                {{ __('ADD TO CART') }}
            </button>
            <button class="product-list" name="action" value="wishlist">
                <i class="fa fa-heart"></i>
            </button>
        </div>
    </div>
    <div class="product-info">
        <div class="ptd-price">{{ __('UGX: :price', ['price' => $product->selling]) }}</div>
        <div class="detail-info" style="margin: 10px auto">
            <i class="fas fa-chart-pie"></i>
            @if ($product->quantity == 0)
                <span style="color: #b10101; border-radius: 5px; width: 100%; padding: 3px 6px;">{{__('Out_of_Stock')}}</span>
            @elseif ($product->quantity <= $product->alert_threshold)
                <span style="color: #b89c00; border-radius: 5px; width: 100%; padding: 3px 6px;">{{__('Needs_Reorder')}}</span>
            @else
                <span style="color: #04aa11; border-radius: 5px; width: 100%; padding: 3px 6px;">{{__('In_Stock')}}</span>
            @endif
        </div>
        <hr>
        <i class="fa fa-car" style="font-size: 3rem; margin: 10px auto;"></i>
        <div class="pdt-details">
            <div class="name">{{__('Arrives In')}}</div>
            <div class="detail-info">{{__('5 Days')}}</div>
        </div>
        <div class="pdt-details">
            <i class="fa fa-map-marker" style="width: 10%;"></i>
            <div class="detail-info">{{__(' To Your Door Step')}}</div>
        </div>
        <div class="pdt-details">
            <i class="fa fa-lock" style="width: 10%;"></i>
            <div class="detail-info">{{__('  Secure Transaction')}}</div>
        </div>
        <div class="ptd-btn">
            <button style=" color:#ff6600;">
                <i class="fa fa-shopping-cart" ></i>
                {{__('Add To Cart')}}
            </button>
            <button style=" color: #0000ff;">
                <i class="fa fa-heart" ></i>
                {{__('Add To Wishlist')}}
            </button>
        </div>
        <div class="pdt-details">
            <div class="name">{{__('Ships_From')}}</div>
            <div class="detail-info">{{__('E-Mart')}}</div>
        </div>
        <div class="pdt-details">
            <div class="name">{{__('Sold_By')}}</div>
            <div class="detail-info">{{__('E-Mart')}}</div>
        </div>
        <button>
            <i class="fa fa-envelope" ></i>
            {{__('Contact Us')}}
        </button>
        <hr>
        <div class="pdt-details">
            <div class="name">{{__('Product_Supplier')}}</div>
            <div class="detail-info">
                @if ($suppliers->isNotEmpty())
                    @foreach ($suppliers as $supplier)
                        {{ $supplier->name }}
                    @endforeach
                @else
                    Supplier not specified
                @endif
            </div>      
        </div>
        <hr>
        <div class="nav-icons">
            <a href="#"><i class="fab fa-instagram" style="color: #e4405f;"></i></a>
            <a href="#"><i class="fab fa-tiktok" style="color: #000;"></i></a>
            <a href="#"><i class="fab fa-twitter" style="color: #1da1f2;"></i></a>
            <a href="#"><i class="fab fa-facebook" style="color: #1877f2;"></i></a>
            <a href="#"><i class="fab fa-whatsapp" style="color: #25d366;"></i></a>
        </div>        
    </div>
</form>
<section class="features">
    <legend>{{__('Unique Featues')}}</legend>
    <p>{{ $product -> features }}</p>
</section>
<section class="description">
    <div class="specifications">
        <legend>{{__('Specifications')}}</legend>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th scope="col" class="id">{{__('#')}}</th>
                    <th scope="col">{{__('Specification')}}</th>
                    <th scope="col">{{__('Value')}}</th>
                    <th scope="col">{{__('Custom')}}</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th scope="row" class="id">1</th>
                    <td>Brand</td>
                    <td>{{$product -> brand}}</td>
                    <td></td>
                </tr>
                <tr>
                    <th scope="row" class="id">2</th>
                    <td>Size</td>
                    <td>{{$product -> size}}</td>
                    <td>{{$product -> custom_size}}</td>
                </tr>
                <tr>
                    <th scope="row" class="id">3</th>
                    <td>Color</td>
                    <td> <input type="color" value="{{  $product -> color }}" style="width: 100%; height: 6vh;" readonly> </td>
                    <td></td>
                </tr>
                <tr>
                    <th scope="row" class="id">4</th>
                    <td>Material</td>
                    <td>{{$product -> material}}</td>
                    <td></td>
                </tr>
                <tr>
                    <th scope="row" class="id">5</th>
                    <td>Weight</td>
                    <td>{{$product -> weight}}</td>
                    <td></td>
                </tr>
                <tr>
                    <th scope="row" class="id">6</th>
                    <td>Condition</td>
                    <td>{{$product -> condition}}</td>
                    <td>{{$product -> custom_condition}}</td>
                </tr>
                <tr>
                    <th scope="row" class="id">7</th>
                    <td>Rating</td>
                    <td>{{$product -> rating}} {{__('Star(s)')}}</td>
                    <td>  
                        @for ($i = 0; $i < $product->rating; $i++)
                            <i class="fa fa-star" style="font-size: 15px; color:#ffda08;" ></i>
                        @endfor
                        @for ($i = $product->rating; $i < 5; $i++)
                            <i class="far fa-star" style="font-size: 15px; color:#ffda08;"></i>
                        @endfor
                    </td>
                </tr>
                <tr>
                    <th scope="row" class="id">8</th>
                    <td>Warranty</td>
                    <td>{{$product -> warranty}}</td>
                    <td>{{$product -> custom_warranty}}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="specifications">
        <legend>{{__('Description')}}</legend>
        <p>{{ $product -> description }}</p>
    </div>
</section>

@foreach ($SubCategories as $subcategory)
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
                            <div class="product-img" style="background-image: url('{{ asset("storage/images/admin/product/{$latestImagePath}") }}')"></div>
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
