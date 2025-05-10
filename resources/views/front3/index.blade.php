@extends('front3.layouts.master')

@section('title', get_setting('title'))

@section('content')

<section class="main"> 
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="heading text-center">
                <h1><span class="" style="">{{get_setting('about')}}</span></h1>
                    <p>{{get_setting('description')}}.</p>
            </div>
            
            <div class="head-links mt-2" style="display:none;">
                    <div class="col-auto mb-4 mb-md-0" style="text-align:left;">
                        <a href="{{route('signup')}}" class="btn btn-primary btn-lg" style="margin-right:10px;" >Get Started </a>
                        
                       
                </div>
            </div>
                </div>
    </div>
</section>


  
  
  
  
  
<section class="home-section">
      <div class="container">
        <div class="row">
          <div class="col-12 mb-2">
            <h4 class="hp-title text-center">Best SMM Panel for all Platforms</h4>
          </div>

          <div class="row justify-content-center">
            <div class="col-auto">
              <div class="hp-socials">
                <div class="hp-socials-icon" style="--bg-color: #4267B2;">
                  <i class="fab fa-facebook-f"></i>
                </div>
                <h4>Facebook SMM Panel</h4>
              </div>
            </div><!-- col -->
            <div class="col-auto">
              <div class="hp-socials">
                <div class="hp-socials-icon" style="--bg-color: #1DA1F2;">
                  <i class="fab fa-twitter"></i>
                </div>
                <h4>Twitter SMM Panel</h4>
              </div>
            </div><!-- col -->
            <div class="col-auto">
              <div class="hp-socials">
                <div class="hp-socials-icon" style="--bg-color: #8a3ab9;">
                  <i class="fab fa-instagram"></i>
                </div>
                <h4>Instagram SMM Panel</h4>
              </div>
            </div><!-- col -->
            <div class="col-auto">
              <div class="hp-socials">
                <div class="hp-socials-icon" style="--bg-color: #FF0000;">
                  <i class="fab fa-youtube"></i>
                </div>
                <h4>Youtube SMM Panel</h4>
              </div>
            </div><!-- col -->
            <div class="col-auto">
              <div class="hp-socials">
                <div class="hp-socials-icon" style="--bg-color: #FF0000;">
                  <i class="fab fa-spotify"></i>
                </div>
                <h4>Spotify SMM Panel</h4>
              </div>
            </div><!-- col -->
            <div class="col-auto">
              <div class="hp-socials">
                <div class="hp-socials-icon" style="--bg-color: #ff0050;">
                  <i class="fab fa-tiktok"></i>
                </div>
                <h4>TikTok SMM Panel</h4>
              </div>
            </div><!-- col -->
          </div>
        </div>
      </div>
    </section>
    
    
    
  

<section class="home-box-2" style="display:none;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="home-phone">
                    <img src="https://instaking.ng/public/uploads/hk821oqh584d2740.png"   alt="Best Panel in Nigeria/Africa"   width="100%"  class="img-fluid iphone " />
                    
                </div>
                
            </div>

            <div class="col-lg-6 hidden">
                <h4>Why Choose {{get_setting('title')}}? </h4>
                
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






<section class="home-section hp-bf-section"  style="">
      <div class="container">
        <div class="row align-items-center">
            <div class="col-md-5">
                
                
                <div class="text-cente">
            <h2 class="hp-title mb-3">Benefits of <span class="p-color">AevoSmm</span></h2>
            <p class="hp-text mb-5">We know that there are tons of panels that are providing SMM services, but we are special! Why? Let us tell you a couple of things about why you should choose NLOSMM...</p>
            
            
          </div></div>
                
            <div class="col-md-7">
          <div class="col-md-12">
            <div class="row px-5">
              <div class="col-md-6">
                <div class="hp-bf-box">
                  <div class="hp-bf-icon">
                    <i class="far fa-shield-check"></i>
                  </div>
                  <h3 class="hp-bf-title">Guaranteed delivery</h3>
                  <div class="hp-bf-text">
                    All of our services are guaranteed, you will get what you paid for.
                  </div>
                </div>
                <div class="hp-bf-box mt-4">
                  <div class="hp-bf-icon">
                    <i class="far fa-user-headset"></i>
                  </div>
                  <h3 class="hp-bf-title">Friendly Support</h3>
                  <div class="hp-bf-text">
                    We have the best support team that will solve your problems within minutes.
                  </div>
                </div>
              </div>
              <div class="col-md-6 ">
                <div class="hp-bf-box mt-4">
                  <div class="hp-bf-icon">
                    <i class="far fa-tools"></i>
                  </div>
                  <h3 class="hp-bf-title">Stable Services</h3>
                  <div class="hp-bf-text">
                    All of our services are daily tested and ready to be used.
                  </div>
                </div>
                <div class="hp-bf-box mt-4">
                  <div class="hp-bf-icon">
                    <i class="far fa-phone-laptop"></i>
                  </div>
                  <h3 class="hp-bf-title">We are Responsive</h3>
                  <div class="hp-bf-text">
                    You can use our panel on the go, we are responsive on all devices.
                  </div>
                </div>
              </div>
            </div><!-- row end-->
          </div><!-- col (left) -->
          
        </div>
      </div></div>
    </section>





<section class="home-how"  style="">
    <div class="container">
        <div class="row justify-content-start futures-version-2">
            
            <h3 class="text-center">How it works</h3>
            <p class="text-center"> Take your business to another level following the step-by-step tutorial below.</p>
            
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
                   
                </div>
            </div>
        </div>
    </div>
</section>
    
    
    

<section class="faq-sect" id="faqs">
        <div class="row justify-content-center">
            <h3 class="service-title text-center">Frequently Asked Questions</h3>
        
            <div class="col-md-8">
                <p class="text-center mb-5">Browse our FAQs for quick insights into how we work, what we offer, and how we can help your business.</p>
                   
                    <ul class="faq-list">
                
                      <li>
                            <h4 class="faq-heading">
                                Why choose us?
                            </h4>
                            <p class="read faq-text">
                            AevoSMM offers affordable, high-quality, and fast SMM services. We have a user-friendly platform, offer secure payment options, and provide excellent customer support. Moreover, our clients trust us for our reliability and transparency.
                            </p>
                        </li>
                      
                      <li>
                            <h4 class="faq-heading"> What are SMM panels used for? </h4>
                            <p class="read faq-text">
                               An SMM panel is a platform that offers SMM services like likes, followers, views, etc., for various social media platforms. It's a tool that businesses or individuals can use to boost their online presence.
                            </p>
                        </li>
                        <li>
                            <h4 class="faq-heading"> What type of services do you provide? </h4>
                            <p class="read faq-text">We sell various types of SMM services for many platforms: likes, followers, views, etc.
                            </p>
                        </li>
                        <li>
                            <h4 class="faq-heading"> How do I place an order? </h4>
                            <p class="read faq-text">
                               To place an order, select the service you want, enter the necessary details like your social media account link or post link, choose the number of likes, views, or followers you want, and submit.
                            </p>
                        </li>
                        
                        <li>
                            <h4 class="faq-heading">
                                Will my account be blocked?
                            </h4>
                            <p class="read faq-text">
                           Absolutely not. Our services are safe to use.     
                            </p>
                        </li>
                    </ul>
                </div></div>
    </section>
    

@endsection


@section('styles')
<style>





.hp-socials {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    margin: 15px 25px;
}

.hp-socials .hp-socials-icon {
    border: 2px solid #ffffff;
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
    border-radius: 19px;
    height: 83px;
    width: 83px;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    color: #fff;
    font-size: 45px;
    margin-bottom: 20px;
    -webkit-transition: .14s ease;
    transition: .14s ease;
}

.hp-socials h4 {
    font-size: 12px;
    font-weight: 700;
    line-height: 1;
    color: #fff;
}





.heading {
    margin-top:0;
    color: #fff;
}

.heading h1 {
    
    font-weight:700 !important;
    line-height: 1 !important;
    color:#f1ecff;
}

.home-section {
    padding: 60px 0;
    
}

.hp-bf-section .hp-bf-box {
    padding: 44px 34px;
    border-radius: 25px;
    color: #fff;
    border: 1px solid #916DFD;
    -webkit-transition: .14s ease;
    transition: .14s ease;
    background: linear-gradient(319deg, rgb(18 13 32) 0%, rgb(145 109 253) 100%);
}

.hp-bf-section .hp-bf-box .hp-bf-icon {
    width: 58px;
    height: 58px;
    border-radius: 50%;
    border: 3.2619px solid #fff;
    color: #fff;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    font-size: 25px;
    margin-bottom: 18px;
}

.hp-bf-section .hp-bf-box .hp-bf-title {
    font-weight: 600 !important;
    font-size: 19px;
    line-height: 158%;
    color: #fff;
}

.hp-bf-section .hp-bf-box .hp-bf-text {
    font-size: 14px;
    line-height: 179%;
    letter-spacing: -.4px;
    color: #fff;
    margin-bottom: 0px;
}

.hp-text {
    
    color:#fff;
}

.hp-title {
    font-weight: 800 !important;
    font-size: 35px;
    line-height: 129%;
    color: #916dfd;

}

.home-list li::before {
    content: '';
    font-family: "Font Awesome 5 Pro";
    color: #916dfd;
    font-size: 20px;
    font-weight: 400;
    margin-right: 20px;
}

.home-list li {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    font-size: 17px;
    line-height: 176%;
    color: #FFFFFF;
    padding: 6px 0;
}
















body {

    padding-top: 80px;
    background: linear-gradient(61deg, rgb(18 13 32) 0%, rgb(69 51 120) 100%) !important;
    height: auto !important;
    color: #fff;
    background-size: cover !important;
}
 

.main {
    
        padding: 170px 0;
        background: linear-gradient(185deg, rgb(17 15 20) 0%, rgb(145 109 253) 100%);
        
}


 h1, h2, h3, {
    
    line-height:1;
}


.hb-box {
    border: 1px solid #916dfd;
    padding: 20px;
    margin: 10px;
    height: 200px;
    text-align: center;
     border-radius: 15px;
}

.hb-box-icon i {
    
    color: #916dfd;
    font-size: 30px;
    background: ;
    padding: 20px;
    border-radius: 50px;
    border: 1px solid #916dfd;

}
.page-wrapper {
    
    padding-right: 0;
    padding-left: 0;

}

.wpo-features-text p
    {
        font-size:13px;
        
        
    }
    
    .wpo-features-text h2
    {
       font-size: 18px;
    margin-bottom: 0;
    margin-top: 10px;
    font-weight: 700 !important;
        
    }


body.dark {
    background: #ffffff;
}

.main-top .main-top-bg {
    background-image: url(https://preview.wstacks.com/smmcrowd/assets/presets/default/images/shape-bg.png) !important;
    background-size: cover;

}

.header .header-menu ul li a {
    color: #000;
  
}

.home-star {
    background:#f5f5f5;
    text-align:center;
    padding:80px 0;
}

.home-star h1 {
    font-weight:800;
}



.login-card {
    background: #fff;
    border-radius: 15px;
    margin-top: 50px;
}

.header .header-menu ul li a:hover {
    color: #5078fa;
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
    font-size: 50px !important;
}

.main-stats .home-stat i {
   font-size: 25px;
    background: #5078fa;
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
    color: #5078fa;
}

.main-stats {
    padding: 35px 0 0 0;
    font-size: 18px;
}

.main-stats .hstat-title {
    font-size: 12px;
    font-weight: 400;
    color: #000;
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
    padding: 160px 0 20px 0;
}

.ms {
    
    display:none;
}

.container, .container-lg, .container-md, .container-sm {
   width: 100%;
    max-width: 100%;
    padding: 0 65px;
    overflow: hidden;
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
    border: 2px solid #5078fa;

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
    font-weight: 400;
    font-size: 22px;
    line-height: 24px;
    color: #000;
    margin-bottom: 4px;
}
.home-box-2 .detail-box .dt-icon {
    height: 50px;
    width: 50px;
    border: 2px solid #5078fa;
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
    border-radius: 50px;
    color: #5078fa;
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
    font-weight: 400;
    font-size: 17px;
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
  padding: 80px 0 80px 0;
    background: #f6f9ff;
}

.home-how {
  padding: 80px 0 80px 0;
   
}

.home-box-2 .home-phone .iphone {
    position: relative;
    margin-left: 0;
    margin-right: auto;
    left: 0;
    right: 0;
    background: #fff;
    border-radius: 30px;
    padding: 0;
    margin-bottom: 20px;
    width:100%;
}

.home-box-2 .home-phone2 .iphone {
    position: relative;
    margin-left: auto;
    margin-right: 0;
    left: 0;
    right: 0;
    background: #fff;
    border-radius: 30px;
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
    border-radius: 30px;
    padding: 0;
    margin-bottom: 20px;
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


.nopa{
    padding:30px;
}


.faq-sect {
    padding: 70px 20px;
    color: #fff;
  
}

.faq-list {
    list-style: none;
    padding: 0;
}

.faq-list li {
    margin: 30px 0;
    padding: 17px 30px;
    margin: 0px auto 30px;
    text-align: left;
    width: 100%;
    background: #edefff;
    color:#000;
  border-radius:10px;
}


.faq-list .faq-heading::before {
    content: '+';
   font-size: 30px;
    display: block;
    position: absolute;
   right:0;
    top: -8px;
  color:#c2c2c2;
}

.faq-list .the-active .faq-heading::before {
    content: '-';
  
}

.faq-heading {
    position: relative;
    cursor: pointer;
    font-size: 18px;
  font-weight: 600;
  margin:0;
}

.faq-heading:hover {
    color: var(--theme-color);
}

.faq-text {
    display: none;
}

.art-box svg {
  width:100%;
}

.read {
    color: rgb(100 100 100);
    font-size: 19px;
    line-height: 1.5;
    margin-top: 25px;
}
    .ms {
        
        display:none;
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
    padding: 0 15px;
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
        line-height: 30px !important;
        font-weight: 600 !important;
        font-size: 28px !important;
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
    background: #5078fa;
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
    color: #5078fa;
}

.main-stats {
    padding: 10px 0 0 0;
    font-size: 18px;
}

.main-stats .hstat-title {
    font-size: 10px;
    font-weight: 400;
    color: #000;
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












<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<script> 
$('.faq-heading').click(function () {
  
    $(this).parent('li').toggleClass('the-active').find('.faq-text').slideToggle();
});

</script>





</style>
@endsection

