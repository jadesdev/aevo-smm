<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="index,follow">
    <meta name="description" content="{{get_setting('description')}}">
    <meta name="keywords" content="Best Social Media Marketing, Buy followers and likes, Get traffic to your page, Boost Online Presence Nigeria, Grow Followers">
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="Website" >
    <meta property="og:title" content="@yield('title') - {{get_setting('description')}}" >
    <meta property="og:image" content="{{my_asset(get_setting('logo'))}}" >
    <meta property="og:description" content="{{get_setting('description')}} " >
    <meta property="og:site_name" content="{{get_setting('title') }}" >
    <!-- Twitter Card data -->
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="@yield('title') - {{get_setting('title')}}">
    <meta name="twitter:description" content="{{get_setting('description')}} ">
    <meta name="twitter:image" content="{{ my_asset(get_setting('logo')) }}">

    <link rel="shortcut icon" href="{{my_asset(get_setting('favicon'))}}">
    <!-- Page Title  -->
    <title>@yield('title') | {{get_setting('title')}}</title>


    <link href="{{ static_asset('theme4/front/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ static_asset('theme4/front/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ static_asset('theme4/front/css/swiper-bundle.min.css') }}" rel="stylesheet">
    <link href="{{ static_asset('theme4/front/css/jquery.fancybox.min.css') }}" rel="stylesheet">
    <link href="{{ static_asset('theme4/front/css/animate.css') }}" rel="stylesheet">
    <link href="{{ static_asset('theme4/front/css/style.css') }}" rel="stylesheet">

    {!! get_setting('custom_css') !!}
    @yield('styles')
    @stack('styles')
    <style>
    /* .main-top .main-top-bg {
        background-image: url('../images/HomeCover.jpg');
    } */
    /* card style to dark */
    .card{
        background-color: #1B1932 !important;
        color: #fff;
    }
    .card .form-control, .card .form-select{
        background-color: #1B1932 !important;
        color: #fff;
        font-size: 13px;
        padding: 12px 24px;
    }
    .table{color: #dfdbdb}
    </style>
</head>

<body>
    {{-- Header --}}
    @include('front4.layouts.header')


    <div class="page-wrapper" style="min-height: 60vh">
        @yield('content')
    </div>
    {{-- Mobile Menu --}}
    @include('front4.layouts.footer')

    {{-- Scripts --}}
    <script src="{{ static_asset('theme4/front/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ static_asset('theme4/front/js/bootstrap.min.js') }}"></script>
    <script src="{{ static_asset('theme4/front/js/smooth-scroll.js') }}"></script>
    <script src="{{ static_asset('theme4/front/js/gsap.min.js') }}"></script>
    <script src="{{ static_asset('theme4/front/js/jquery.fancybox.min.js') }}"></script>
    <script src="{{ static_asset('theme4/front/js/swiper-bundle.min.js') }}"></script>
    <script src="{{ static_asset('theme4/front/js/wow.min.js') }}"></script>
    {{-- <script src="{{ static_asset('theme3/js/front.js') }}"></script> --}}
    <script src="{{ static_asset('theme4/front/js/scripts.js') }}"></script>

    @include('alerts.scripts')
    @stack('scripts')

    {!! get_setting('custom_js') !!}
</body>
</html>
