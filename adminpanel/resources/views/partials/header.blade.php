<aside class="navbar-aside" id="offcanvas_aside">
    <div class="aside-top">
        <a href="{{ route('index') }}" class="brand-wrap">
            <img src="{{ asset('assets/imgs/theme/ChennaiAngadiLogo.png') }}" class="logo" alt="Chennai Angandi" />
            <img src="{{ asset('assets/imgs/theme/chennaiangadifavicon.png') }}" class="logo-mini"
                alt="Chennai Angadi" />
        </a>
        <div>
            <button class="btn btn-icon btn-aside-minimize">
                <i class="text-muted material-icons md-menu_open"></i>
            </button>
        </div>
    </div>

    <nav>
        <ul class="menu-aside">

            {{-- Dashboard --}}
            <li class="menu-item {{ request()->routeIs('index') ? 'active' : '' }}">
                <a class="menu-link" href="{{ route('index') }}">
                    <i class="icon material-icons md-home"></i>
                    <span class="text">Dashboard</span>
                </a>
            </li>

            {{-- Categories --}}
            @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('categories-view'))
                <li class="menu-item has-submenu
                        {{ request()->routeIs('maincategory.*', 'subcategory.*', 'childcategory.*') ? 'active' : '' }}">
                    <a class="menu-link" href="#">
                        <i class="icon material-icons md-category"></i>
                        <span class="text">Categories</span>
                    </a>
                    <div class="submenu">
                        <a class="{{ request()->routeIs('maincategory.*') ? 'active' : '' }}"
                            href="{{ route('maincategory.index') }}">Main Category</a>

                        <a class="{{ request()->routeIs('subcategory.*') ? 'active' : '' }}"
                            href="{{ route('subcategory.index') }}">Sub Category</a>

                        <a class="{{ request()->routeIs('childcategory.*') ? 'active' : '' }}"
                            href="{{ route('childcategory.index') }}">Child Category</a>
                    </div>
                </li>
            @endif

            {{-- Quantity --}}
            @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('quantity-view'))
                <li class="menu-item  {{ request()->routeIs('quantity.*') ? 'active' : '' }}">
                    <a class="menu-link" href="{{ route('quantity.table') }}">
                        <i class="icon material-icons md-layers"></i>
                        <span class="text">Quantity</span>
                    </a>

                </li>
            @endif

            {{-- Products --}}
            @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('products-view'))
                <li
                    class="menu-item  {{ request()->routeIs('product.*') && !request()->routeIs('product.inventory.*') ? 'active' : '' }}">
                    <a class="menu-link" href="{{ route('product.table') }}">
                        <i class="icon material-icons md-shopping_bag"></i>
                        <span class="text">Products</span>
                    </a>

                </li>
            @endif


            {{-- Order (Website/Frontend Orders) --}}
            @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('orders-view'))
                <li class="menu-item {{ request()->routeIs('orders.*') ? 'active' : '' }}">
                    <a class="menu-link" href="{{ route('orders.table') }}">
                        <i class="icon material-icons md-shopping_cart"></i>
                        <span class="text">Order</span>
                    </a>
                </li>
            @endif

            {{-- Billing --}}
            @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('billing-view'))
                <li class="menu-item {{ request()->routeIs('billing.*', 'admin.billing.*') ? 'active' : '' }}">
                    <a class="menu-link" href="{{ route('billing.table') }}">
                        <i class="icon material-icons md-payment"></i>
                        <span class="text">Billing</span>
                    </a>
                </li>
            @endif

            {{-- Sales Report --}}
            @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('reports-view'))
                <li class="menu-item {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                    <a class="menu-link" href="{{ route('reports.index') }}">
                        <i class="icon material-icons md-bar_chart"></i>
                        <span class="text">Reports</span>
                    </a>
                </li>
            @endif

            {{-- Inventory --}}
            @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('inventory-view'))
                <li class="menu-item {{ request()->routeIs('product.inventory.*') ? 'active' : '' }}">
                    <a class="menu-link" href="{{ route('product.inventory.table') }}">
                        <i class="icon material-icons md-storage"></i>
                        <span class="text">Inventory</span>
                        @if($lowStockCount > 0)
                            <span class="badge bg-danger ms-2">
                                {{ $lowStockCount }}
                            </span>
                        @endif
                    </a>
                </li>
            @endif

            {{-- coupon & discount--}}
            @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('coupons-view'))
                <li class="menu-item  {{ request()->routeIs('coupon.*') ? 'active' : '' }}">
                    <a class="menu-link" href="{{ route('coupon.table') }}">
                        <i class="icon material-icons md-confirmation_number"></i>
                        <span class="text">Coupon</span>
                    </a>
                </li>
            @endif

            {{-- Customer --}}
            @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('customers-view'))
                <li class="menu-item {{ request()->routeIs('customer*') ? 'active' : '' }}">
                    <a class="menu-link" href="{{ route('customer') }}">
                        <i class="icon material-icons md-person"></i>
                        <span class="text">Customer</span>
                    </a>
                </li>
            @endif

            {{-- offer--}}
            @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('offers-view'))
                <li class="menu-item  {{ request()->routeIs('offer.*') ? 'active' : '' }}">
                    <a class="menu-link" href="{{ route('offer.table') }}">
                        <i class="icon material-icons md-local_offer"></i>
                        <span class="text">Offers</span>
                    </a>
                </li>
            @endif

            {{-- Shipping --}}
            @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('shipping-view'))
                <li class="menu-item has-submenu
                    {{ request()->routeIs('shipping.zone.*', 'shipping.state.*', 'shipping.rules.*') ? 'active' : '' }}">

                    <a class="menu-link" href="#">
                        <i class="icon material-icons md-location_on"></i>
                        <span class="text">Shipping</span>
                    </a>

                    <div class="submenu">

                        <a class="{{ request()->routeIs('shipping.zone.*') ? 'active' : '' }}"
                            href="{{ route('shipping.zone.table') }}">
                            Shipping Zones
                        </a>

                        <a class="{{ request()->routeIs('shipping.state.*') ? 'active' : '' }}"
                            href="{{ route('shipping.state.table') }}">
                            Zone States
                        </a>

                        <a class="{{ request()->routeIs('shipping.rules.*') ? 'active' : '' }}"
                            href="{{ route('shipping.rules.table') }}">
                            Shipping Rules
                        </a>

                    </div>
                </li>
            @endif

            {{-- Slider --}}
            @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('sliders-view'))
                <li class="menu-item {{ request()->routeIs('slider.*') ? 'active' : '' }}">
                    <a class="menu-link" href="{{ route('slider.table') }}">
                        <i class="icon material-icons md-slideshow"></i>
                        <span class="text">Sliders</span>
                    </a>
                </li>
            @endif

            {{-- Notifications --}}
            @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('notifications-view'))
                <li class="menu-item {{ request()->routeIs('notifications.table') ? 'active' : '' }}">
                    <a class="menu-link" href="{{ route('notifications.table') }}">
                        <i class="icon material-icons md-notifications"></i>
                        <span class="text">Push Notifications</span>
                    </a>
                </li>
            @endif

            {{-- Email History --}}
            @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('email-history-view'))
                <li class="menu-item {{ request()->routeIs('email-history.*') ? 'active' : '' }}">
                    <a class="menu-link" href="{{ route('email-history.table') }}">
                        <i class="icon material-icons md-email"></i>
                        <span class="text"> Email History</span>
                    </a>
                </li>
            @endif

            {{-- Contact Enquiries --}}
            <li class="menu-item {{ request()->routeIs('admin.contact.*') ? 'active' : '' }}">
                <a class="menu-link" href="{{ route('admin.contact.index') }}">
                    <i class="icon material-icons md-contact_mail"></i>
                    <span class="text">Contact Enquiries</span>
                </a>
            </li>

            {{-- ======================================= --}}
            {{-- ADMIN & ROLES (SuperAdmin / roles-view) --}}
            {{-- ======================================= --}}
            @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('roles-view'))
                <li class="menu-item has-submenu
                        {{ request()->routeIs('admin.roles.*', 'admin.users.*') ? 'active' : '' }}">
                    <a class="menu-link" href="#">
                        <i class="icon material-icons md-admin_panel_settings"></i>
                        <span class="text">Admin & Roles</span>
                    </a>
                    <div class="submenu">
                        <a class="{{ request()->routeIs('admin.roles.*') ? 'active' : '' }}"
                            href="{{ route('admin.roles.index') }}">
                            Manage Roles
                        </a>
                        <a class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}"
                            href="{{ route('admin.users') }}">
                            Admin Users
                        </a>
                    </div>
                </li>
            @endif

            {{-- Smart Cache --}}
            @if(auth()->user()->isSuperAdmin())
                <li class="menu-item {{ request()->routeIs('admin.cache.*') ? 'active' : '' }}">
                    <a class="menu-link" href="{{ route('admin.cache.index') }}">
                        <i class="icon material-icons md-storage"></i>
                        <span class="text">Smart Cache</span>
                    </a>
                </li>
            @endif

            <br /><br />
    </nav>
</aside>

<header class="main-header navbar">
    <div class="col-nav"
        style="width: 100%; display: flex; justify-content: space-between; align-items: center; padding: 0 20px;">
        <div class="welcome-msg d-none d-md-block" style="flex-grow: 1;">
        </div>

        <div style="display: flex; align-items: center;">
            <button class="btn btn-icon btn-mobile me-auto" data-trigger="#offcanvas_aside"><i
                    class="material-icons md-apps"></i></button>
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link btn-icon darkmode" href="#"> <i class="material-icons md-nights_stay"></i> </a>
                </li>

                <li class="dropdown nav-item">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdownAccount" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">

                        <img class="img-xs rounded-circle" src="{{ Auth::user()->profile_image
    ? asset('assets/uploads/admin_profiles/' . Auth::user()->profile_image)
    : asset('assets/imgs/profile.svg') }}" alt="{{ Auth::user()->name }}">
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownAccount">
                        <li>
                            <a class="dropdown-item" href="{{ route('edit-profile') }}">
                                <i class="material-icons md-perm_identity"></i> Edit Profile
                            </a>
                        </li>

                        <li>
                            <span class="dropdown-item text-muted" style="font-size: 12px;">
                                @if(Auth::user()->isSuperAdmin())
                                    <span class="badge bg-danger">Super Admin</span>
                                @elseif(Auth::user()->role)
                                    <span class="badge bg-primary">{{ Auth::user()->role->name }}</span>
                                @else
                                    <span class="badge bg-secondary">No Role</span>
                                @endif
                            </span>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item text-danger" href="#"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="material-icons md-exit_to_app"></i> Logout
                            </a>
                        </li>
                    </ul>
                </li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>

            </ul>
        </div>
</header>