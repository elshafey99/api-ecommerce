<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            @php
                $setting = \App\Models\Setting::first();
            @endphp
            <li class="nav-item me-auto"><a class="navbar-brand" href="{{ route('dashboard.home') }}"><span
                        class="brand-logo"><img src="{{ asset($setting->logo) }}"></span>
                    <h2 class="brand-text">{{ $setting->site_name }}</h2>
                </a></li>
            <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pe-0" data-bs-toggle="collapse"><i
                        class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i
                        class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc"
                        data-ticon="disc"></i></a></li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class="nav-item @yield('dashboard-active')"><a class="d-flex align-items-center"
                    href="{{ route('dashboard.home') }}"><i data-feather="home"></i><span
                        class="menu-title text-truncate" data-i18n="Email">{{ __('dashboard.home') }}</span></a>
            </li>
            <li class=" navigation-header"><span data-i18n="Apps &amp; Pages">Apps &amp; Pages</span><i
                    data-feather="more-horizontal"></i>
            </li>

            @can('roles')
                <li class="nav-item @yield('roles-active')">
                    <a class="d-flex align-items-center" href="{{ route('dashboard.roles.index') }}">
                        <i data-feather='shield'></i>
                        <span class="menu-title text-truncate">{{ __('dashboard.roles') }}</span>
                    </a>
                </li>
            @endcan

            @can('admins')
                <li class="nav-item @yield('admins-active')">
                    <a class="d-flex align-items-center" href="{{ route('dashboard.admins.index') }}">
                        <i data-feather='users'></i>
                        <span class="menu-title text-truncate">{{ __('dashboard.admins') }}</span>
                        <span
                            class="badge badge-light-warning rounded-pill ms-auto me-1">{{ App\Models\Admin::count() }}</span>
                    </a>
                </li>
            @endcan

            @can('branches')
                <li class="nav-item @yield('branches-active')">
                    <a class="d-flex align-items-center" href="{{ route('dashboard.branches.index') }}">
                        <i data-feather='map-pin'></i>
                        <span class="menu-title text-truncate">{{ __('dashboard.branches') }}</span>
                        <span
                            class="badge badge-light-danger rounded-pill ms-auto me-1">{{ App\Models\Branch::count() }}</span>
                    </a>
                </li>
            @endcan

            @can('brands')
                <li class="nav-item @yield('brands-active')">
                    <a class="d-flex align-items-center" href="{{ route('dashboard.brands.index') }}">
                        <i data-feather='award'></i>
                        <span class="menu-title text-truncate">{{ __('dashboard.brands') }}</span>
                        <span
                            class="badge badge-light-info rounded-pill ms-auto me-1">{{ App\Models\Brand::count() }}</span>
                    </a>
                </li>
            @endcan

            @can('categories')
                <li class="nav-item @yield('categories-active')">
                    <a class="d-flex align-items-center" href="{{ route('dashboard.categories.index') }}">
                        <i data-feather='folder'></i>
                        <span class="menu-title text-truncate">{{ __('dashboard.categories') }}</span>
                        <span
                            class="badge badge-light-success rounded-pill ms-auto me-1">{{ App\Models\Category::count() }}</span>
                    </a>
                </li>
            @endcan

            @can('payment_methods')
                <li class="nav-item">
                    <a class="d-flex align-items-center @yield('paymentmethods-active')"
                        href="{{ route('dashboard.payment-methods.index') }}">
                        <i data-feather='credit-card'></i>
                        <span class="menu-title text-truncate">{{ __('dashboard.payment_methods') }}</span>
                        <span
                            class="badge badge-light-info rounded-pill ms-auto me-1">{{ App\Models\PaymentMethod::count() }}</span>
                    </a>
                </li>
            @endcan

            @can('products')
                <li class="nav-item">
                    <a class="d-flex align-items-center @yield('products-active')" href="{{ route('dashboard.products.index') }}">
                        <i data-feather='package'></i>
                        <span class="menu-title text-truncate">{{ __('dashboard.products') }}</span>
                        <span
                            class="badge badge-light-primary rounded-pill ms-auto me-1">{{ App\Models\Product::count() }}</span>
                    </a>
                </li>
            @endcan

            @can('banners')
                <li class="nav-item @yield('banners-active')">
                    <a class="d-flex align-items-center" href="{{ route('dashboard.banners.index') }}">
                        <i data-feather='image'></i>
                        <span class="menu-title text-truncate">{{ __('dashboard.banners') }}</span>
                        <span
                            class="badge badge-light-success rounded-pill ms-auto me-1">{{ App\Models\Banner::count() }}</span>
                    </a>
                </li>
            @endcan

            @can('faqs')
                <li class="nav-item @yield('faqs-active')">
                    <a class="d-flex align-items-center" href="{{ route('dashboard.faqs.index') }}">
                        <i data-feather='help-circle'></i>
                        <span class="menu-title text-truncate">{{ __('dashboard.faqs') }}</span>
                        <span
                            class="badge badge-light-warning rounded-pill ms-auto me-1">{{ App\Models\Faq::count() }}</span>
                    </a>
                </li>
            @endcan

            @can('pages')
                <li class="nav-item @yield('pages-active')">
                    <a class="d-flex align-items-center" href="{{ route('dashboard.pages.index') }}">
                        <i data-feather='file-text'></i>
                        <span class="menu-title text-truncate">{{ __('dashboard.pages') }}</span>
                        <span
                            class="badge badge-light-info rounded-pill ms-auto me-1">{{ App\Models\Page::count() }}</span>
                    </a>
                </li>
            @endcan



            {{-- @can('users')
                <li class="nav-item @yield('users-open') @yield('createUser-open')"><a class="d-flex align-items-center"
                        href="#"><i data-feather='users'></i><span class="menu-title text-truncate">
                            {{ __('dashboard.users') }}</span>
                        <span class="badge badge-light-warning rounded-pill ms-auto me-1"> {{ App\Models\User::count() }}
                        </span>
                    </a>
                    <ul class="menu-content">
                        <li><a class="@yield('users-active') d-flex align-items-center"
                                href="{{ route('dashboard.users.index') }}"><i data-feather="circle"></i><span
                                    class="menu-item text-truncate"
                                    data-i18n="Roles">{{ __('dashboard.users') }}</span></a>
                        </li>
                    </ul>
                </li>
            @endcan --}}

            {{-- @can('locations')
                <li class="nav-item @yield('locations-active')">
                    <a class="d-flex align-items-center" href="{{ route('dashboard.locations.index') }}">
                        <i data-feather='map'></i>
                        <span class="menu-title text-truncate">{{ __('dashboard.locations') }}</span>
                    </a>
                </li>
            @endcan --}}


            {{-- @can('settings')
                <li class="nav-item @yield('settings-open')"><a class="d-flex align-items-center" href="#">
                        <i data-feather="settings"></i><span class="menu-title text-truncate"
                            data-i18n="Roles &amp; Permission">{{ __('dashboard.settings') }}</span>
                    </a>
                    <ul class="menu-content">
                        <li><a class="@yield('settings-active') d-flex align-items-center"
                                href="{{ route('dashboard.settings') }}"><i data-feather="circle"></i><span
                                    class="menu-item text-truncate"
                                    data-i18n="Roles">{{ __('dashboard.genral-setting') }}</span></a>
                        </li>
                    </ul>
                </li>
            @endcan --}}

        </ul>
    </div>
</div>
