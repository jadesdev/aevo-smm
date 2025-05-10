<header class="header">
    <!-- Main Header Start -->
    <div class="main__header">
        <nav class="nav">
            <div class="container">
                <div class="header__wrapper">
                    <!-- Header Logo End -->
                    <div class="header__logo">
                        <a href="{{route('index')}}">
                            <img src="{{ my_asset(get_setting('logo')) }}" alt="Logo" />
                        </a>
                    </div>
                    <!-- Header Logo End -->
                    <!-- Header Menu Start -->
                    <div class="header__menu">
                        <ul class="main__menu">
                            <li><a href="{{route('index')}}">Home</a></li>
                            <li><a href="{{route('services')}}">Services</a></li>
                            <li><a href="{{route('api_docs')}}">API</a></li>
                            <li><a href="{{route('index')}}#faq">FAQs</a></li>
                            @if (sys_setting('multi_currency') == 1)
                            <li class="d-none d-md-block"">
                                <div class="currency-switcher">
                                    <select id="currency-select" class="form-control form-select" onchange="changeCurrency(this.value)">
                                        @foreach (get_all_active_currency() as $currency)
                                        <option value="{{$currency->code}}" @if (get_system_currency()->code == $currency->code) selected @endif data-currency="{{ $currency->code }}" >{{$currency->code}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </li>
                            @endif
                        </ul>
                        <ul class="main__menu mt-5 d-lg-none">
                            @guest
                            <li><a href="{{route('login')}}" class="mt-4">Sign In</a></li>
                            <div class="header__btn">
                                <a class="btn btn-primary" href="#"> Register an account <i class="fa-solid fa-arrow-right"></i></a>
                            </div>
                            @else
                            <div class="header__btn">
                                <a class="btn btn-primary" href="{{route('user.index')}}">Dashboard <i class="fas fa-angle-right"></i></a>
                            </div>
                            @endguest
                        </ul>
                    </div>
                    <!-- Header Menu End -->
                    <!-- Header Meta Start -->
                    <div class="header__meta">
                        <div class="meta__list">
                            @guest
                            <a class="solid__btn" href="{{route('login')}}"><i class="las la-user"></i> Login</a>
                            <div class="header__btn">
                                <a class="btn btn-primary" href="{{route('register')}}">Get started <i class="fa-solid fa-arrow-right"></i></a>
                            </div>
                            @else
                            <div class="header__btn">
                                <a class="btn btn-primary" href="{{route('user.index')}}">Dashboard <i class="las la-angle-right"></i></a>
                            </div>
                            @endguest
                        </div>
                    </div>
                    <!-- Header Toggle Start -->
                    <div class="header__toggle">
                        <!-- <div class="toggle__bar"></div> -->
                        <svg width="24" height="20" viewBox="0 0 24 20" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M23.1992 2.00039C23.1992 1.57604 23.0306 1.16908 22.7306 0.869015C22.4305 0.568967 22.0236 0.400391 21.5992 0.400391H2.39922C1.9749 0.400391 1.56786 0.568967 1.26786 0.869015C0.967859 1.16908 0.799219 1.57604 0.799219 2.00039C0.799219 2.42474 0.967859 2.8317 1.26786 3.13177C1.56786 3.43181 1.9749 3.60039 2.39922 3.60039H21.5992C22.0236 3.60039 22.4305 3.43181 22.7306 3.13177C23.0306 2.8317 23.1992 2.42474 23.1992 2.00039ZM23.1992 10.0004C23.1992 9.57604 23.0306 9.16908 22.7306 8.86901C22.4305 8.56897 22.0236 8.40039 21.5992 8.40039H11.9992C11.5749 8.40039 11.1679 8.56897 10.8679 8.86901C10.5679 9.16908 10.3992 9.57604 10.3992 10.0004C10.3992 10.4247 10.5679 10.8318 10.8679 11.1318C11.1679 11.4318 11.5749 11.6004 11.9992 11.6004H21.5992C22.0236 11.6004 22.4305 11.4318 22.7306 11.1318C23.0306 10.8318 23.1992 10.4247 23.1992 10.0004ZM23.1992 18.0004C23.1992 17.5761 23.0306 17.169 22.7306 16.869C22.4305 16.569 22.0236 16.4004 21.5992 16.4004H2.39922C1.9749 16.4004 1.56786 16.569 1.26786 16.869C0.967859 17.169 0.799219 17.5761 0.799219 18.0004C0.799219 18.4247 0.967859 18.8318 1.26786 19.1318C1.56786 19.4318 1.9749 19.6004 2.39922 19.6004H21.5992C22.0236 19.6004 22.4305 19.4318 22.7306 19.1318C23.0306 18.8318 23.1992 18.4247 23.1992 18.0004Z"
                                fill="#212529" />
                        </svg>
                    </div>
                    <!-- Hrader Toggle End -->
                </div>
                <!-- Header Meta End -->
            </div>
    </div>
    </nav>
    </div>
    <!-- Main Header End -->
</header>

<script>
    function changeCurrency(currencyCode) {
        var data = {
            _token: '{{csrf_token()}}',
            currency_code: currencyCode
        };
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '{{route('currency')}}', true);
        xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');

        // Handle the response
        xhr.onload = function() {
            if (xhr.status === 200) {
                // Reload the page to reflect the currency change
                location.reload();
            } else {
                console.error('Currency change failed.');
            }
        };
        // Send the request with the data
        xhr.send(JSON.stringify(data));

    }
</script>
