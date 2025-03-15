<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        @if (isset($title))
            {{ __('lms::messages.' . $title) }}
        @else
            {{ __('lms::messages.admin') }}
        @endif
    </title>
    <meta name="description"
        content="@if (isset($desc)) {{ $desc }} @else {{ __('lms::description.default') }} @endif">
    <link rel="canonical" href="{{ url()->current() }}">
    <link rel="shortcut icon" href="{{ asset('vendor/lms/img/favicon.png') }}">

    @include('lms::lib.custom_lib')

    @yield('page-css')
</head>

<body class="d-flex flex-column" style="min-height: 90%">
    <nav class="navbar bg-website">
        @if (config('setting.show_site_log'))
            <a class="navbar-brand text-white" href="{{ route('a_home') }}">
                {{ __('lms::messages.site_name') }}
            </a>
        @endif
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link text-white" href="{{ route('index') }}" target="_blank">
                    <i class="fa fa-home" aria-hidden="true"></i> Home </a>
            </li>
        </ul>
        @if (config('setting.login_profile'))
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('a_logout') }}">
                        <i class="fa fa-sign-out" aria-hidden="true"></i> Logout </a>
                </li>
            </ul>
        @endif
    </nav>
    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-md-3">
                <i class="fa fa-bars d-md-none" aria-hidden="true" id="hamburger"></i>
                <ul class="nav flex-column d-none d-md-block border-right" id="side_menu">
                    <li class="nav-item">
                        <a class="nav-link text-dark " href="{{ route('draft_course') }}" id="draft_courses"> <i
                                class="fa fa-deaf" aria-hidden="true"></i>
                            Draft Courses </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark " href="{{ route('p_courses') }}" id="published_courses"> <i
                                class="fa fa-video-camera" aria-hidden="true"></i>
                            Published Courses </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark " href="{{ route('i_new_courses') }}" id="i_new_courses"> <i
                                class="fa fa-video-camera" aria-hidden="true"></i>
                            New Courses </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark " href="{{ route('admin_view_categories') }}" id="a_c">
                            <i class="fa fa-filter" aria-hidden="true"></i>
                            Categories
                        </a>
                    </li>
                </ul>
            </div>

            <div class="col-md-9">
                @yield('content')
            </div>
        </div>
    </div>

    @yield('footer')
