@extends('front.layouts.master')

@section('title', get_setting('title'))

@section('content')
{{-- Login Page --}}
<div class="container" style="position: relative;">

    <div class="main-top-real-content">
        <div class="row align-items-center">
            <div class="col-lg-6 align-self-center">
                <div class="head-text">
                    <h1><span class="" style="">{{get_setting('about')}}</span></h1>
                    <p>{{get_setting('description')}}.</p>
                </div>
                <div class="head-links row mt-2" style="display:none;">
                    <div class="col-auto mb-4 mb-md-0" style="text-align:left;">
                        <a href="{{route('signup')}}" class="btn btn-primary btn-lg" style="margin-right:10px;" >Get Started </a>
                        
                        <a href="{{route('faq')}}" class="btn btn-outline btn-lg">How It Works?</a>
                    </div>
                    <div class="col-auto">
                        
                    </div>
                </div>
                <div class="main-stats mx-2">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 mb-4 col-6">
                            <div class="home-stat">
                                <div class="row">
                                    <div class="col-auto align-self-center"style="padding: 0 8px;">
                                        <i class="fa fa-rocket"></i>
                                    </div>
                                    <div class="col align-self-center" style="padding: 0;">
                                        <div class="hstat-text">323,100+</div>
                                        <div class="hstat-title">Total Orders</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 mb-4 col-6">
                            <div class="home-stat">
                                <div class="row">
                                    <div class="col-auto align-self-center"style="padding: 0 8px;">
                                        <i class="far fa-smile"></i>
                                    </div>
                                    <div class="col align-self-center" style="padding: 0;">
                                        <div class="hstat-text">53,000+</div>
                                        <div class="hstat-title">Happy Customers</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5 offset-lg-1">

                <div class="login-card">
                    
                
                    
                    <div class="d-card">
                        <div class="d-card-head">
                <div class="dch-body">
                    <i class="icon fa fa-lock me-3"></i>
                    <span class="ml-3" style="color:#000;">Log in to {{get_setting('title')}}</span>
                </div>
            </div>
                        <div class="d-card-body">
                            <form method="post" action="{{route('signin')}}">
                                @csrf
                                <div class="form-group">

                                    <label class="control-label">Username / Email Address</label>
                                        
                                        <input type="text" class="form-control" id="username" name="username" placeholder="Email or Username" required value="{{old('username')}}">
                                    
</div>
                                    <div class="form-group">
                                        <label class="control-label">Password</label>
                                        <input type="password" class="form-control" id="password" placeholder="Enter Your Password" name="password" required">
                                        
                                    </div>

                                    <div class="form-row mt-2">
                                        <div class="col-6 py-2">
                                            <div class="fcheck ms-1">
                                                <input type="checkbox" name="remember" value="1" id="remember">
                                                <label for="remember">Remember Me</label>
                                            </div>
                                        </div>
                                        <div class="col-6 text-right">
                                            <a href="{{route('password.request')}}" class="frgpass">Forgot Password?</a>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-primary w-100">Login</button>
                                        </div>
                                    </div>
                                    <p class="mt-2" style="font-size: 13px;text-align: center;">
                                        Don't have an account? <a href="{{route('signup')}}" class="bold main-color">Sign Up</a>.
                                    </p>

                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 align-self-center">
        
        </div>
    </div>
</div>

<section class="fifthsec" style="padding: 70px 0 70px 0; >
    <div class="container">
        <div class="row">
                </div>
    </div>
    <marquee behavior="alternate" direction="right" scrollamount="1">
        <img src="https://i.imgur.com/SDeymuI.png" alt="AevoSmm" class="soclog">
        <img src="https://i.imgur.com/dK4UpCX.png"  alt="AevoSmm" class="soclog">
        <img src="https://i.imgur.com/4QYluJV.png" alt="AevoSmm"  class="soclog">
        <img src="https://i.imgur.com/0iCbpT5.png"  alt="AevoSmm" class="soclog">
        <img src="https://i.imgur.com/EPjhdsk.png"  alt="AevoSmm" class="soclog">
        <img src="https://i.imgur.com/b7bDyZ0.png" alt="AevoSmm"  class="soclog">
        <img src="https://i.imgur.com/Nw3KlNK.png" alt="AevoSmm"  class="soclog">
        <img src="https://i.imgur.com/SDeymuI.png" alt="AevoSmm"  class="soclog">
        <img src="https://i.imgur.com/dK4UpCX.png" alt="AevoSmm"  class="soclog">
        <img src="https://i.imgur.com/4QYluJV.png" alt="AevoSmm"  class="soclog">
        <img src="https://i.imgur.com/0iCbpT5.png" alt="AevoSmm"  class="soclog">
        <img src="https://i.imgur.com/EPjhdsk.png" alt="AevoSmm"  class="soclog">
        <img src="https://i.imgur.com/b7bDyZ0.png" alt="AevoSmm"  class="soclog">
        <img src="https://i.imgur.com/Nw3KlNK.png" alt="AevoSmm"  class="soclog">
    </marquee>
    <marquee behavior="alternate" direction="leftt" scrollamount="1">
        <img src="https://i.imgur.com/XrwVe1U.png" alt="AevoSmm"  class="soclog">
        <img src="https://i.imgur.com/CwXI68P.png" alt="AevoSmm"  class="soclog">
        <img src="https://i.imgur.com/iq4Ooys.png" alt="AevoSmm"  class="soclog">
        <img src="https://i.imgur.com/dKpe683.png" alt="AevoSmm"  class="soclog">
        <img src="https://i.imgur.com/tIJso2J.png" alt="AevoSmm"  class="soclog">
        <img src="https://i.imgur.com/R6gDm3p.png" alt="AevoSmm"  class="soclog">
        <img src="https://i.imgur.com/NzywxbF.png" alt="AevoSmm"  class="soclog">
        <img src="https://i.imgur.com/XrwVe1U.png" alt="AevoSmm"  alt="AevoSmm"  class="soclog">
        <img src="https://i.imgur.com/CwXI68P.png" alt="AevoSmm"  class="soclog">
        <img src="https://i.imgur.com/iq4Ooys.png" alt="AevoSmm"  alt="AevoSmm"  class="soclog">
        <img src="https://i.imgur.com/dKpe683.png" alt="AevoSmm"  class="soclog">
        <img src="https://i.imgur.com/tIJso2J.png" alt="AevoSmm"  class="soclog">
        <img src="https://i.imgur.com/R6gDm3p.png" alt="AevoSmm"  class="soclog">
        <img src="https://i.imgur.com/NzywxbF.png" alt="AevoSmm"  class="soclog">
    </marquee>
</section>



<section class="home-box-2">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 nopa">
                <div class="home-phone">
                        <img src="https://cdn.mypanel.link/u7ep2r/q48garjh5m68huzt.png"   alt="Best Panel Powered by AI"   width="100%"  class="img-fluid iphone " />
                        
                </div>
            </div>

            <div class="col-lg-6">
            
            <h6 class="main-color">WHY CHOOSE {{get_setting('title')}}? </h6>
            <h2 style="font-weight:800;">One platform, many features</h2> 
                <div class="row detail-box">
                    <div class="col-auto">
                        <div class="dt-icon">
                            <i class="fas fa-mobile"></i>
                        </div>
                    </div>
                   <div class="col">
                        <h2 class="dt-title">Unique UI</h2>
                        <p class="dt-text">Experience a unique interface that is compatible with all devices.</p>
                    </div>
                </div>

                <div class="row detail-box">
                    <div class="col-auto">
                        <div class="dt-icon">
                            <i class="fas fa-globe"></i>
                        </div>
                    </div>
                    <div class="col">
                        <h2 class="dt-title">International Services</h2>
                        <p class="dt-text">We offer carefully selected services from all around the world.</p>
                    </div>
                </div>

                <div class="row detail-box">
                    <div class="col-auto">
                        <div class="dt-icon">
                            <i class="fas fa-tachometer-alt"></i>
                        </div>
                    </div>
                    <div class="col">
                        <h2 class="dt-title">Instant Delivery</h2>
                        <p class="dt-text">Our services provide instant and seamless delivery.</p>
                    </div>
                </div>

                <div class="row detail-box">
                    <div class="col-auto">
                        <div class="dt-icon">
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                    <div class="col">
                        <h2 class="dt-title">High Quality</h2>
                        <p class="dt-text">We continuously test and update our services to offer the highest quality.</p>
                    </div>
                </div>

                <div class="row detail-box">
                    <div class="col-auto">
                        <div class="dt-icon">
                            <i class="fa fa-user"></i>
                        </div>
                    </div>
                    <div class="col">
                        <h2 class="dt-title">Professional Support</h2>
                        <p class="dt-text">Our professional team is available 24/7 to answer all your questions and concerns.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<section class="home-box-4">
    <div class="container">
        <div class="row">
        
<div class="col-lg-6 ms">
                <div class="home-phone2">
                        <img src="https://cdn.mypanel.link/u7ep2r/htlbg71jt7p9rr5c.png"  style="padding:20px 0"  width="110%"  class="img-fluid iphone" />
                </div>
            </div>
            



<div class="col-lg-6 mt-4" data-aos="fade-right">
    <h6 class="main-color">BOOST YOUR VISIBILITY </h6>
            <h2 style="font-weight:800;">The only platform you'd ever need</h2>
                <div class="text-container">
                    
                    <p>{{get_setting('title')}} is the best SMM service provider to help you grow your audience & business across all social media platforms & websites.</p>
                    <h6>Our Platform Boasts Of:</h6>
                    <ul>
                        <li>A user-friendly interface that makes it easy for you to find the services you need. </li>
                        <li>A wide range of digital services & products.</li>
                        <li>Secure payment options, so you can make purchases with confidence.</li>
                        <li>Fast, reliable & automated service delivery.</li>
                        <li>Best Customer support, to help you with any questions or issues you may have.</li>
                    </ul>
                    <p> We're constantly updating our website with new services, so check back often to see what's new.</p>
                </div>
                <a href="{{route('signup')}}" class="main-color h5">Get Started <i class="fa fa-arrow-right"></i></a>
            </div>



           
            
            <div class="col-lg-6 mh">
                <div class="home-phone3">
                        <img src="https://cdn.mypanel.link/u7ep2r/htlbg71jt7p9rr5c.png"    width="110%"  class="img-fluid iphone" style="width:100%;" />
                </div>
            </div>
            
        </div>
    </div>
</section>





<section class="home-star mt-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h2 class="mb-3">Get started in minutes.</h2>
                <p> Even if you’re just getting started or looking to take your social media marketing to a new level, {{get_setting('title')}} has the services to bring your vision to life — fast and without hiccups.</p>
                <a href="{{route('signup')}}" class="btn btn-primary" style="padding: 15px 30px; font-size: 16px;margin-top: 20px;
"> Register for free!</a> 
                
                
            </div>
            </div>    </div>    </section>





<section class="home-bottom" hidden>
    <div class="container">
    <div class="row justify-content-center">
        
    </div>
</div>
</section>



@endsection



@section('styles')
<style>

body.dark {
    background: #ffffff;
}

.main-top .main-top-bg {
    background-image: url(https://preview.wstacks.com/smmcrowd/assets/presets/default/images/shape-bg.png) !important;
    background-size: cover;

}

.header .header-menu ul li a {
    color: #fff;
  
}

.home-star {
    background:#b0d8f4;
    text-align:center;
    padding:80px 0;
}

.home-star h1 {
    font-weight:800;
}



.login-card {
    background: #fff;
    border-radius: 15px;
    margin-bottom: 50px;
}

.header .header-menu ul li a:hover {
    color: #6642be;
}

.head-text p {
    font-size: 19px;
    line-height: 20px;
    color: #fff;
    margin-top: 20px;
    font-weight: 400;
}

.head-text h1 span {
    line-height: 50px !important;
    font-weight: 700;
    font-size: 58px !important;
    color:#fff;
    
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
    color:#6642be;
  
    
}

.main-stats {
    padding: 35px 0 0 0;
    font-size: 18px;
}

.main-stats .hstat-title {
    font-size: 14px;
    font-weight: 500;
    color: #fff; 
    margin-top: -8px;
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
    padding: 160px 0 60px 0;
    background:linear-gradient(45deg, #acffd7, #9468f1 54%, #71cce9);
}

.ms {
    
    display:none;
}

.container, .container-lg, .container-md, .container-sm {
   width: 100%;
    max-width: 100%;
    padding: 0 85px;
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

.col-auto {
    padding: 0;
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
    font-weight: 600;
    font-size: 22px;
    line-height: 24px;
    color: #000;
    margin-bottom: 10px;
}
.home-box-2 .detail-box .dt-icon {
    height: 50px;
    width: 50px;
    border: 3px solid #6642be;
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
    font-size: 24px;
    line-height: 18px;
    color: #000;
    margin-bottom: 10px;
}
.home-box-2 .detail-box .dt-text {
    font-size: 14px;
    line-height: 16px;
    color: #000;
    margin-bottom: 0px;
    font-weight: 400;
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
    padding: 40px 0 40px 0;
}

 .home-box-4 {
    padding: -20px 0 40px 0 !important;
}

.home-box-2 .home-phone .iphone {
    position: relative;
    margin-left: 0;
    margin-right: auto;
    left: 0;
    right: 0;
    background: #fff;
    border-radius: 3px;
    padding: 0;
    margin-bottom: 20px;
    width:100%;
}

p {
    font-size:16px !important;
    
}
.home-box-2 .home-phone2 .iphone {
    position: relative;
    margin-left: auto;
    margin-right: 0;
    left: 0;
    right: 0;
    background: #fff;
    border-radius: 3px;
    padding: 20px;
    margin-bottom: 20px;
}

.home-box-2 .home-phone3 .iphone {
    position: absolute;
    margin-left: auto;
    margin-right: 0;
    left: 0;
    right: 0;
    background: #fff;
    border-radius: 3px;
    padding: 0;
    margin-bottom: 20px;
}

.home-box-2 .home-phone {
    position: relative;
    padding-top: 0;
}

.soclog {
    height: 60px;
}

.text-container {
    font-size: 17px;
    font-weight: 400;
    margin-top: 15px;
}

.footer {
    background: black;
    padding: 20px;
}

.footer .footer-links {
    font-size: 14px;
}


.nopa{
    padding:30px;
}








@media (max-width: 600px) {
    .nopa {
        padding:0;
        
    }
    
    .home-box-2 .home-phone2 .iphone {
     margin-bottom: 40px;
}
    
.container, .container-lg, .container-md, .container-sm {
    max-width: 100%;
    padding: 0 25px;
    overflow: hidden;
}

.home-box-2 .home-phone {
    position: relative;
    padding-top: 0;
    padding-bottom:20px;
}

.ms {
    
    display:inline-block;
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
    font-size: 15px;
    line-height: 18px;
    color: #fff;
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
        line-height: 30px !important;
        font-weight: 800 !important;
        font-size: 35px !important;
        text-align: left;
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
    width: 35px;
    height: 35px;
    text-align: center;
    line-height: 35px;
    color: #fff;
    border-radius: 50px;
    -webkit-box-shadow: none;
    box-shadow: none;
}

.main-stats .hstat-text {
   font-size: 16px;
    font-weight: 800;
    color: #6642be;
}

.main-stats {
    padding: 10px 0 0 0;
    font-size: 18px;
}

.main-stats .hstat-title {
    font-size: 10px;
    font-weight: 400;
    color: #fff;
}

.home-bottom, .home-box-2 {
    padding: 0 0 20px 0 !important;
}

.main-top {

    padding: 130px 0 20px 0;
}

.home-stat {
    padding:0 5px;
}


}






.ego {
    background:linear-gradient(45deg, #b6fff4, #9468f1 54%, #71cce9);
    -webkit-text-fill-color: transparent;
    -webkit-background-clip: text;
    background-clip: text;
}











</style>
@endsection




