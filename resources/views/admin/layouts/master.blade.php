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

    <title>{{get_setting('title')}} - @yield('title')</title>
    <link rel="shortcut icon" href="{{my_asset(get_setting('favicon'))}}">

    <link rel="stylesheet" href="{{static_asset('kits/bootstrap/css/bootstrap.min.css')}}">
    <!-- fa-icons -->
    <link rel="stylesheet" type="text/css" href="{{static_asset('css/icons.min.css')}}">
    <!-- main.css -->
    <link rel="stylesheet" href="{{static_asset('css/select2.min.css')}}">
    <link rel="stylesheet" href="{{static_asset('css/aevosmm.css')}}">
    <link rel="stylesheet" href="{{static_asset('css/custom.css')}}">
    <link rel="stylesheet" href="{{static_asset('css/snackbar.min.css')}}">
    @yield('styles')

</head>
{{-- <body oncontextmenu="return false" onselectstart="return false" ondragstart="return false"></body> --}}


<body class="dashboard-body dark">
    <div class="app-container">
        {{-- Sidebar --}}
        @include('admin.layouts.sidebar')
        {{-- Header --}}
        @include('admin.layouts.header')
        <div class="app-content">
            <div class="container-fluid">
                {{-- Breadcrumb --}}
                @yield('breadcrumb')
                {{-- Content --}}
                @yield('content')
            </div>
        </div>
    </div>


    {{-- Mobile Menu --}}

    <script src="{{static_asset('js/jquery.min.js')}}"></script>
    <!-- bootstrap -->
    <script src="{{static_asset('kits/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- main.js -->
    <script src="{{static_asset('js/main.js')}}"></script>
    <script src="{{static_asset('js/snackbar.min.js')}}"></script>
    <script src="{{static_asset('js/select2.min.js')}}"></script>
    <script src="{{static_asset('js/sweetalert.min.js')}}"></script>
    @stack('scripts')
    <script>
        $(document).ready(function() {
            $('.delete-btn').on('click', function(e) {
                e.preventDefault();

                // Get the custom message from the data-message attribute
                var message = "Do you really want to delete this?";

                // Show a confirmation popup with the custom message
                swal({
                    title: "Are you sure?",
                    text: message,
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                    })
                    .then((willDelete) => {
                    if (willDelete) {
                        window.location.href = $(this).attr('href');
                        // swal("Poof! Your selected option has been deleted!", {
                        //     icon: "success",
                        // });
                    } else {
                        swal("You canceled the operation!");
                    }
                });
            });
        });
    </script>
    <script type="text/javascript">
        @if(Session::get('success'))
        // Snackbar.show({
        //     text: '{{Session::get('success')}}',
        //     pos: 'top-right',
        //     backgroundColor: '#38c172'
        // });
        swal("Successful", '{{Session::get('success')}}', "success");
        @endif
        @if(Session::get('error'))
        // Snackbar.show({
        //     text: '{{Session::get('error')}}',
        //     pos: 'top-right',
        //     backgroundColor: '#e3342f'
        // });
        // swal("Error!", '{{Session::get('error')}}', "warning");

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

<style>

textarea {
  overflow: auto;
  resize: vertical;
  min-height: 150px !important;
  padding: 15px 25px !important;
}

body.dark .table td {
    color: #000;
    border-color: #313131 !important;
}

.app-container .app-sidebar .sidebar-content .sidebar-menu>li a {
    height: 35px;

}

body.dark .table td {
    color: #000;
    border-color: #e4e4e4 !important;
}
.table thead.white {
    font-size: 15px;
    color: #000000;
    font-weight: 700;
    background: transparent;
}
.table th, .table thead th, .catetitle td {
    border: none;
    font-size: 10px;
}
@media screen and (max-width: 991.98px) {
    body.dark .app-mtable .app-block .app-col:before {

        color: #000;
           }
    }
    
    @media screen and (max-width: 991.98px) {
    body.dark .app-mtable .app-block {
        background: #ffffff;
    }
}



body.dark .app-mtable .app-block:nth-child(odd) {
    background: #ffffff;
    color: #000;
}

body.dark .thead-tr, body.dark .thead-tr th {
    background-color: transparent;
    color: #000;
}

body.dark {
    background: #ffffff;
}

.header .header-menu ul li a {
    color: #000;
  
}

.login-card {
    background: #fff;
    border-radius: 15px;
    margin-top: 50px;
}

.header .header-menu ul li a:hover {
    color: #ff401a;
}

.head-text p {
    font-size: 14px;
    line-height: 18px;
    color: #000;
    margin-top: 20px;
    font-weight: 300;
}

.head-text h1 span {
    line-height: 50px !important;
    font-weight: 700;
    font-size: 46px !important;
}

.main-stats .home-stat i {
   font-size: 25px;
    background: #ff401a;
    width: 50px;
    height: 50px;
    text-align: center;
    line-height: 50px;
    color: #fff;
    border-radius: 50px;
    -webkit-box-shadow: none;
    box-shadow: none;
}

.main-stats .hstat-text {
   font-size: 20px;
    font-weight: 800;
    color: #000;
}

.main-stats {
    padding: 35px 0 0 0;
    font-size: 18px;
}

.main-stats .hstat-title {
    font-size: 12px;
    font-weight: 400;
    color: #ABBCC5;
}

.header .head-menu .btn.btn-primary {
    -webkit-box-shadow: none;
    box-shadow: none;
}

.header .head-menu .btn {
    font-size: 14px;
    border-radius: 20px;
    padding: 10px 25px;
    font-weight: 400;
}

.main-top {
    width: 100%;
    overflow: hidden;
    position: relative;
    padding: 120px 0 100px 0;
}


.container, .container-lg, .container-md, .container-sm {
   width: 100%;
    max-width: 100%;
    padding: 0 45px;
    overflow: hidden;
}

.card-header {
  border-top: none !important;
}

.btn.btn-primary {
    background: #ff401a;
    color: #fff;
    border: 0;
    border-radius: 20px;
    padding: 9px 20px;
    font-size: 16px;
}


body.dark .btn.btn-outline {
    border: 1px solid #151428;
    color: #151428;
    border-radius: 20px;
    padding: 9px 20px;
    font-size: 16px;
}



.header .site-name img {
    height: 32px !important;
}

.home-menu-btn {
    color:#000;
}



.fcheck label {
    font-size: 12px;
    line-height: 20px;
    font-weight: 400;
    color: #000;
}

.fcheck label::before {
  
    font-size: 12px;
    font-weight: 900;
    height: 15px;
    width: 15px;
    border: 2px solid #ff401a;

}

.frgpass {
    font-size: 12px;
    line-height: 20px;
    font-weight: 400;
    color: #000;
}




body.dark .d-card {
    background: #ffffff;
    color: #000;
}


body.dark .form-group label {
    color: #000 !important;
    font-weight: 600;
    margin: 0;
}

body.dark .form-group .form-control, body.dark pre.code {
    background: #ffffff;
    color: #000;
}

.home-box-2 .detail-box .dt-title {
    font-weight: bold;
    font-size: 22px;
    line-height: 24px;
    color: #000;
    margin-bottom: 4px;
}
.home-box-2 .detail-box .dt-icon {
    height: 50px;
    width: 50px;
    border: 2px solid #ff401a;
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
    border-radius: 50px;
    color: #ff401a;
    font-size: 20px;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
}

.home-box-2 .detail-box .dt-title {
    font-weight: 600;
    font-size: 18px;
    line-height: 18px;
    color: #000;
    margin-bottom: 4px;
}
.home-box-2 .detail-box .dt-text {
    font-size: 12px;
    line-height: 12px;
    color: #000;
    margin-bottom: 0px;
    font-weight: 300;
}

.home-box-2 .detail-box {
    margin: 20px 0;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    cursor: pointer;
    transition: 500ms all;
    
}

.home-box-2 .detail-box:hover {
    transform: none;
    transition: none;
}

.home-bottom, .home-box-2 {
    padding: 50px 0 105px 0;
}

.home-box-2 .home-phone .iphone {
    position: absolute;
    margin-left: 0;
    margin-right: auto;
    left: 0;
    right: 0;
    background: #ff401a94;
    border-radius: 30px;
    padding: 20px;
}

.home-box-2 .home-phone2 .iphone {
    position: absolute;
    margin-left: auto;
    margin-right: 0;
    left: 0;
    right: 0;
    background: #ff401a94;
    border-radius: 30px;
    padding: 20px;
}

.home-box-2 .home-phone {
    position: relative;
    padding-top: 20px;
}

.soclog {
    height: 60px;
}

.text-container {
    font-size: 13px;
    font-weight: 300;
    margin-top: 15px;
}

.footer {
    background: black;
    padding: 20px;
}

.footer .footer-links {
    font-size: 14px;
}












@media (max-width: 600px) {
.container, .container-lg, .container-md, .container-sm {
    max-width: 100%;
    padding: 0 15px;
    overflow: hidden;
}

.mh {
    
    display:none;
}

.btn.btn-primary {
    background: #ff401a;
    color: #fff;
    border: 0;
    border-radius: 20px;
    padding: 8px 15px;
    font-size: 14px;
}


body.dark .btn.btn-outline {
    border: 1px solid #151428;
    color: #151428;
    border-radius: 20px;
    padding: 8px 15px;
    font-size: 14px;
}

.head-text p {
    font-size: 14px;
    line-height: 18px;
    color: #000;
    margin-top: 10px;
    font-weight: 300;
    text-align:left;
}

.header .header-menu ul li a {
    color: #000;
    text-align: center;
    padding-bottom: 35px;
}


.head-menu {
    line-height:1;
    background-color: #fff;
    -webkit-box-shadow: none;
    box-shadow: none;
    padding: 0 30px;
    z-index: 1003;
    overflow-y: auto;
    border-radius:0;
}

.head-text h1  span {
    line-height: 35px !important;
    font-weight: 600 !important;
    font-size: 30px !important;
    text-align:left;
}

.head-text h1  {
  
    text-align:left;
}

.login-card {
    background: #fff;
    border-radius: 15px;
    margin-top: 40px;
}

    .main-stats {
        display: block;
    }


.main-stats .home-stat i {
   font-size: 20px;
    background: #ff401a;
    width: 40px;
    height: 40px;
    text-align: center;
    line-height: 40px;
    color: #fff;
    border-radius: 50px;
    -webkit-box-shadow: none;
    box-shadow: none;
}

.main-stats .hstat-text {
   font-size: 16px;
    font-weight: 800;
    color: #000;
}

.main-stats {
    padding: 10px 0 0 0;
    font-size: 18px;
}

.main-stats .hstat-title {
    font-size: 10px;
    font-weight: 400;
    color: #ABBCC5;
}

.home-bottom, .home-box-2 {
    padding: 30px 0 30px 0 !important;
}




}





body.dark .form-group label {
    color: #000;
    font-weight: 600;
    margin: 0;
}

</style>

</body>
</html>
