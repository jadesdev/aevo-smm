<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="index,follow">
    <meta name="description" content="Boost your social media presence with the help of AI.">
    <meta name="keywords" content="SMM Provider powered by AI, Smm Services in Dubai, SMM Services USA, Organic social media growth, Smm servces in Africa, Get tiktok likes, smm services delray beach, paypal smm panel,tiktok likes generator ">
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="Website" >
    <meta property="og:title" content="@yield('title') - SMM Provider powered by AI" >
    <meta property="og:image" content="{{my_asset(get_setting('logo'))}}" >
    <meta property="og:description" content="{{get_setting('description')}} " >
    <meta property="og:site_name" content="{{get_setting('title') }}" >
    <!-- Twitter Card data -->
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="@yield('title') - SMM Provider powered by AI">
    <meta name="twitter:description" content="{{get_setting('description')}} ">
    <meta name="twitter:image" content="{{ my_asset(get_setting('logo')) }}">

    <link rel="shortcut icon" href="{{my_asset(get_setting('favicon'))}}">
    <!-- Page Title  -->
    <title>@yield('title') - Best SMM Panel Powered by AI</title>

    <link rel="stylesheet" href="{{static_asset('kits/bootstrap/css/bootstrap.min.css')}}">
    <!-- fa-icons -->
    <link rel="stylesheet" type="text/css" href="{{static_asset('css/icons.min.css')}}">
    <!-- main.css -->
    <link rel="stylesheet" href="{{static_asset('css/aevosmm.css')}}">
    {{-- <link rel="stylesheet" href="{{static_asset('css/custom.css')}}"> --}}
    <link rel="stylesheet" href="{{static_asset('css/snackbar.min.css')}}">
    @yield('styles')
    <style>
    .main-top .main-top-bg {
        background-image: url('../images/HomeCover.jpg');
    }
    </style>
</head>
{{-- <body oncontextmenu="return false" onselectstart="return false" ondragstart="return false"></body> --}}


<body class="dark">
    {{-- Header --}}
    @include('front.layouts.header')

    <div class="main-top">
        <div class="main-top-bg"></div>
        {{-- Page Content --}}
        @yield('content')
    </div>
    {{-- Mobile Menu --}}
    @include('front.layouts.footer')

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-QL8FFT9X94"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-QL8FFT9X94');
</script>

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
