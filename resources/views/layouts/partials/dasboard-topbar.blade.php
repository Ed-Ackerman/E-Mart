@auth
    
<section class="dashboard-topbar">
    <a href="{{ route('client_index') }}" class="dashboard-logo" style="background-image: url('{{ asset('admin/imgs/e-mart-1.PNG') }}')"></a>
    <button class="toggle">
        <li class="fa fa-bars"></li>
    </button>
    <div class="dashboard-shortcuts">
        <a href="{{ route('levels') }}">
            <li class="fa fa-bell" style="background-color: #ff2f00;"></li>
            <div class="notification-number">{{ $productsBelowThresholdCount }}</div>
        </a>        
        <a href="{{ route('help') }}">
            <li class="fa fa-envelope" style="background-color: #00ff2f;"></li>
            <div class="notification-number">{{ $newInquiryCount }}</div>
        </a>        
        <a href="{{ route('proccessing') }}">
            <li class="fa fa-shopping-cart" style="background-color: #ff8800;"></li>
            <div class="notification-number">{{ $newOrderCount }}</div>
        </a>
        <a href="{{ route('custom') }}">
            <li class="fa fa-star" style="color: #ff8800; background-color: #fbff00;"></li>
            <div class="notification-number">{{ $newCustomOrderCount }}</div>
        </a>
        <a href="{{ route('products') }}">
            <li class="fa fa-plus" style=" background-color: #2f00ff;"></li>
        </a>
        <a href="{{ route('client_index') }}">
            <li class="fas fa-globe" style=" background-color: #2f00ff;"></li>
        </a>
       
    </div>
    <div class="dashboard-account">
        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true">
            {{ Auth::user()->name }}
        </a>

        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="{{ route('logout') }}"
               onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </div>
</section>

@endauth