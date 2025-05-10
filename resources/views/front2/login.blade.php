@extends('front2.layouts.master')

@section('title', get_setting('title'))

@section('content')

<header id="home" class="header">
    <div class="header-content">
        <div class="container heda">
            <div class="row text-container">
                <div class="col-lg-6 col-xl-6">
                    <div class="homeimage mh">
                        <img src="{{static_asset("theme2/images/5clcncunc468a4ra.png")}}" style="width: 470px;" class="himage" alt="{{get_setting('title')}}" />
                    </div>
                </div>
                <div class="col-lg-6 col-xl-6">
                    <h1 class="bitext">{{get_setting('about')}}</h1>

                    <p class="" style="color: #fff !important; margin-bottom: 20px; font-size: 14px; line-height: 18px;">
                        {{get_setting('description')}}
                    </p>

                    <div class="ms">
                        <button class="btn-solid-lg page-scroll btn-submit" href="#" data-target="#login" data-toggle="modal">Sign In</button>

                        <div id="login" class="modal fade" role="dialog">
                            <div class="modal-dialog" style="padding: 0 2%;">
                                <div class="modal-content">
                                    <div class="modal-header">

                                        <button type="button" class="btn btn-danger" style="float: right; background: transparent; border: 0; color: red;" data-dismiss="modal">X</button>
                                    </div>
                                    <div class="modal-body" style="padding: 0;">
                                        <div class="card" style="border-radius: 30px; background: #fa6e39; padding: 20px 20px 30px 20px; color: #000; border: 0;"> <h4 style="color: #fff;">Sign in to Instaking</h4>
                                            <div class="form-container logInForm">
                                                <form class="actionFormWithoutToast" action="{{route('signin')}}" data-redirect="{{route('user.dashboard')}}" method="POST">
                                                    @csrf
                                                    <div class="form-group">
                                                        <input type="text" class="form-control-input" name="username" placeholder="Username or Email Address" value="" required />
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="password" class="form-control-input" name="password" placeholder="Password" value="" required />
                                                    </div>

                                                    <div class="form-group mt-20">
                                                        <div id="alert-message" style="border-radius: 30px !important;" class="alert-message-reponse"></div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <button class="btn-solid-lg page-scroll btn-submit" style="margin: 0; width: 100%;" type="submit">Sign In</button>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <a class="checkbox text-right" href="{{route('password.request')}}">Forgot password?</a>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <p>Don't have account yet? <a class="white" style="font-weight: 900; margin-left: 5px;" href="{{route('signup')}}">Sign Up</a></p>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <a href="{{route('signup')}}"><button class="btn-solid-lg page-scroll btn-submit" style="border-color: #fff; background-color: #fff; color: #fa6e39;" href="{{route('signup')}}">Register</button></a>
                    </div>

                    <div class="homeimage ms">
                        <img src="{{static_asset("theme2/images/5clcncunc468a4ra.png")}}" style="width: 600px;" class="himage ms" alt="{{get_setting('title')}}" />
                    </div>
                    <div class="form-container logInForm mh" style="width: 95%;">
                        <form class="actionFormWithoutToast" action="{{route('signin')}}" data-redirect="{{route('user.dashboard')}}" method="POST">
                            @csrf
                            <div class="form-group">
                                <input type="text" class="form-control-input" name="username" placeholder="Email Address or Username" value="" required />
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control-input" name="password" placeholder="Password" value="" required />
                            </div>

                            <div class="form-group mt-20">
                                <div id="alert-message" style="border-radius: 30px !important;" class="alert-message-reponse"></div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <button class="btn-solid-lg page-scroll btn-submit" style="margin: 0; width: 100%;" type="submit">Sign In</button>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <a class="checkbox text-right" href="{{route('password.request')}}">Forgot password?</a>
                                </div>
                            </div>

                            <div class="form-group">
                                <p>Don't have account yet? <a class="white" style="font-weight: 900; margin-left: 5px;" href="{{route('signup')}}">Sign Up</a></p>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</header>





<section class="we-offer" style="">
    <div class="container">
        <div class="row">
            <div class="col-lg-6" data-aos="fade-right">
                <div class="text-container">
                    <h2>Why Choose Us?</h2>
                    <p>Instaking is the best SMM service provider to help you grow your audience & business across all social media platforms & websites.</p>
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
            </div>
            <div class="col-lg-6" data-aos="zoom-out-left">
                <div class "image-container">
                    <img class="img-fluid" src="{{static_asset("theme2/images/presentation-2.png")}}" alt="Website icon">
                </div>
            </div>
        </div>
    </div>
</section>


{{-- Marquee --}}
<section class="fifthsec" style="padding:10px 0 100px 0;" >
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="heading text-center pb-5"> <p style="margin: auto;">We provide services for all</p>Social Media Platforms</h2>
            </div>
        </div>
    </div>
    <marquee behavior="alternate" direction="right" scrollamount="1">
        <img src="https://i.imgur.com/SDeymuI.png" class="soclog">
        <img src="https://i.imgur.com/dK4UpCX.png" class="soclog">
        <img src="https://i.imgur.com/4QYluJV.png" class="soclog">
        <img src="https://i.imgur.com/0iCbpT5.png" class="soclog">
        <img src="https://i.imgur.com/EPjhdsk.png" class="soclog">
        <img src="https://i.imgur.com/b7bDyZ0.png" class="soclog">
        <img src="https://i.imgur.com/Nw3KlNK.png" class="soclog">
        <img src="https://i.imgur.com/SDeymuI.png" class="soclog">
        <img src="https://i.imgur.com/dK4UpCX.png" class="soclog">
        <img src="https://i.imgur.com/4QYluJV.png" class="soclog">
        <img src="https://i.imgur.com/0iCbpT5.png" class="soclog">
        <img src="https://i.imgur.com/EPjhdsk.png" class="soclog">
        <img src="https://i.imgur.com/b7bDyZ0.png" class="soclog">
        <img src="https://i.imgur.com/Nw3KlNK.png" class="soclog">
    </marquee>
    <marquee behavior="alternate" direction="leftt" scrollamount="1">
        <img src="https://i.imgur.com/XrwVe1U.png" class="soclog">
        <img src="https://i.imgur.com/CwXI68P.png" class="soclog">
        <img src="https://i.imgur.com/iq4Ooys.png" class="soclog">
        <img src="https://i.imgur.com/dKpe683.png" class="soclog">
        <img src="https://i.imgur.com/tIJso2J.png" class="soclog">
        <img src="https://i.imgur.com/R6gDm3p.png" class="soclog">
        <img src="https://i.imgur.com/NzywxbF.png" class="soclog">
        <img src="https://i.imgur.com/XrwVe1U.png" class="soclog">
        <img src="https://i.imgur.com/CwXI68P.png" class="soclog">
        <img src="https://i.imgur.com/iq4Ooys.png" class="soclog">
        <img src="https://i.imgur.com/dKpe683.png" class="soclog">
        <img src="https://i.imgur.com/tIJso2J.png" class="soclog">
        <img src="https://i.imgur.com/R6gDm3p.png" class="soclog">
        <img src="https://i.imgur.com/NzywxbF.png" class="soclog">
    </marquee>
</section>



<section class="how-it-works">
    <div class="cards-1">
        <div class="container">
            <div class="col-lg-12 text-center header-top" data-aos="fade-up" data-aos-duration="500">
                <div class="above-heading text-uppercase">How it works?</div>
                <h2 class="h2-heading">It's Easy to Get started on {{get_setting('title')}}</h2>
            </div>
            <div class="row how-it-works-row justify-content-start">
                <div class="col-md-3 how-it-works-col" data-aos="fade-up" data-aos-duration="800">
                    <div class="how-it-works-card">
                        <div class="how-it-works-arrow-top style-svg-g-primary">
                            <svg width="125px" height="31px" viewBox="0 0 125 31" version="1.1" xmlns="../external.html?link=http://www.w3.org/2000/svg">
                                <g id="Landing" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <g transform="translate(-942.000000, -1387.000000)" fill="#1E79E4" id="Group-10">
                                        <g transform="translate(165.000000, 1368.000000)">
                                            <path
                                                d="M889.516523,26.5080119 L891.910644,20.9496585 L902,32.9164837 L886.372927,33.807873 L888.723185,28.3469617 C871.347087,21.9210849 854.507984,19.7125409 838.195168,21.7129851 C818.169006,24.1687976 798.907256,32.9719131 780.398868,48.1424468 L779.638673,48.7694781 L778.869195,49.4081513 L777.591849,47.8691952 L778.361327,47.2305219 C797.38492,31.4407805 817.252224,22.2662407 837.951732,19.7278557 C854.622929,17.6834632 871.814783,19.9463129 889.516523,26.5080119 Z"
                                                id="Line3"
                                            ></path>
                                        </g>
                                    </g>
                                </g>
                            </svg>
                        </div>
                        <div class="how-it-works-arrow-bottom style-svg-g-primary">
                            <svg width="125px" height="31px" viewBox="0 0 125 31" version="1.1" xmlns="../external.html?link=http://www.w3.org/2000/svg">
                                <g id="Landing" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <g transform="translate(-657.000000, -1461.000000)" fill="#1E79E4" id="Group-10">
                                        <g transform="translate(165.000000, 1368.000000)">
                                            <path
                                                d="M493.869195,93.5918487 L494.638673,94.2305219 C513.37968,109.785715 532.894675,118.797561 553.195168,121.287015 C569.507984,123.287459 586.347087,121.078915 603.723185,114.653038 L601.372927,109.192127 L617,110.083516 L606.910644,122.050341 L604.516523,116.491988 C586.814783,123.053687 569.622929,125.316537 552.951732,123.272144 C532.528218,120.767604 512.914862,111.802694 494.12272,96.3975396 L493.361327,95.7694781 L492.591849,95.1308048 L493.869195,93.5918487 Z"
                                                id="Line2"
                                            ></path>
                                        </g>
                                    </g>
                                </g>
                            </svg>
                        </div>
                        <div class="d-flex justify-content-center how-it-works-preview">
                            <div class="how-it-works-number style-box-shadow-default style-bg-color-light">1</div>
                        </div>
                        <div class="how-it-works-title">
                            <h5 class="text-center"><span>Sign Up</span></h5>
                        </div>
                        <div class="how-it-works-description">
                            <p class="text-center"><span>Sign up on our platform with your email. We never ask for your social media account passwords.</span></p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 how-it-works-col" data-aos="fade-up" data-aos-duration="1600">
                    <div class="how-it-works-card">
                        <div class="how-it-works-arrow-top style-svg-g-primary">
                            <svg width="125px" height="31px" viewBox="0 0 125 31" version="1.1" xmlns="../external.html?link=http://www.w3.org/2000/svg">
                                <g id="Landing" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <g transform="translate(-942.000000, -1387.000000)" fill="#1E79E4" id="Group-10">
                                        <g transform="translate(165.000000, 1368.000000)">
                                            <path
                                                d="M889.516523,26.5080119 L891.910644,20.9496585 L902,32.9164837 L886.372927,33.807873 L888.723185,28.3469617 C871.347087,21.9210849 854.507984,19.7125409 838.195168,21.7129851 C818.169006,24.1687976 798.907256,32.9719131 780.398868,48.1424468 L779.638673,48.7694781 L778.869195,49.4081513 L777.591849,47.8691952 L778.361327,47.2305219 C797.38492,31.4407805 817.252224,22.2662407 837.951732,19.7278557 C854.622929,17.6834632 871.814783,19.9463129 889.516523,26.5080119 Z"
                                                id="Line3"
                                            ></path>
                                        </g>
                                    </g>
                                </g>
                            </svg>
                        </div>
                        <div class="how-it-works-arrow-bottom style-svg-g-primary">
                            <svg width="125px" height="31px" viewBox="0 0 125 31" version="1.1" xmlns="../external.html?link=http://www.w3.org/2000/svg">
                                <g id="Landing" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <g transform="translate(-657.000000, -1461.000000)" fill="#1E79E4" id="Group-10">
                                        <g transform="translate(165.000000, 1368.000000)">
                                            <path
                                                d="M493.869195,93.5918487 L494.638673,94.2305219 C513.37968,109.785715 532.894675,118.797561 553.195168,121.287015 C569.507984,123.287459 586.347087,121.078915 603.723185,114.653038 L601.372927,109.192127 L617,110.083516 L606.910644,122.050341 L604.516523,116.491988 C586.814783,123.053687 569.622929,125.316537 552.951732,123.272144 C532.528218,120.767604 512.914862,111.802694 494.12272,96.3975396 L493.361327,95.7694781 L492.591849,95.1308048 L493.869195,93.5918487 Z"
                                                id="Line2"
                                            ></path>
                                        </g>
                                    </g>
                                </g>
                            </svg>
                        </div>
                        <div class="d-flex justify-content-center how-it-works-preview">
                            <div class="how-it-works-number style-box-shadow-default style-bg-color-light">2</div>
                        </div>
                        <div class="how-it-works-title">
                            <h5 class="text-center"><span>Add funds</span></h5>
                        </div>
                        <div class="how-it-works-description">
                            <p class="text-center"><span>Next step is to add funds to your wallet, using our multiple payment methods.</span></p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 how-it-works-col" data-aos="fade-up" data-aos-duration="2400">
                    <div class="how-it-works-card">
                        <div class="how-it-works-arrow-top style-svg-g-primary">
                            <svg width="125px" height="31px" viewBox="0 0 125 31" version="1.1" xmlns="../external.html?link=http://www.w3.org/2000/svg">
                                <g id="Landing" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <g transform="translate(-942.000000, -1387.000000)" fill="#1E79E4" id="Group-10">
                                        <g transform="translate(165.000000, 1368.000000)">
                                            <path
                                                d="M889.516523,26.5080119 L891.910644,20.9496585 L902,32.9164837 L886.372927,33.807873 L888.723185,28.3469617 C871.347087,21.9210849 854.507984,19.7125409 838.195168,21.7129851 C818.169006,24.1687976 798.907256,32.9719131 780.398868,48.1424468 L779.638673,48.7694781 L778.869195,49.4081513 L777.591849,47.8691952 L778.361327,47.2305219 C797.38492,31.4407805 817.252224,22.2662407 837.951732,19.7278557 C854.622929,17.6834632 871.814783,19.9463129 889.516523,26.5080119 Z"
                                                id="Line3"
                                            ></path>
                                        </g>
                                    </g>
                                </g>
                            </svg>
                        </div>
                        <div class="how-it-works-arrow-bottom style-svg-g-primary">
                            <svg width="125px" height="31px" viewBox="0 0 125 31" version="1.1" xmlns="../external.html?link=http://www.w3.org/2000/svg">
                                <g id="Landing" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <g transform="translate(-657.000000, -1461.000000)" fill="#1E79E4" id="Group-10">
                                        <g transform="translate(165.000000, 1368.000000)">
                                            <path
                                                d="M493.869195,93.5918487 L494.638673,94.2305219 C513.37968,109.785715 532.894675,118.797561 553.195168,121.287015 C569.507984,123.287459 586.347087,121.078915 603.723185,114.653038 L601.372927,109.192127 L617,110.083516 L606.910644,122.050341 L604.516523,116.491988 C586.814783,123.053687 569.622929,125.316537 552.951732,123.272144 C532.528218,120.767604 512.914862,111.802694 494.12272,96.3975396 L493.361327,95.7694781 L492.591849,95.1308048 L493.869195,93.5918487 Z"
                                                id="Line2"
                                            ></path>
                                        </g>
                                    </g>
                                </g>
                            </svg>
                        </div>
                        <div class="d-flex justify-content-center how-it-works-preview">
                            <div class="how-it-works-number style-box-shadow-default style-bg-color-light">3</div>
                        </div>
                        <div class="how-it-works-title">
                            <h5 class="text-center"><span>Select a service</span></h5>
                        </div>
                        <div class="how-it-works-description">
                            <p class="text-center"><span>Select your preferred social media service and choose the best package that is relevant to you.</span></p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 how-it-works-col" data-aos="fade-up" data-aos-duration="3000">
                    <div class="how-it-works-card">
                        <div class="how-it-works-arrow-top style-svg-g-primary">
                            <svg width="125px" height="31px" viewBox="0 0 125 31" version="1.1" xmlns="../external.html?link=http://www.w3.org/2000/svg">
                                <g id="Landing" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <g transform="translate(-942.000000, -1387.000000)" fill="#1E79E4" id="Group-10">
                                        <g transform="translate(165.000000, 1368.000000)">
                                            <path
                                                d="M889.516523,26.5080119 L891.910644,20.9496585 L902,32.9164837 L886.372927,33.807873 L888.723185,28.3469617 C871.347087,21.9210849 854.507984,19.7125409 838.195168,21.7129851 C818.169006,24.1687976 798.907256,32.9719131 780.398868,48.1424468 L779.638673,48.7694781 L778.869195,49.4081513 L777.591849,47.8691952 L778.361327,47.2305219 C797.38492,31.4407805 817.252224,22.2662407 837.951732,19.7278557 C854.622929,17.6834632 871.814783,19.9463129 889.516523,26.5080119 Z"
                                                id="Line3"
                                            ></path>
                                        </g>
                                    </g>
                                </g>
                            </svg>
                        </div>
                        <div class="how-it-works-arrow-bottom style-svg-g-primary">
                            <svg width="125px" height="31px" viewBox="0 0 125 31" version="1.1" xmlns="../external.html?link=http://www.w3.org/2000/svg">
                                <g id="Landing" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <g transform="translate(-657.000000, -1461.000000)" fill="#1E79E4" id="Group-10">
                                        <g transform="translate(165.000000, 1368.000000)">
                                            <path
                                                d="M493.869195,93.5918487 L494.638673,94.2305219 C513.37968,109.785715 532.894675,118.797561 553.195168,121.287015 C569.507984,123.287459 586.347087,121.078915 603.723185,114.653038 L601.372927,109.192127 L617,110.083516 L606.910644,122.050341 L604.516523,116.491988 C586.814783,123.053687 569.622929,125.316537 552.951732,123.272144 C532.528218,120.767604 512.914862,111.802694 494.12272,96.3975396 L493.361327,95.7694781 L492.591849,95.1308048 L493.869195,93.5918487 Z"
                                                id="Line2"
                                            ></path>
                                        </g>
                                    </g>
                                </g>
                            </svg>
                        </div>
                        <div class="d-flex justify-content-center how-it-works-preview">
                            <div class="how-it-works-number style-box-shadow-default style-bg-color-light">4</div>
                        </div>
                        <div class="how-it-works-title">
                            <h5 class="text-center"><span>Enjoy superb results</span></h5>
                        </div>
                        <div class="how-it-works-description">
                            <p class="text-center"><span>Sit back and watch the magic. Our services takes starts and delivered fast.</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>

    @media screen and (max-width: 600px){
        .modal-dialog {
        max-width: 500px;
        margin: 5rem auto;
        }

        .form-control {
        /* height: calc(1.5em + 0.75rem + 2px); */
        padding: 15px 20px;

        }
    }
</style>

@endsection
