<div class="header">
    <div class="container">
        <div class="row" style="height: 99px;">
            <div class="col-auto align-self-center">
                <div class="row">
                <div class="col align-self-center">
                    <a href="{{route('index')}}">
                    <div class="site-name">
                        <img src="{{my_asset(get_setting('logo'))}}" class="ml-2"   alt="logo"   />
                    </div>
                    </a>
                </div>
                </div>
            </div>
        <div class="col">
            <div class="head-menu">
                <div class="row">
                    <div class="col text-lg-right mmff">
                        <div class="header-menu">
                            <ul>
                                <li>
                                    <a href="{{route('services')}}">Our Services</a>
                                </li>
                                <li>
                                    <a href="{{route('faq')}}">FAQ</a>
                                </li>
                                <li>
                                    <a href="{{route('api_docs')}}">API Documentation</a>
                                </li>
                                 <li>
                                    <a href="{{route('login')}}">Sign In</a>
                                </li>
                                @if (sys_setting('multi_currency') == 1)
                                <li class="list-inline-item">
                                    <div class="currency-switcher">
                                        <select id="currency-select" class="form-control" onchange="changeCurrency(this.value)">
                                            @foreach (get_all_active_currency() as $currency)
                                            <option value="{{$currency->code}}" @if (get_system_currency()->code == $currency->code) selected @endif data-currency="{{ $currency->code }}" >{{$currency->code}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                    <div class="col-auto align-self-center mmff">
                        <a href="{{route('signup')}}" class=" btn btn-primary">
                           Register
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-auto for-mobile align-self-center">
            <div class="home-menu-btn px-3 py-4" onclick="homeMenuToggle()" style="">
            <i class="fas fa-grip-lines"></i>
            </div>
        </div>
        </div>
    </div>
</div>

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
