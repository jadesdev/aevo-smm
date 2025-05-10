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
    <meta property="og:type" content="Website">
    <meta property="og:title" content="@yield('title') - {{ get_setting('description') }}">
    <meta property="og:image" content="{{ my_asset(get_setting('logo')) }}">
    <meta property="og:description" content="{{ get_setting('description') }} ">
    <meta property="og:site_name" content="{{ get_setting('title') }}">
    <!-- Twitter Card data -->
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="@yield('title') - {{ get_setting('title') }}">
    <meta name="twitter:description" content="{{ get_setting('description') }} ">
    <meta name="twitter:image" content="{{ my_asset(get_setting('logo')) }}">
  <meta name="google-site-verification" content="VppAyorZpcOjyrwGvQO_t7S4EvCAVzbXz01msgFnmsw" />  
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700&amp;display=swap&amp;subset=latin-ext"
        rel="stylesheet">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">

    <link rel="shortcut icon" href="{{ my_asset(get_setting('favicon')) }}">
    <!-- Page Title  -->
    <title>@yield('title') - Best Social Media Marketing Platform in Nigeria</title>

    <link rel="stylesheet" href="{{ static_asset('theme2/css/core.css') }}">
    <link rel="stylesheet" href="{{ static_asset('theme2/css/fontawesome-all.css') }}">
    <link rel="stylesheet" href="{{ static_asset('theme2/plugins/jquery-toast/css/jquery.toast.css') }}">
    <link rel="stylesheet" href="{{ static_asset('theme2/plugins/boostrap/colors.css') }}">
    <link rel="stylesheet" href="{{ static_asset('theme2/css/util.css') }}">
    <link rel="stylesheet" href="{{ static_asset('theme2/css/general_page.css') }}">
    <link rel="stylesheet" href="{{ static_asset('theme2/css/layout.css') }}">
    <link rel="stylesheet" href="{{ static_asset('theme2/css/footer.css') }}">
    <!-- fa-icons -->
    {{-- <link rel="stylesheet" href="{{static_asset('css/custom.css')}}"> --}}
    <link rel="stylesheet" href="{{ static_asset('css/snackbar.min.css') }}">
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
    
</head>
{{-- <body oncontextmenu="return false" onselectstart="return false" ondragstart="return false"></body> --}}


<body>
    <div id="page-overlay" class="visible incoming">
        <div class="loader-wrapper-outer">
            <div class="loader-wrapper-inner">
                <div class="lds-double-ring">
                    <div></div>
                    <div></div>
                    <div>
                        <div></div>
                    </div>
                    <div>
                        <div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Header --}}
    @include('front2.layouts.header2')

    <div class="page p-t-70">
        <div class="page-main">
          <div class="my-3 my-md-5">
            <div class="container"">
                {{-- Page Content --}}
                @yield('content')
            </div>
          </div>
        </div>
    </div>

    <footer class="footer footer_bottom dark">
        <div class="container">
            <div class="row align-items-center flex-row-reverse">
                <div class="col-auto ml-lg-auto">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <ul class="list-inline mb-0">
                                <li class="list-inline-item">
                                    <a href="#" target="_blank" class="btn btn-icon btn-facebook"><i class="fab fa-facebook"></i></a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="#" target="_blank" class="btn btn-icon btn-instagram"><i class="fab fa-instagram"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-auto mt-3 mt-lg-0 text-center">
                    Copyright © {{date('Y')}} - {{get_setting('title')}}. All Rights Reserved.
                </div>
            </div>
        </div>
    </footer>

    <script src="{{ static_asset('theme2/js/vendors/jquery-3.2.1.min.js') }}"></script>
    <script src="{{static_asset('theme2/js/vendors/bootstrap.bundle.min.js')}}"></script>
    <script src="{{static_asset('theme2/js/vendors/jquery.sparkline.min.js')}}"></script>
    <script src="{{static_asset('theme2/js/core.js')}}"></script>
    <!-- general JS -->
    <script src="{{static_asset('theme2/js/process.js')}}"></script>

    <script src="{{ static_asset('js/snackbar.min.js') }}"></script>
    <script src="{{ static_asset('js/sweetalert.min.js') }}"></script>
    @stack('scripts')
    <script type="text/javascript">
        @if (Session::get('success'))
            Snackbar.show({
                text: '{{ Session::get('success') }}',
                pos: 'top-right',
                backgroundColor: '#38c172'
            });
            swal("Successful", '{{ Session::get('success') }}', "success");
        @endif
        @if (Session::get('error'))
            Snackbar.show({
                text: '{{ Session::get('error') }}',
                pos: 'top-right',
                backgroundColor: '#e3342f'
            });
            swal("Error!", '{{ Session::get('error') }}', "warning");
        @endif
        @if (count($errors) > 0)
            Snackbar.show({

                @foreach ($errors->all() as $error)
                    text: '{{ $error }}',
                @endforeach
                pos: 'top-left',
                backgroundColor: '#e3342f'
            });
        @endif
    </script>
    {!! get_setting('custom_js') !!}
</body>

</html>
