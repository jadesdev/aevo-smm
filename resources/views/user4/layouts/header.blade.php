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
        <div class="align-items-center notification-dropdown">
            <a href="#" class="nav-link ms-auto pe-0 notification-bell" id="notificationDropdown" data-bs-toggle="dropdown"
                aria-haspopup="true">
                <i class="far fa-bell my-auto"></i>
                <span class="notification-badge">{{ userUnreadNotifications() }}</span>
            </a>
            
            <div class="dropdown-menu notify-dropdown px-1" aria-labelledby="notificationDropdown">
                <div class="p-2 d-flex justify-content-between">
                    <h6 class="m-0 fw-semibold"> Notifications</h6>
                    <button type="button" class="d-lg-none btn-close" data-bs-dismiss="dropdown"
                                aria-label="Close"></button>
                </div>
                <div style="overflow-y: auto;" class="j-scroller noti-height" id="notifysContent">
                    @forelse (auth()->user()->notifys()->limit(10)->get()  as $item)
                        <a href="@if ($item->url) {{ $item->url }} @else javascript:void(0); @endif"
                            class="dropdown-item p-0 notify-item ">

                            <div class="card-notif px-1">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 text-truncate ms-2">
                                        <h4 class="noti-item-title fw-semibold fs-14" style="text-transform:uppercase;">
                                            {{ $item->title }} </h4>

                                        <p class="noti-item-subtitle text">{!! nl2br($item->message) !!} </p>
                                        <small
                                            class="tima text-muted float-end mx-1">{{ $item->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @empty
                        <a href="javascript:void(0);" class="dropdown-item p-0 notify-item">
                            <div class="card px-4 ">
                                <div class="d-flex align-items-center py-3">
                                    <div class="flex-grow-1 text-truncate ms-2 text-center">
                                        <i class="fas fa-bell-slash fa-2x fa-spin"></i>
                                        <h6 class="noti-item-title fw-semibold fs-14 mt-3">No New Notifications</h6>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforelse
                </div>
            </div>
        </div>
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
