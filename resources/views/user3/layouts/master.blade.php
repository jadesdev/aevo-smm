<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{get_setting('description')}}">
    <meta name="robots" content="index, follow">
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
    <title>@yield('title') - {{get_setting('title')}}</title>

    <link href="{{ static_asset('theme3/css/vendors.css') }}" rel="stylesheet">
    <link href="{{ static_asset('theme3/css/style.css') }}" rel="stylesheet">
    {!! get_setting('custom_css') !!}

    @stack('styles')

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


<body >
    <div class="my--wrapper">
        @include('user3.layouts.sidebar')

        <div class="container-fluid my--container">
            @include('user3.layouts.header')

            {{-- Content --}}
            <section class="neworder">
                @yield('content')
            </section>
        </div>
    </div>

    {{-- Scripts --}}
    <script src="{{ static_asset('theme3/js/vendors.js') }}"></script>
    <script src="{{ static_asset('theme3/js/main.js') }}"></script>
    <script src="{{static_asset('js/loadingoverlay.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/js-loading-overlay@1.1.0/dist/js-loading-overlay.min.js"></script>

    @include('alerts.scripts')
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
