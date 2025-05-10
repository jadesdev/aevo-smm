
<div class="app-header">
    <div class="container-fluid">
        <div class="row row-80">
            <div class="col-auto align-self-center">
                <div class="dash-menu-btn" onclick="dashMenuToggle()">
                    <i class="fas fa-grip-lines"></i>
                </div>
            </div>

            <div class="col col-100 d-none d-md-inline-block align-self-center"> </div>


            <div class="col-auto align-self-center dash-menu-btn text-end" style="">

                <ul class="list-inline" style="">
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
                    <li class="list-inline-item">
                        <button class="darkmode" onclick="change_mode()">
                            <i class="fa fa-sun"></i>
                            <i class="fa fa-moon"></i>
                        </button>
                        </li>
                        <li class="list-inline-item"><a href="{{ route('logout') }}"><i class="fa fa-power-off"></i></a></li>

                        <li class="list-inline-item">

                        <div class="app-user-box">
                        {{-- <div class="app-user-img">
                            <a href="{{ route('user.index') }}">
                                <img src="{{ static_asset('img/avatar.png') }}">
                            </a>
                        </div> --}}
                        <div class="app-user-info">
                            <h4 class="app-user-name">{{ text_trim2(Auth::user()->username, 10) }} <img
                                    src="{{ static_asset('img/verified.png') }}" width="16" /></h4>
                            <div class="app-user-blnce">{{ format_amount(Auth::user()->balance) }}</div>
                        </div>
                    </div>

                    </li>

                </ul>

            </div>
        </div><!-- row -->
    </div>
</div><!-- header -->

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
