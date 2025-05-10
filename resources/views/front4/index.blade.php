@extends('front4.layouts.master')

@section('title', get_setting('title'))

@section('content')
<!-- Banner Section Start -->
<section class="banner__section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-12">
                <div class="hero__text text-center wow fadeInUp" data-wow-delay=".2s">
                    <h1 class="title gradient"><span>{{ get_setting('about') }}</span></h1>

                    <p class="desc">
                        {{get_setting('description')}}.
                    </p>
                    <div class="btn__group">
                        <a href="{{route('register')}}" class="btn btn-primary">
                            Get Started Now
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>
                        
                    </div>

                </div>
                <div class="banner__thumb wow fadeInUp" data-wow-delay=".3s">
                    <img src="{{static_asset('theme4/front/images/header1_hero_image1431.png ')}}" alt="banner-thumb" />
                </div>
            </div>
        </div>
    </div>
</section>
 <!-- Feature Section Start -->
<section class="feature__section p-0" id="feature">
    <div class="container">
        <div class="featureBox__wrapper">
            <div class="row">
                <div class="col-12">
                    <div class="section__title text-center wow fadeInUp" data-wow-delay=".2s">
                        <h2 class="title">Our Unique Features</h2>
                    </div>
                </div>
            </div>
            <div class="row" style="">
                <div class="col-12">
                    
                    <div class="container">
        <div class="row">
          <div class="col-lg-4 mt-5">
            <div class="row hpfs-box">
              <div class="col-auto">
                <div class="hpf-icon" style="border:2px solid #B54CE9; padding: 20px;border-radius: 15px;font-size: 38px;background: -webkit-linear-gradient(left, #fa5560 0%, #b14bf4 52%, #4d91ff 100%);background-clip: border-box;background-clip: border-box;-webkit-background-clip: text;-webkit-text-fill-color: transparent;">
                  <i class="fas fa-bolt"></i>
                </div>
              </div>
              <div class="col">
                <h3 class="hpf-title" style="font-size:24px;">Fastest SMM Panel</h3>
                <p class="hpf-text">Most of our services are the fastest on the market, because we know how much speed is important for our customers.</p>
              </div>
            </div>
          </div><!-- col -->
          <div class="col-lg-4 mt-5">
            <div class="row hpfs-box">
              <div class="col-auto"> 
                <div class="hpf-icon" style="border:2px solid #B54CE9; padding: 20px;border-radius: 15px;font-size: 38px;background: -webkit-linear-gradient(left, #fa5560 0%, #b14bf4 52%, #4d91ff 100%);background-clip: border-box;background-clip: border-box;-webkit-background-clip: text;-webkit-text-fill-color: transparent;">
                  <i class="fas fa-star"></i>
                </div>
              </div>
              <div class="col">
                <h3 class="hpf-title" style="font-size:24px;">Best Quality SMM Provider</h3>
                <p class="hpf-text">We offer only Highest Quality SMM Services, there are no cheap services that will drop the day after.</p>
              </div>
            </div>
          </div><!-- col -->
          <div class="col-lg-4 mt-5">
            <div class="row hpfs-box">
              <div class="col-auto">
                <div class="hpf-icon" style="border:2px solid #B54CE9; padding: 20px;border-radius: 15px;font-size: 38px;background: -webkit-linear-gradient(left, #fa5560 0%, #b14bf4 52%, #4d91ff 100%);background-clip: border-box;background-clip: border-box;-webkit-background-clip: text;-webkit-text-fill-color: transparent;">
                  <i class="fas fa-shield"></i>
                </div>
              </div>
              <div class="col">
                <h3 class="hpf-title" style="font-size:24px;">Most Trusted SMM Panel</h3>
                <p class="hpf-text">We offer a variety of most secured payment methods, most of which are instantly delivered to your panel balance.</p>
              </div>
            </div>
          </div><!-- col -->
        </div><!-- row -->
      </div>
                    
                    
                    <div class="featureBox__inner" style="display:none;">
                        <!-- FeatureBox Start -->
                        <div class="featureBox wow fadeInUp" data-wow-delay=".3s">
                            <div class="featureBox__icon">
                                <i class="fa-solid fa-circle-check"></i>
                            </div>
                            <div class="featureBox__content">
                                <h4 class="title">Official Meta Cloud API</h4>
                            </div>
                        </div>
                        <!-- FeatureBox Start -->
                        <div class="featureBox wow fadeInUp" data-wow-delay=".3s">
                            <div class="featureBox__icon">
                                <i class="fa-solid fa-circle-check"></i>
                            </div>
                            <div class="featureBox__content">
                                <h4 class="title">User-Friendly Interface</h4>
                            </div>
                        </div>
                        <!-- FeatureBox Start -->
                        <div class="featureBox wow fadeInUp" data-wow-delay=".3s">
                            <div class="featureBox__icon">
                                <i class="fa-solid fa-circle-check"></i>
                            </div>
                            <div class="featureBox__content">
                                <h4 class="title">AI Bot</h4>
                            </div>
                        </div>
                        <!-- FeatureBox Start -->
                        <div class="featureBox wow fadeInUp" data-wow-delay=".3s">
                            <div class="featureBox__icon">
                                <i class="fa-solid fa-circle-check"></i>
                            </div>
                            <div class="featureBox__content">
                                <h4 class="title">Write Content With AI Assistant</h4>
                            </div>
                        </div>
                        <!-- FeatureBox Start -->
                        <div class="featureBox wow fadeInUp" data-wow-delay=".3s">
                            <div class="featureBox__icon">
                                <i class="fa-solid fa-circle-check"></i>
                            </div>
                            <div class="featureBox__content">
                                <h4 class="title">Team Member Support</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<!-- Advantage Section Start -->
<section class="advantage__section mt-3" id="features">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section__title text-center wow fadeInUp" data-wow-delay=".2s">
                    <h2 class="title">The Only SMM Platform You'd Ever Need
                    </h2>
                    <p class="desc">Our team of experts has carefully crafted {{get_setting('title')}} to meet all your sales needs.
                        </p>
                </div>
            </div>
        </div>
        <div class="row">

            <div class="col-lg-6 col-md-6">
                <div class="advantage__card wow fadeInUp" data-wow-delay=".3s">
                    <div class="advantage__content">
                        <h4 class="title">A User-Friendly Interface 
                        </h4>


                        <p class="desc">

                            A User-Friendly Interface Gives You Easy Accessibility to our Amazing Services.
                        </p>
                    </div>
                    <div class="advantage__thumb">
                        <img src="{{static_asset('theme4/front/images/original__product_416.png ')}}"
                            alt="A User-Friendly Interface" />
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-6">
                <div class="advantage__card wow fadeInUp" data-wow-delay=".3s">
                    <div class="advantage__content">
                        <h4 class="title">Reliable SMM Services</h4>


                        <p class="desc">

                            Services for all Social Media Platforms.
                        </p>
                    </div>
                    <div class="advantage__thumb">
                        <img src="{{static_asset('theme4/front/images/original__product_211.png ')}}"
                            alt="Reliable SMM Services" />
                    </div>
                </div>
            </div>

            
        </div>
    </div>
</section>


<section class="accordion__section mt-3" id="faq">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section__title text-center wow fadeInUp" data-wow-delay=".2s">
                    <h2 class="title">Frequently Asked Questions about {{get_setting('title')}}</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="accordion__wrapper wow fadeInUp" data-wow-delay=".3s">
                    <div class="accordion" id="faqAccordion">
                        @foreach ($faqs as $key => $item)
                        <div class="accordion__item">
                            <div class="accordion__header" id="heading_{{$key}}">
                                <button class="accordion-button @if($loop->iteration != 1) collapsed @endif" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse_{{$key}}" aria-expanded="true" aria-controls="collapse_{{$key}}">
                                    {{$item->question}}
                                </button>
                            </div>
                            <div id="collapse_{{$key}}" class="accordion-collapse collapse @if($loop->iteration == 1) show  @endif " aria-labelledby="heading_{{$key}}" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <div class="accordion__content">
                                        <p>
                                            <p> {{$item->answer}}.<br></p>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
@section('styles')

<style>
    
    .hp-first-section .hpfs-box .hpf-icon {
  height: 66px;
  width: 66px;
  border: 2px solid #B54CE9;
  -webkit-box-sizing: border-box;
  box-sizing: border-box;
  border-radius: 14px;
  color: #01B76C;
  font-size: 28px;
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

.hp-first-section .hpfs-box .hpf-title {
  font-weight: bold;
  font-size: 20px;
  line-height: 24px;
  color: #fff;
  margin-bottom: 4px;
}

.hp-first-section .hpfs-box .hpf-text {
  font-size: 14px;
  line-height: 20px;
  color: #AAAAAA;
  margin-bottom: 0px;
}
    
</style>


@endsection

