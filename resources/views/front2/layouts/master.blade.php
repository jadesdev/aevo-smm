<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="index,follow">
    <meta name="description" content="Boost your social media presence in Nigeria with our tailored follower, like, and retweet services. Best SMM Panel in Nigeria, Best SMM Panel, Enhance visibility and engagement on Instagram, Twitter, Facebook, and TikTok effortlessly. Trusted by Nigerian influencers and businesses for targeted audience growth. Best Africa's Social Media Marketing Service Provider. Get started today!">
    <meta name="keywords" content="Best Social Media Marketing Nigeria, Buy followers and likes, Get traffic to your page, Boost Online Presence Nigeria, Grow Followers in Nigeria">
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
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700&amp;display=swap&amp;subset=latin-ext" rel="stylesheet">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <meta name="google-site-verification" content="VppAyorZpcOjyrwGvQO_t7S4EvCAVzbXz01msgFnmsw" />

    <link rel="shortcut icon" href="{{my_asset(get_setting('favicon'))}}">
    <!-- Page Title  -->
    <title>@yield('title') - Best Social Media Marketing Platform in Nigeria</title>

    <script src="{{static_asset("theme2/js/vendors/jquery-3.2.1.min.js")}}"></script>
    <link rel="stylesheet" href="{{static_asset('theme2/css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{static_asset('theme2/css/fontawesome-all.css')}}">
    <link rel="stylesheet" href="{{static_asset('theme2/css/swiper.css')}}">
    <link rel="stylesheet" href="{{static_asset('theme2/css/monoka.css')}}">
    <!-- AOS -->
    <link rel="stylesheet" type="text/css" href="{{static_asset('theme2/plugins/aos/dist/aos.css')}}">
    {{-- <link rel="stylesheet" href="{{static_asset('css/custom.css')}}"> --}}
    <link rel="stylesheet" href="{{static_asset('css/snackbar.min.css')}}">

    {!! get_setting('custom_css') !!}
    @yield('styles')
    <style>
    .main-top .main-top-bg {
        background-image: url({{static_asset('img/main-bg.png')}});
    }
    </style>

    <script type="application/ld+json">
  {
    "@context": "http://schema.org",
    "@type": "WebPage",
    "aggregateRating": {
      "@type": "AggregateRating",
      "ratingValue": "4.5",
      "reviewCount": "3000"
    }
  }
  </script>
</head>
{{-- <body oncontextmenu="return false" onselectstart="return false" ondragstart="return false"></body> --}}


<body class="" data-spy="scroll" data-target=".fixed-top">
    {{-- Header --}}
    @include('front2.layouts.header')

    <div class="main-top">
        <div class="main-top-bg"></div>
        {{-- Page Content --}}
        @yield('content')
    </div>
    {{-- Mobile Menu --}}
    @include('front2.layouts.footer')


    <script type="text/javascript" src="{{static_asset('theme2/js/vendors/bootstrap.bundle.min.js')}}"></script>
    <script type="text/javascript" src="{{static_asset('theme2/js/vendors/jquery.sparkline.min.js')}}"></script>
    <script type="text/javascript" src="{{static_asset('theme2/js/core.js')}}"></script>
    <script type="text/javascript" src="{{static_asset('theme2/js/swiper.min.js')}}"></script>
    <script type="text/javascript" src="{{static_asset('theme2/js/monoka.js')}}"></script>
    <script src="{{static_asset('theme2/plugins/aos/dist/aos.js')}}"></script>

    <script>
      AOS.init();
    </script>

    <!-- Script js -->
    <script src="{{static_asset('theme2/js/process.js')}}"></script>

    <script src="{{static_asset('js/snackbar.min.js')}}"></script>
    <script src="{{static_asset('js/sweetalert.min.js')}}"></script>
    @stack('scripts')
    <script type="text/javascript">
        @if(Session::get('success'))
        Snackbar.show({
            text: '{{Session::get('success')}}',
            pos: 'top-right',
            backgroundColor: '#38c172'
        });
        swal("Successful", '{{Session::get('success')}}', "success");
        @endif
        @if(Session::get('error'))
        Snackbar.show({
            text: '{{Session::get('error')}}',
            pos: 'top-right',
            backgroundColor: '#e3342f'
        });
        swal("Error!", '{{Session::get('error')}}', "warning");

        @endif
        @if(count($errors) > 0)
        Snackbar.show({

            @foreach($errors->all() as $error)
            text: '{{$error}}',
                @endforeach
            pos: 'top-left',
            backgroundColor: '#e3342f'
        });
        @endif
    </script>
    {!! get_setting('custom_js') !!}
</body>
</html>
