
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

 <meta name="google-site-verification" content="VppAyorZpcOjyrwGvQO_t7S4EvCAVzbXz01msgFnmsw" />

    <link rel="shortcut icon" href="{{my_asset(get_setting('favicon'))}}">
    <!-- Page Title  -->
    <title>@yield('title') | Best Panel in World Powered by AI</title>

    <link rel="stylesheet" href="{{static_asset('kits/bootstrap/css/bootstrap.min.css')}}">
    <!-- fa-icons -->
    <link rel="stylesheet" type="text/css" href="{{static_asset('css/icons.min.css')}}">
    <!-- main.css -->
    <link rel="stylesheet" href="{{static_asset('css/select2.min.css')}}">
    <link rel="stylesheet" href="{{static_asset('css/aevosmm.css')}}">
    <link rel="stylesheet" href="{{static_asset('css/custom.css')}}">
    <link rel="stylesheet" href="{{static_asset('css/snackbar.min.css')}}">
    @yield('styles')

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
  @include('user.layouts.header-styles')

</head>
{{-- <body oncontextmenu="return false" onselectstart="return false" ondragstart="return false"></body> --}}


<body class="light">
    <div class="app-container">
        {{-- Sidebar --}}
        @include('user.layouts.sidebar')
        {{-- Header --}}
        @include('user.layouts.header')
        <div class="app-content">
            <div class="container-fluid">
                {{-- Breadcrumb --}}
                @yield('breadcrumb')
                {{-- Content --}}
                <section class="neworder">
                    @yield('content')
                </section>
            </div>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <nav class="mob-nav">
        <ul class="mob-nav-link">
            <li>
                <a href="{{route('user.services')}}">
                    <i class="fa fa-tags"></i>
                    <span>Services</span>
                </a>
            </li>
            <li>
                <a href="{{route('user.deposit')}}">
                    <i class="fa fa-wallet"></i>
                    <span>Add Balance</span>
                </a>
            </li>
            <li>
                <a href="{{route('user.orders.create')}}" class="active">
                    <i class="fa fa-edit"></i>
                    <span>Place Order</span>
                </a>
            </li>
            <li>
                <a href="{{route('user.orders.index')}}">
                    <i class="fa fa-shopping-bag"></i>
                    <span>Orders</span>
                </a>
            </li>
            <li>
                <a href="{{route('user.tickets')}}">
                    <i class="fa fa-ticket"></i>
                    <span>Support</span>
                </a>
            </li>
        </ul>
    </nav>


    <script src="{{static_asset('js/jquery.min.js')}}"></script>
    <!-- bootstrap -->
    <script src="{{static_asset('kits/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- main.js -->
    <script src="{{static_asset('js/main.js')}}"></script>
    <script src="{{static_asset('js/select2.min.js')}}"></script>
    <script src="{{static_asset('js/snackbar.min.js')}}"></script>
    <script src="{{static_asset('js/sweetalert.min.js')}}"></script>
    <script src="{{static_asset('js/loadingoverlay.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/js-loading-overlay@1.1.0/dist/js-loading-overlay.min.js"></script>
    @stack('scripts')
    <script type="text/javascript">
        JsLoadingOverlay.setOptions({
            "overlayBackgroundColor": "#F7F7F7",
            "overlayOpacity": "1",
            "spinnerIcon": "ball-fussion",
            "spinnerColor": "#D6842E",
            "spinnerSize": "2x",
            "overlayIDName": "overlay",
            "spinnerIDName": "spinner",
            "offsetX": 0,
            "offsetY": 0,
            "containerID": null,
            "lockScroll": true,
            "overlayZIndex": 9998,
            "spinnerZIndex": 9999
        });
        @if(Session::get('success'))
        Snackbar.show({
            text: '{!! Session::get('success') !!}',
            pos: 'top-right',
            backgroundColor: '#38c172'
        });
        var content2 = document.createElement('div');
        content2.innerHTML = `{!! Session::get('success') !!}`;
        swal({
            title: "Successful",
            content: content2,
            icon: "success"
        });
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
        function copyFunction(element)
        {
            var aux = document.createElement("input");
            // Assign it the value of the specified element
            aux.setAttribute("value", element);
            document.body.appendChild(aux);
            aux.select();
            document.execCommand("copy");
            document.body.removeChild(aux);
            swal("Successful", 'Content Was Copied Successfully', "success");
        }
        $(".sub-form").submit(function(event){
            JsLoadingOverlay.show();
        });

    </script>
    {!! get_setting('custom_js') !!}
</body>
</html>
