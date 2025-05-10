<header class="header fixed-top" id="headerNav">
    <div class="container">
        <nav class="navbar navbar-expand-lg ">
            <a class="navbar-brand " href="{{ route('index') }}">
                <img class="site-logo" src="{{ my_asset(get_setting('logo')) }}" alt="Website logo">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span><i class="fe fe-menu"></i></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">

                    <li class="nav-item ">
                        <a class="nav-link js-scroll-trigger" href="{{route('index')}}">Home</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="{{route('index')}}#features">What we offer!</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="{{ route('services') }}">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="{{ route('api_docs') }}">API</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger " href="{{ route('faq') }}">FAQ</a>
                    </li>
                </ul>
                @guest
                <div class="nav-item d-md-flex btn-login-signup">
                    <a class="link btn-login" href="{{route('index')}}">Login</a>
                    <a href="{{route('signup')}}" class="btn btn-pill btn-outline-primary sign-up"  style="border-radius: 10px;">Sign Up</a>
                </div>
                @else
                <div class="nav-item d-md-flex btn-login-signup">
                    <a href="{{route('user.dashboard')}}" class="btn btn-pill btn-outline-primary sign-up" style="border-radius: 10px;">Dashboard</a>
                </div>
                @endguest
            </div>
        </nav>
    </div>
</header>
