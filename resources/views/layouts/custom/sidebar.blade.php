<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <div class="sb-sidenav-menu-heading">Core</div>
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Dashboard
                    </a>
                    <div class="sb-sidenav-menu-heading">Interface</div>
                    @php
                        $pagesActive =
                            request()->routeIs('blogs.*') ||
                            request()->routeIs('vehicles.*') ||
                            request()->routeIs('users.*');
                    @endphp

                    <a class="nav-link collapsed {{ $pagesActive ? '' : '' }}" href="#" data-bs-toggle="collapse"
                        data-bs-target="#collapseLayouts" aria-expanded="{{ $pagesActive ? 'true' : 'false' }}"
                        aria-controls="collapseLayouts">
                        <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                        Pages
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>

                    <div class="collapse {{ $pagesActive ? 'show' : '' }}" id="collapseLayouts"
                        aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">

                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link {{ request()->routeIs('blogs.*') ? 'active' : '' }}"
                                href="{{ route('blogs.index') }}">{{ __('Blog') }}</a>

                            <a class="nav-link {{ request()->routeIs('vehicles.*') ? 'active' : '' }}"
                                href="{{ route('vehicles.index') }}">{{ __('Kenderaan') }}</a>

                            <a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}"
                                href="{{ route('users.index') }}">{{ __('Pengguna') }}</a>
                        </nav>

                    </div>
                </div>
            </div>
            <div class="sb-sidenav-footer">
                <div class="small">Log Masuk Sebagai : </div>
                {{ auth()->user()->name }}
            </div>
        </nav>
    </div>
    <div id="layoutSidenav_content">
        <main>
            @yield('content')
        </main>
        @include('layouts.custom.footer')
    </div>
</div>
