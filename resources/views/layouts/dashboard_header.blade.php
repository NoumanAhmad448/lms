<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <title>
        @if (isset($title))
            {{ $title }}
        @else
            {{ config('app.name') }}
        @endif
    </title>
    <meta name="description"
        content="@if (isset($desc)) {{ $desc }} @else {{ __('lms::description.default') }} @endif">
    <meta property="og:title"
        content="@if (isset($title)) {{ $title }} @else {{ config('app.name') }} @endif">
    <meta property="og:description"
        content="@if (isset($desc)) {{ $desc }} @else {{ __('lms::description.default') }} @endif">
    <link rel="canonical" href="{{ url()->current() }}">
    @livewireStyles

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.3/dist/alpine.js" defer></script>

    <!-- line awesome  -->
    <link rel="stylesheet"
        href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    @include('lms::lib.custom_lib')
    @yield('page-css')
</head>

<body>
    @include('lms::modals.modal')
    <div class="d-flex justify-content-between align-items-center px-4 pt-4">
        {{-- @livewire('navigation-dropdown') --}}
        @if (config('setting.show_site_log'))
            <a href="{{ route('index') }}">
                <img src="{{ asset('vendor/lms/img/logo.jpg') }}" alt="lms" class="img-fluid" width="80" />
            </a>
        @endif
        <section class="d-flex align-items-center">
            <a href="{{ route('index') }}" class="mr-3 d-none d-md-block"> {{ __('lms::Student') }} </a>
            <a href="{{ route('dashboard') }}" class="mr-3 d-none d-md-block">
                Your Dashboard
            </a>
            <div class="dropdown mx-3">
                @if (config('setting.login_profile'))
                    <div class="cursor_pointer text-center  pt-2" id="user_menu" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <img height="40" width="40" class="rounded-circle object-cover"
                            src="@include('lms::modals.profile_logo')" />
                    </div>
                @endif
                <div class="dropdown-menu dropdown-menu-right  w-55 mr-4 border" aria-labelledby="user_menu">
                    <a style="font-size: 0.9rem !important" class="pt-2 dropdown-item" href="{{ route('dashboard') }}">
                        {{ __('lms::Dashboard') }}</a>
                    <a style="font-size: 0.9rem !important" class="pt-2 dropdown-item" href="{{ route('i-profile') }}">
                        {{ __('lms::Instructor Profile') }}</a>
                    <a style="font-size: 0.9rem !important" class="pt-2 dropdown-item"
                        href="{{ route('i-payment-setting') }}">
                        {{ __('lms::Withdraw Payment') }}
                        <div class="dropdown-divider"></div>
                        <a style="font-size: 0.9rem !important" class="pt-2 dropdown-item"
                            href="{{ route('profile.show') }}">
                            {{ __('lms::Setting') }}</a>

                        <a style="font-size: 0.9rem !important" class="pt-2 dropdown-item"
                            href="{{ route('public-ann') }}">
                            {{ __('lms::Public Announcement') }}</a>
                        <a style="font-size: 0.9rem !important" class="pt-2 dropdown-item"
                            href="{{ route('purHis') }}">
                            {{ __('lms::Earning History') }}</a>
                        <a style="font-size: 0.9rem !important" class="pt-1 dropdown-item"
                            href="{{ route('logout') }}"> {{ __('lms::Logout') }}</a>
                </div>
            </div>
        </section>
    </div>
    <!-- Page Heading -->
    <header class="bg-white">
        <div class="mt-3 ml-3">
            @yield('header')
        </div>
    </header>

    <!-- Page Content -->
    <main>
        @yield('content')
    </main>
    </div>

    {{-- @stack('modals') --}}
    {{-- @livewireScripts --}}

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
    </script>
    @yield('page-js')
    <script src="{{ asset('vendor/lms/js/main.js') }}"></script>
</body>

</html>
