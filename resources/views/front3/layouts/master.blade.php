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

    <link href="{{ static_asset('theme3/css/vendors.css') }}" rel="stylesheet">
    <link href="{{ static_asset('theme3/css/front.css') }}" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    {!! get_setting('custom_css') !!}
    @yield('styles')
    @stack('styles')
    <style>
    .main-top .main-top-bg {
        background-image: url('../images/HomeCover.jpg');
    }
    </style>
</head>
{{-- <body oncontextmenu="return false" onselectstart="return false" ondragstart="return false"></body> --}}


<body>
    {{-- Header --}}
    @include('front3.layouts.header')


    <div class="page-wrapper" style="min-height: 60vh">
        @yield('content')
    </div>
    {{-- Mobile Menu --}}
    @include('front3.layouts.footer')

    {{-- Scripts --}}
    <script src="{{ static_asset('theme3/js/front.js') }}"></script>

    @include('alerts.scripts')
    @stack('scripts')

    {!! get_setting('custom_js') !!}
</body>
</html>
