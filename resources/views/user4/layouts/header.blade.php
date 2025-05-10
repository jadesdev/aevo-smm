<div class="row my--header">
    <div class="col d-flex align-items-center">
        <h3 class="my--title">@yield('title')</h3>

        @yield('page-btn')
    </div>


    <div class="col d-flex align-items-center float-end">
        {{-- <a href="{{route('user.logout')}}" class="nav-link ms-auto pe-0 ">
            <i class="fa fa-power-off my-auto"></i>
            <span>Logout</span>
        </a> --}}
        @if (sys_setting('multi_currency') == 1)
            <div class="currency-switcher nav-link ms-auto pe-1">
                <select id="currency-select" class="form-control form-select" onchange="changeCurrency(this.value)">
                    @foreach (get_all_active_currency() as $currency)
                    <option value="{{$currency->code}}" @if (get_system_currency()->code == $currency->code) selected @endif data-currency="{{ $currency->code }}" >{{$currency->code}}</option>
                    @endforeach
                </select>
            </div>
        @endif
        <div class="d-flex align-items-center header__logout">
            <a href="{{route('user.logout')}}" class="nav-link ms-auto pe-0 ">
                <i class="fa fa-power-off my-auto"></i>
                <span>Logout</span>
            </a>
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
