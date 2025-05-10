@extends('front.layouts.master')
@section('title', 'FAQs')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-7">
                <div class="d-card">
                <div class="d-card-body" id="dc-body">
                    <div class="dash-sss">
                        @foreach ($faqs as $item)
                        <div class="sss-tab">
                            <div class="sss-htab">
                                <div class="row">
                                    <div class="col">
                                    <h6 style="font-weight:600">{{$item->question}}</h6>
                                    </div>
                                    <div class="col-auto align-self-center right-p">
                                        <i class="fa fa-chevron-up"></i>
                                        <i class="fa fa-chevron-down"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="ss-tab-content">
                                {{$item->answer}}
                            </div>
                        </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@section('breadcrumb')
<div class="d-card dc-dash">
    <div class="row">
        <div class="col-lg-7 col-md-9 col-12">
            <div class="py-3 px-5">
                <div class="dch-title">
                   @yield('title')
                </div>
                <div class="dch-text">
                    If you cannot find what you are looking for, please open a <a href="{{route('user.tickets')}}">Support Ticket. </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection




@section('styles')
<style>

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
    color: #6642be;
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
    background: #6642be;
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

.btn.btn-primary {
    background: #6642be;
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
    border: 2px solid #6642be;

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
    color: #000;
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
    border: 2px solid #6642be;
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
    border-radius: 50px;
    color: #6642be;
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
    background: #6642be94;
    border-radius: 30px;
    padding: 20px;
}

.home-box-2 .home-phone2 .iphone {
    position: absolute;
    margin-left: auto;
    margin-right: 0;
    left: 0;
    right: 0;
    background: #6642be94;
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
    background: #6642be;
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
    background: #6642be;
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


















</style>
@endsection




