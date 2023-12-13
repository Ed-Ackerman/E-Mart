@extends('layouts.app')

@section('content')
<section class="index-slider">
    <div class="banner-images">
        @foreach($banners->slice(1, 6) as $banner)
            <div class="banner-img" style="background-image: url('{{ asset("storage/images/admin/banners/" .  $banner->banner) }}')"></div>
        @endforeach
    </div>
</section>

<section class="products">
    <div class="top-bar">{{__('Top Categories')}}</div>
    @php
        $columnCount = ceil($first18Categories->count() / 2);
    @endphp

    @for ($i = 0; $i < 2; $i++)
        <div class="categories">
            @foreach($first18Categories->slice($i * $columnCount, $columnCount) as $category)
                @php
                    $latestImagePath = 'placeholder.jpg';
                    $latestImagePath = ''; // Initialize $latestImagePath here

                    if ($category->products->isNotEmpty()) {
                        $firstProduct = $category->products->first();
                        if ($firstProduct && $firstProduct->image) {
                            $imagePaths = explode(',', $firstProduct->image);
                            $latestImagePath = end($imagePaths);
                        }
                    }
                @endphp

                <a href="{{ route('client.categories', ['id' => $category->id]) }}" class="category-img" style="background-image: url('{{ asset("storage/images/admin/product/" . $latestImagePath) }}')">
                    <div class="category-name">{{ $category->name }}</div>
                </a>
            @endforeach
        </div>
    @endfor

</section>

<section class="products">
    <div class="products-top-bar">
        <div class="product-top-title">
            {{ __('Flash Sales') }}
        </div>
        <div class="timer">{{__('Hurry_Up')}}</div>
        <div class="flash-timer">
            <span>{{ __('Try') }}</span>{{ __('-') }}
            <span>{{ __('Your') }}</span>{{ __('-') }}
            <span>{{ __('Luck') }}</span>{{ __('-') }}
            <span>{{ __('.') }}</span>{{ __('-') }}
        </div>
        @if(isset($flashCategory))
            <a href="{{ route('client.categories', ['id' => $flashCategory->id]) }}">{{ __('More >') }}</a>
        @endif
    </div>
    <div class="products-listings">
        @foreach ($flashProducts as $product)
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

<section class="products">
    <div class="top-bar">{{__('Black Friday Specials')}}</div>        
    <div class="product-banner-img" style="background-image: url('{{ count($banners) > 0 ? asset("storage/images/admin/banners/" . $banners[4]->banner) : asset('admin/imgs/e-mart-1.PNG')  }}');" ></div>
</section>

<section class="products">
    <div class="products-top-bar" style="background-color: #000;">
        <div class="product-top-title">
            {{__('Black Friday')}}
        </div>
    
        @if(isset($blackCategory))
        <a href="{{ route('client.categories', ['id' => $blackCategory->id]) }}">{{ __('More >') }}</a>
        @endif
    </div>
    <div class="products-listings">
        @foreach ($blackProducts as $product)
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
                    <div class="details">{{__('UGX: :price', ['price' => $product->selling])}}</div>
                    <del class="del">{{__('UGX: :price', ['price' => $product->discount])}}</del>
                    <div class="del">{{ $product->quantity . ' ' . __('items') }}</div>
                </div>
            </a>
        @endforeach
    </div>
</section>


<section class="products">
    <div class="top-bar">{{__('Top Deals')}}</div>        
    <div class="product-banner-img" style="background-image: url('{{ count($banners) > 0 ? asset("storage/images/admin/banners/" . $banners[6]->banner) : asset('admin/imgs/e-mart-1.PNG')  }}'); " ></div>
</section>

<section class="products">
    <div class="products-top-bar">
        <div class="product-top-title">
            {{__('Seasonal Specials')}}
        </div>
    
        @if(isset($specialCategory))
        <a href="{{ route('client.categories', ['id' => $specialCategory->id]) }}">{{ __('More >') }}</a>
        @endif
    </div>
    <div class="products-listings">
        @foreach ($specialProducts as $product)
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
                    <div class="details">{{__('UGX: :price', ['price' => $product->selling])}}</div>
                    <del class="del">{{__('UGX: :price', ['price' => $product->discount])}}</del>
                    <div class="del">{{ $product->quantity . ' ' . __('items') }}</div>
                </div>
            </a>
        @endforeach
    </div>
</section>

<section class="products">
    <div class="products-top-bar">
        <div class="product-top-title">
            {{__('Limited Offers')}}
        </div>
    
        @if(isset($limitedCategory))
        <a href="{{ route('client.categories', ['id' => $limitedCategory->id]) }}">{{ __('More >') }}</a>
        @endif
    </div>
    <div class="products-listings">
        @foreach ($limitedProducts as $product)
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
                    <div class="details">{{__('UGX: :price', ['price' => $product->selling])}}</div>
                    <del class="del">{{__('UGX: :price', ['price' => $product->discount])}}</del>
                    <div class="del">{{ $product->quantity . ' ' . __('items') }}</div>
                </div>
            </a>
        @endforeach
    </div>
</section>

<section class="products">
    <div class="products-top-bar">
        <div class="product-top-title">
            {{__('Package Deals')}}
        </div>
    
        @if(isset($packageCategory))
        <a href="{{ route('client.categories', ['id' => $packageCategory->id]) }}">{{ __('More >') }}</a>
        @endif
    </div>
    <div class="products-listings">
        @foreach ($packageProducts as $product)
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
                    <div class="details">{{__('UGX: :price', ['price' => $product->selling])}}</div>
                    <del class="del">{{__('UGX: :price', ['price' => $product->discount])}}</del>
                    <div class="del">{{ $product->quantity . ' ' . __('items') }}</div>
                </div>
            </a>
        @endforeach
    </div>
</section>

@endsection

@section('custom-scripts')

<script>
    // Function to update the timer
    function updateTimer() {
      // Get the current date and time
      const now = new Date();

      // Check if today is Friday
      if (now.getDay() === 5) {
        // Reset the timer or perform any action you want when it's Friday
        clearInterval(timerInterval);
        return;
      }
  
      // Calculate the remaining time until next Friday at midnight
      const daysUntilFriday = (5 - now.getDay() + 7) % 7; // 5 represents Friday (Sunday is 0)
      const nextFriday = new Date(now.getFullYear(), now.getMonth(), now.getDate() + daysUntilFriday, 0, 0, 0);
      const timeUntilFriday = nextFriday - now;
  
      // Calculate days, hours, minutes, and seconds
      const days = Math.floor(timeUntilFriday / (1000 * 60 * 60 * 24));
      const hours = Math.floor((timeUntilFriday % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      const minutes = Math.floor((timeUntilFriday % (1000 * 60 * 60)) / (1000 * 60));
      const seconds = Math.floor((timeUntilFriday % (1000 * 60)) / 1000);
  
      // Display the timer using jQuery
      $('.flash-timer').html(`${days}d : ${hours}h : ${minutes}m : ${seconds}s`);
    }

    // Set up an interval to update the timer every second
    const timerInterval = setInterval(updateTimer, 1000);
</script>

@endsection