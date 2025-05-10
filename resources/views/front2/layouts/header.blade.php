<nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top">
    <div class="container">
        <a class="navbar-brand logo-image" href="{{route('index')}}">
            <img src="{{my_asset(get_setting('logo'))}}" alt="Website logo">
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-awesome fas fa-bars"></span>
            <span class="navbar-toggler-awesome fas fa-times"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link page-scroll" href="{{route('services')}}">Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link page-scroll" href="{{route('api_docs')}}">API</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link page-scroll" href="{{route('faq')}}">FAQ</a>
                </li>
            </ul>
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
            @guest
            <span class="nav-item">
                <a class="btn-outline-sm" href="{{route('signup')}}">Sign Up</a>
            </span>
            @else
            <span class="nav-item">
                <a class="btn-outline-sm" href="{{route('user.dashboard')}}">Dashboard</a>
            </span>
            @endguest
        </div>
    </div>
</nav>

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
