@extends('front.layouts.master')

@section('title', get_setting('title'))

@section('content')
{{-- Login Page --}}
<div class="container" style="position: relative;">

    <div class="main-top-real-content">
        <div class="row align-items-center">
            <div class="col-lg-6 align-self-center">
                <div class="head-text">
                    <h1><span class="main-color">{{get_setting('about')}}</span></h1>
                    <p>{{get_setting('description')}}.</p>
                </div>
                <div class="head-links row mt-5" style="display:none;">
                    <div class="col-auto mb-4 mb-md-0">
                        <a href="{{route('services')}}" class="btn btn-primary btn-lg">Price List</a>
                    </div>
                    <div class="col-auto">
                        <a href="{{route('faq')}}" class="btn btn-outline btn-lg">How It Works?</a>
                    </div>
                </div>
                <div class="main-stats">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 mb-4 col-12">
                            <div class="home-stat br">
                                <div class="row">
                                    <div class="col-auto align-self-center">
                                        <i class="fa fa-crown"></i>
                                    </div>
                                    <div class="col align-self-center">
                                        <div class="hstat-text">2,323,123+</div>
                                        <div class="hstat-title">Total Orders</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 mb-4 col-12">
                            <div class="home-stat">
                                <div class="row">
                                    <div class="col-auto align-self-center">
                                        <i class="far fa-smile"></i>
                                    </div>
                                    <div class="col align-self-center">
                                        <div class="hstat-text">398,123+</div>
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
                    <div class="lc-body">
                        <div class="lc-title">
                            <h4>Sign In</h4>
                           
                            <form method="post" action="{{route('signin')}}">
                                @csrf
                                <div class="login-form py-3">

                                    <div class="fg fg-light mb-4">
                                        <div class="fg-icon"><i class="far fa-user"></i></div>
                                        <input type="text" class="fg-control" id="username" name="username" placeholder="Email or Username" required value="{{old('username')}}">
                                    </div>

                                    <div class="fg fg-light mb-4">
                                        <div class="fg-icon"><i class="fa fa-unlock"></i></div>
                                        <input type="password" class="fg-control" id="password" placeholder="Enter Your Password" name="password" required">
                                    </div>

                                    <div class="form-row mt-2">
                                        <div class="col-6 py-2 mb-2">
                                            <div class="fcheck ms-1 mb-3">
                                                <input type="checkbox" name="remember" value="1" id="remember">
                                                <label for="remember">Remember Me</label>
                                            </div>
                                        </div>
                                        <div class="col-6 text-right">
                                            <a href="{{route('password.request')}}" class="frgpass">Forgot Password?</a>
                                        </div>
                                    </div>

                                    <div class="row mt-4">
                                        <div class="col-md-12 mb-5 mb-md-0">
                                            <button type="submit" class="btn btn-primary btn-lg btn-block">Login</button>
                                        </div>
                                    </div>
                                    <div class="btn btn-dark btn-block mt-3">
                                        Don't have an account? <a href="{{route('signup')}}">Sign Up</a>
                                    </div>

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


<section class="home-box-2" style="display:none;">
    <div class="container">
        <div class="row">
            <div class="col-lg-6"><h3 style="color:#fff;text-align:center;">Sign In</h3>
                <div class="home-phone">
                    <img src="{{static_asset('/img/home-img.png')}}" class="img-fluid" />
                    <img src="{{static_asset('img/iphone.png')}}" class="img-fluid iphone floating" />
                </div>
            </div>

            <div class="col-lg-6">
                <div class="row detail-box">
                    <div class="col-auto">
                        <div class="dt-icon">
                            <i class="fas fa-mobile"></i>
                        </div>
                    </div>
                    <div class="col">
                        <h2 class="dt-title">Mobile Responsive</h2>
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


<section class="home-bottom"  style="display:none;">
    <div class="container">
        <div class="row justify-content-start futures-version-2">
            <div class="col-md-3">
                <div class="hb-box">
                    <div class="hb-box-text">
                        <div class="hb-box-icon">
                            <i class="fa fa-user-alt"></i>
                        </div>
                        <div class="wpo-features-text">
                            <h2>Sign Up for Free</h2>
                            <p>Sign up for free on our website and log in.</p>
                        </div>
                    </div>
                    <div class="hb-box-img">
                        <img src="{{static_asset('img/box-shape.png')}}">
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="hb-box">
                    <div class="hb-box-text">
                        <div class="hb-box-icon">
                            <i class="fa fa-wallet"></i>
                        </div>
                        <div class="wpo-features-text">
                            <h2>Load Balance</h2>
                            <p>Load balance securely.</p>
                        </div>
                    </div>
                    <div class="hb-box-img">
                        <img src="{{static_asset('img/box-shape.png')}}">
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="hb-box">
                    <div class="hb-box-text">
                        <div class="hb-box-icon">
                            <i class="fa fa-circle-check"></i>
                        </div>
                        <div class="wpo-features-text">
                            <h2>Create Your Order</h2>
                            <p>Create your order using the new order section.</p>
                        </div>
                    </div>
                    <div class="hb-box-img">
                        <img src="{{static_asset('img/box-shape.png')}}">
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="hb-box">
                    <div class="hb-box-text">
                        <div class="hb-box-icon">
                            <i class="fa fa-crown"></i>
                        </div>
                        <div class="wpo-features-text">
                            <h2>Enjoy!</h2>
                            <p>Just check your notifications :)</p>
                        </div>
                    </div>
                    <div class="hb-box-img">
                        <img src="{{static_asset('img/box-shape.png')}}">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


@endsection
