<nav class="dashboard-navigator">
    <div class="sidebar">
        <!-- Dashboard Overview -->
        <div class="grouper">Main</div>

        <div class="dropdown">
            <button class="dropbtn">
                <i class="fas fa-tachometer-alt"></i>
                <span class="text">{{__('Dashboard Overview')}}</span>
                <i class="fa fa-chevron-down arrow"></i>
            </button>
            <div class="dropdown-content">
                <a href="{{ route('overview') }}">
                    <li class="fa fa-bar-chart"></li>
                    <span class="text">{{__('Overview Analytics')}}</span>
                </a>
                {{-- <a href="{{ route('realtime') }}">
                    <li class="fa fa-line-chart"></li>
                    <span class="text">{{__('Real-Time Metrics')}}</span>
                </a> --}}
            </div>
        </div>

        <div class="grouper">{{__(('Pages'))}}</div>

        <!-- Content Management -->
        <div class="dropdown">
            <button class="dropbtn">
                <i class="fa fa-file-text"></i>
                <span class="text">{{__('Content Management')}}</span>
                <i class="fa fa-chevron-down arrow"></i>
            </button>
            <div class="dropdown-content">
                <a href="{{ route('banners') }}">
                    <li class="fa fa-image"></li>
                    <span class="text">{{__('Banners and Sliders')}}</span>
                </a>
            </div>
        </div>
        
        <div class="grouper">{{__(('Catalog'))}}</div>

        <!-- Order Management -->
        <div class="dropdown">
            <button class="dropbtn">
                <i class="fa fa-shopping-cart"></i>
                <span class="text">{{__('Order Management')}}</span>
                <i class="fa fa-chevron-down arrow"></i>
            </button>
            <div class="dropdown-content">
                <a href="{{ route('proccessing') }}">
                    <li class="fa fa-cog"></li>
                    <span class="text">{{__('Order Processing')}}</span>
                </a>
                <a href="{{ route('custom') }}">
                    <li class="fa fa-star"></li>
                    <span class="text">{{__('Custom Order')}}</span>
                </a>
                <a href="{{ route('returns') }}">
                    <li class="fa fa-undo"></li>
                    <span class="text">{{__('Returns and Refunds')}}</span>
                </a>
            </div>
        </div>
        
        <!-- Inventory Management -->
        <div class="dropdown">
            <button class="dropbtn">
                <i class="fa fa-archive"></i>
                <span class="text">{{__('Inventory Management')}}</span>
                <i class="fa fa-chevron-down arrow"></i>
            </button>
            <div class="dropdown-content">
                <a href="{{ route('levels') }}">
                    <li class="fa fa-cubes"></li>
                    <span class="text">{{__('Stock Levels')}}</span>
                </a>
              
                <a href="{{ route('suppliers') }}">
                    <li class="fa fa-truck"></li>
                    <span class="text">{{__('Supplier Management')}}</span>
                </a>
                <a href="{{ route('warehouse') }}">
                    <li class="fa fa-building"></li>
                    <span class="text">{{__('Warehouse Management')}}</span>
                </a>
            </div>
        </div>

        <!-- Product Management -->
        <div class="dropdown">
            <button class="dropbtn">
                <i class="fa fa-cube"></i>
                <span class="text">{{__('Product Management')}}</span>
                <i class="fa fa-chevron-down arrow"></i>
            </button>
            <div class="dropdown-content">
                <a href="{{ route('products') }}">
                    <li class="fa fa-folder-plus"></li>
                    <span class="text">{{__('Product Catalog')}}</span>
                </a>
            
                <a href="{{ route('categories') }}">
                    <li class="fa fa-cubes"></li>
                    <span class="text">{{__('Categories and Subs')}}</span>
                </a>
            </div>
        </div>
    
        <!-- Customer Management -->
        <div class="dropdown">
            <button class="dropbtn">
                <i class="fa fa-users"></i>
                <span class="text">{{__('User Management')}}</span>
                <i class="fa fa-chevron-down arrow"></i>
            </button>
            <div class="dropdown-content">
                <a href="{{ route('users.index') }}">
                    <li class="fa fa-id-card"></li>
                    <span class="text">{{__('Customer Profiles')}}</span>
                </a>
                <a href="{{ route('help') }}">
                    <li class="fa fa-info-circle"></li>
                    <span class="text">{{__('Help Center')}}</span>
                </a>
            </div>
        </div>
    
        <div class="grouper">{{__(('Finance'))}}</div>

        <!-- Payment and Shipping -->
        <div class="dropdown">
            <button class="dropbtn">
                <i class="fa fa-credit-card"></i>
                <span class="text">{{__('Payment')}}</span>
                <i class="fa fa-chevron-down arrow"></i>
            </button>
            <div class="dropdown-content">
                <a href="{{ route('payment_get') }}">
                    <li class="fa fa-credit-card"></li>
                    <span class="text">{{__('Payment Gateways')}}</span>
                </a>
              
                <a href="{{ route('payment_pro') }}">
                    <li class="fa fa-credit-card"></li>
                    <span class="text">{{__('Payment Processing')}}</span>
                </a>
            </div>
        </div>
        
        <!-- Analytics and Reports -->
        <div class="dropdown">
            <button class="dropbtn">
                <i class="fa fa-line-chart"></i>
                <span class="text">{{__('Analytics and Reports')}}</span>
                <i class="fa fa-chevron-down arrow"></i>
            </button>
            <div class="dropdown-content">
                <a href="{{ route('sales') }}">
                    <li class="fa fa-bar-chart"></li>
                    <span class="text">{{__('Sales Analytics')}}</span>
                </a>
               
                <a href="{{ route('custom.sales') }}">
                    <li class="fa fa-money"></li>
                    <span class="text">{{__('Custom Sales Reports')}}</span>
                </a>
            </div>
        </div>
       
        <div class="grouper">{{__(('Settings'))}}</div>

        <!-- Roles and Permissions -->
        <div class="dropdown" style="margin-bottom: 30%">
            <button class="dropbtn">
                <i class="fa fa-key"></i>
                <span class="text">{{__('Roles and Permissions')}}</span>
                <i class="fa fa-chevron-down arrow"></i>
            </button>
            <div class="dropdown-content">
                <a href="{{ route('roles.index') }}">
                    <li class="fa fa-user"></li>
                    <span class="text">{{__('User Roles')}}</span>
                </a>
                <a href="{{ route('permissions.index') }}">
                    <li class="fa fa-cogs"></li>
                    <span class="text">{{__('Permission Settings')}}</span>
                </a>
            </div>
        </div>
    
        
    </div>
</nav>


  