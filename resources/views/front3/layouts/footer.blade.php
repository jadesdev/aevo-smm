{{-- footer --}}
<footer class="footer">
    <div class="container">
        <div class="row gap-3 gap-md-0">
            <div class="col-12 col-md-5 mb-4 mb-md-0">
                <div class="d-flex align-items-center">
                    <img src="{{my_asset(get_setting('favicon'))}}" alt="Logo" width="32" height="32" class="d-inline-block">
                    <div class="mx-3">© {{date('Y')}} {{get_setting('title')}}</div>
                </div>
            </div>
            <div class="col-12 col-md-7">
                <div class="row">
                    <div class="col-12 col-sm-6 mb-3 mb-sm-0">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a href="{{route('faq')}}" class="nav-link px-0">FAQs</a>
                            </li>
                            {{-- <li class="nav-item">
                                <a href="pricing" class="nav-link px-0">Pricing</a>
                            </li> --}}
                        </ul>
                    </div>
                    <div class="col-12 col-sm-6">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a href="{{route('terms')}}" class="nav-link px-0">Terms of Service</a>
                            </li>
                            {{-- <li class="nav-item">
                                <a href="privacy" class="nav-link px-0">Privacy Policy</a>
                            </li> --}}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
