<!-- CAll To Action Start -->

{{-- footer --}}
<footer class="footer__section">
    <div class="container">
        <div class="row">
            <div class="col-lg-4" style="display:none;">
                <div class="footer__wrapper wow fadeInUp" data-wow-delay=".3s">
                    <div class="footer__widget">
                        <div class="footer__slogun">{{ get_setting('about') }}</div>
                        <div class="footer__toplink">
                            <div class="footer__link d-flex align-items-center">
                                <div class="icon">
                                    <img src="{{static_asset('theme4/front/images/email.svg')}}" alt="email" />
                                </div>
                                <a href="mailto:{{ get_setting('email') }}">{{ get_setting('email') }}</a>
                            </div>
                            <div class="footer__link d-flex align-items-center">
                                <div class="icon">
                                    <img src="{{static_asset('theme4/front/images/phone.svg')}}" alt="phone" />
                                </div>
                                <a href="tel:{{ get_setting('phone') }}">{{ get_setting('phone') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col"></div>
            <div class="col-lg-3 col-md-6 col-sm-6" style="display:none;">
                <div class="footer__wrapper wow fadeInUp" data-wow-delay=".3s">
                    <div class="footer__widget">
                        <div class="widget__wrap">
                            <ul class="widget__list">
                                <li><a href="{{route('faq')}}">FAQs</a></li>
                                <li><a href="{{route('api_docs')}}">Api Docs</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col"></div>
            <div class="col-lg-3 col-md-6 col-sm-6" style="display:none;">
                <div class="footer__wrapper wow fadeInUp" data-wow-delay=".3s">
                    <div class="footer__widget">
                        <div class="widget__wrap">
                            <ul class="widget__list">
                                <li><a href="{{route('terms')}}">Terms & Conditions</a></li>
                                <li><a href="{{route('services')}}">Services</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer__bottom">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="footer__content wow fadeInUp" data-wow-delay=".3s">
                        <div class="footer__logo">
                            <a href="index.html"><img src="{{my_asset(get_setting('logo'))}}" alt="footer-logo" /></a>
                        </div>
                        <div class="footer__apps">
                            <a href="#"><img src="{{static_asset('theme4/front/images/payment_method_banner73.png')}}" alt="payment" /></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer__copyright">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="copyright text-center wow fadeInUp" data-wow-delay=".3s">
                        <p> © {{ date('Y') }} {{ get_setting('title') }}. All Rights Reserved. </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
