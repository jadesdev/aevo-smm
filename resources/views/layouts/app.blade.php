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

    <link rel="shortcut icon" href="{{my_asset(get_setting('favicon'))}}">
    <!-- Page Title  -->
    <title>{{get_setting('title')}}</title>

    <link rel="stylesheet" href="{{static_asset('kits/bootstrap/css/bootstrap.min.css')}}">
    <!-- fa-icons -->
    <link rel="stylesheet" type="text/css" href="{{static_asset('css/icons.min.css')}}">
    <!-- main.css -->
    <link rel="stylesheet" href="{{static_asset('css/main.css')}}">
    <link rel="stylesheet" href="{{static_asset('css/custom.css')}}">
    <link rel="stylesheet" href="{{static_asset('css/snackbar.min.css')}}">
    @yield('styles')
    <style>
    .main-top .main-top-bg {
        background-image: url({{static_asset('img/main-bg.png')}});
    }
    </style>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
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


<body class="">
    {{-- Header --}}
    @include('front.layouts.header')

    <div class="main-top">
        <div class="main-top-bg"></div>
        {{-- Page Content --}}
        @yield('content')
    </div>
    {{-- Mobile Menu --}}
    @include('front.layouts.footer')


    <script src="{{static_asset('js/jquery.min.js')}}"></script>
    <!-- bootstrap -->
    <script src="{{static_asset('kits/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- main.js -->
    <script src="{{static_asset('js/main1.js')}}"></script>
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
