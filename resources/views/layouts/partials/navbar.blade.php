<div class="banner" style="background-image: url('{{ count($banners) > 0 ? asset("storage/images/admin/banners/" . $banners[0]->banner) : asset('admin/imgs/e-mart-1.PNG')  }}');">
    <!-- Content for your banner -->
</div>

<nav class="navigation" id="desktop">
    <div class="nav-categories">
        <div class="nav-categeries-top">
            <a href="{{ route('client_index') }}" class="nav-logo" style="background-image: url('{{ asset('admin/imgs/e-mart-1.PNG') }}')"></a>
            <button id="closeCategories">
                <i class="fa fa-times"></i>
            </button>
        </div>
        <hr>
        <legend>{{__('All Categories')}}</legend>
        <hr>
        <div class="main-category">
            @if(isset($categories))
                @foreach($categories as $category)
                    <div class="main-dropper">
                        <a href="{{ route('client.categories', ['id' => $category->id]) }}">{{ $category->name }}</a>
                        <i class="fa fa-chevron-right main-dropper-icon"></i>
                    </div>
            
                    <div class="sub-category" style="display: none">
                        @foreach($category->subcategories as $subCategory)
                            <div class="sub-dropper">
                                <a href="{{ route('client.subcategories', ['id' => $subCategory->id]) }}">{{ $subCategory->name }}</a>
                                <i class="fa fa-chevron-right sub-dropper-icon"></i>
                            </div>
                            <div class="sub-sub-category" style="display: none">
                                @foreach($subCategory->subsubcategories as $subsubCategory)
                                    <a href="{{ route('client.subsubcategories', ['id' => $subsubCategory->id]) }}">{{ $subsubCategory->name }}</a>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                @endforeach
            @endif

        </div>
        <hr>
        <div class="nav-icons">
            <a href="#"><i class="fab fa-instagram" style="color: #e4405f;"></i></a>
            <a href="#"><i class="fab fa-tiktok" style="color: #000;"></i></a>
            <a href="#"><i class="fab fa-twitter" style="color: #1da1f2;"></i></a>
            <a href="#"><i class="fab fa-facebook" style="color: #1877f2;"></i></a>
            <a href="#"><i class="fab fa-whatsapp" style="color: #25d366;"></i></a>
        </div>
        <hr>
        <div class="nav-footer">
            <a href="https://www.zorithindustries.com/">&copy; {{ date('Y') }} <i> Zorith Industries.</i> All rights reserved. </a>
        </div>
    </div>        
    <a href="{{ route('client_index') }}" class="nav-logo" style="background-image: url('{{ asset('admin/imgs/e-mart-1.PNG') }}')"></a>
    <div class="nav-bar">
        <button class="nav-toggle" id="toggleCategories">
            <i class="fa fa-bars"></i>
            <span class="nav-span">{{__(' All Categories')}}</span>
        </button>
        <form action="{{ route('search.for.product') }}" method="GET" class="nav-form" enctype="multipart/form-data">
            @csrf
            <input type="text" name="search" placeholder="Search for Products...">
            <button type="submit">
                <i class="fa fa-search"></i> &emsp;
                <span class="nav-span">{{ __('Search') }}</span>
            </button>
        </form>
        
    </div>
    <div class="nav-account">
        <a href="{{ route('cart.product') }}">
            <div class="nav-count">{{ $cartCount }}</div>
            <i class="fa fa-shopping-cart"></i>
            <span class="nav-span">{{__('Cart')}}</span>
        </a>
        <a href="{{ route('wish.product') }}">
            <div class="nav-count">{{ $wishCount }}</div>
            <i class="fa fa-heart"></i>
            <span class="nav-span">{{__('List')}}</span>
        </a> 
        <button class="dropdown-toggle">
            <i class="fa fa-user"></i>
            <span class="nav-span">
                @auth
                    {{ auth()->user()->name }}
                @else
                    {{ __('Account') }}
                @endauth
            </span>
            
        </button>
        <div class="dropdown-content">
            @auth
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> {{ __('Logout') }}
                </a>
                <form id="logout-form" style="display: none" action="{{ route('logout') }}" method="POST">
                    @csrf
                </form>
                <a href="{{route('client.help')}}">
                    <i class="fa fa-question-circle"></i>{{__('Help')}}
                </a>
                <a href="{{route('custom.order')}}">
                    <i class="fas fa-car"></i>{{__('Place_Order')}}
                </a>
                <a href="{{route('client.returns')}}">
                   <i class="fas fa-retweet fa-spin"></i>{{__('Returns')}}
                </a>
                @role('admin')
                <a href="{{ route('overview') }}" >
                    <i class="fas fa-tachometer-alt"></i> {{__('Dashboard')}}
                </a>
                @endrole
            @endauth
            @guest
           
            <button class="nav-auth" onclick="window.location.href = '{{ route('login') }}';" style="background-color: #ff6600;">
                <i class="fas fa-sign-in-alt"></i>{{ __('Login') }}
            </button>
            <button class="nav-auth" onclick="window.location.href = '{{ route('register') }}';" style="background-color: #000;">
                <i class="fa fa-user-plus"></i> {{__('Sign Up')}}
            </button>
            <hr>
            <a href="">
               <i class="fas fa-retweet fa-spin"></i>{{__('Returns')}}
            </a>
            @endguest
        </div>
        
    </div>
</nav>

{{-- mobile nav. --}}

<nav class="navigation" id="mobile">
    <div class="nav-categories-mobile">
        <div class="nav-categeries-top">
            <a href="{{ route('client_index') }}" class="nav-logo" style="background-image: url('{{ asset('admin/imgs/e-mart-1.PNG') }}')"></a>
            <button id="closeCategories-mobile">
                <i class="fa fa-times"></i>
            </button>
        </div>
        <hr>
        <legend>{{__('All Categories')}}</legend>
        <hr>
        <div class="main-category">
            @if(isset($categories))
                @foreach($categories as $category)
                    <div class="main-dropper">
                        <a href="{{ route('client.categories', ['id' => $category->id]) }}">{{ $category->name }}</a>
                        <i class="fa fa-chevron-right main-dropper-icon"></i>
                    </div>
            
                    <div class="sub-category" style="display: none">
                        @foreach($category->subcategories as $subCategory)
                            <div class="sub-dropper">
                                <a href="{{ route('client.subcategories', ['id' => $subCategory->id]) }}">{{ $subCategory->name }}</a>
                                <i class="fa fa-chevron-right sub-dropper-icon"></i>
                            </div>
                            <div class="sub-sub-category" style="display: none">
                                @foreach($subCategory->subsubcategories as $subsubCategory)
                                    <a href="{{ route('client.subsubcategories', ['id' => $subsubCategory->id]) }}">{{ $subsubCategory->name }}</a>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                @endforeach
            @endif

        </div>
        <hr>
        <div class="nav-icons">
            <a href="#"><i class="fab fa-instagram" style="color: #e4405f;"></i></a>
            <a href="#"><i class="fab fa-tiktok" style="color: #000;"></i></a>
            <a href="#"><i class="fab fa-twitter" style="color: #1da1f2;"></i></a>
            <a href="#"><i class="fab fa-facebook" style="color: #1877f2;"></i></a>
            <a href="#"><i class="fab fa-whatsapp" style="color: #25d366;"></i></a>
        </div>
        <hr>
        <div class="nav-footer">
            <a href="https://www.zorithindustries.com/">&copy; {{ date('Y') }} <i> Zorith Industries.</i> All rights reserved. </a>
        </div>
    </div>
    <div class="nav-mobile">
        <a href="{{ route('client_index') }}" class="nav-logo" style="background-image: url('{{ asset('admin/imgs/e-mart-1.PNG') }}')"></a>
        <div class="nav-account">
            <a href="{{ route('cart.product') }}">
                <div class="nav-count">{{ $cartCount }}</div>
                <i class="fa fa-shopping-cart"></i>
                <span class="nav-span">{{__('Cart')}}</span>
            </a>
            <a href="{{ route('wish.product') }}">
                <div class="nav-count">{{ $wishCount }}</div>
                <i class="fa fa-heart"></i>
                <span class="nav-span">{{__('List')}}</span>
            </a> 
            <button class="dropdown-toggle">
                <i class="fa fa-user"></i>
                <span class="nav-span">
                    @auth
                        {{ auth()->user()->name }}
                    @else
                        {{ __('Account') }}
                    @endauth
                </span>
                
            </button>
            <div class="dropdown-content">
                @auth
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i> {{ __('Logout') }}
                    </a>
                    <form id="logout-form" style="display: none" action="{{ route('logout') }}" method="POST">
                        @csrf
                    </form>
                    <a href="{{route('client.help')}}">
                        <i class="fa fa-question-circle"></i>{{__('Help')}}
                    </a>
                    <a href="{{ route('custom.order') }}">
                        <i class="fas fa-car"></i>{{__('Place_Order')}}
                    </a>
                    <a href="{{route('client.returns')}}">
                        <i class="fas fa-sync fa-spin"></i>{{__('Returns')}}
                    </a>
                    @role('admin')
                    <a href="{{ route('overview') }}" >
                        <i class="fas fa-tachometer-alt"></i> {{__('Dashboard')}}
                    </a>
                    @endrole
                @endauth
                @guest
               
                <button class="nav-auth" onclick="window.location.href = '{{ route('login') }}';" style="background-color: #ff6600;">
                    <i class="fas fa-sign-in-alt"></i>{{ __('Login') }}
                </button>
                <button class="nav-auth" onclick="window.location.href = '{{ route('register') }}';" style="background-color: #000;">
                    <i class="fa fa-user-plus"></i> {{__('Sign Up')}}
                </button>
                <hr>
                <a href="">
                    <i class="fas fa-sync fa-spin"></i>{{__('Returns')}}
                </a>
                @endguest
            </div>
            
        </div>
    </div>
    <div class="nav-bar">
        <button class="nav-toggle" id="toggleCategories-mobile">
            <i class="fa fa-bars"></i>
            <span class="nav-span">{{__(' All Categories')}}</span>
        </button>
        <form action="{{ route('search.for.product') }}" method="GET" class="nav-form" enctype="multipart/form-data">
            @csrf
            <input type="text" name="search" placeholder="Search for Products...">
            <button type="submit">
                <i class="fa fa-search"></i> &emsp;
                <span >{{ __('Search') }}</span>
            </button>
        </form>      
    </div>
</nav>


