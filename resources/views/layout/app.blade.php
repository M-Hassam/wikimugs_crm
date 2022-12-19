<!DOCTYPE html>
<html lang="zxx" class="js">

<head>
    @include('layout.includes.head')
</head>

<body class="nk-body bg-lighter npc-general has-sidebar ">
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            @if (auth()->check())
            <!-- sidebar @s -->
            <div class="nk-sidebar nk-sidebar-fixed {{-- is-dark --}} " data-content="sidebarMenu">
                <div class="nk-sidebar-element nk-sidebar-head">
                    <div class="nk-menu-trigger">
                        <a href="#" class="nk-nav-toggle nk-quick-nav-icon d-xl-none" data-target="sidebarMenu"><em class="icon ni ni-arrow-left"></em></a>
                        <a href="#" class="nk-nav-compact nk-quick-nav-icon d-none d-xl-inline-flex" data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a>
                    </div>
                    <div class="nk-sidebar-brand">
                        <a href="{{ route('dashboard') }}" class="logo-link nk-sidebar-logo">
                            <img class="logo-light logo-img" src="{{ asset('template/src/images/logo.png') }}" alt="logo">
                            <img class="logo-dark logo-img" src="{{ asset('template/src/images/logo-dark.png') }}" alt="logo-dark">
                        </a>
                    </div>
                </div><!-- .nk-sidebar-element -->
                <div class="nk-sidebar-element nk-sidebar-body">
                    <div class="nk-sidebar-content">
                        @include('layout/includes/nav')
                    </div>
                </div>
            </div>
            @endif
            <div class="nk-wrap ">
                @if (auth()->check())
                @include('layout.includes.header')
                @endif
                <div class="nk-content ">
                    @include('layout.includes.message')
                    @yield('content')
                </div>
                @if (auth()->check())
                <div class="nk-footer">
                    @include('layout.includes.footer')
                </div>
                @endif
            </div>
        </div>
    </div>
    @yield('modal')

    <!-- JavaScript -->
    @include('layout.includes.scripts')    
    
    <!-- custom scripts on page -->
    @stack('scripts')
    @include('layout.includes.custom-scripts')    

</body>

</html>