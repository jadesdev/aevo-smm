<div class="app-header">
    <div class="container-fluid">
        <div class="header-wrapper">
            <!-- Brand Logo and Name -->
            <div class="col-auto align-self-center">
                <div class="dash-menu-btn" onclick="dashMenuToggle()">
                    <i class="fas fa-bars"></i>
                </div>
            </div>

            <!-- User Account Area -->
            <div class="user-area">
                <div class="user-balance">
                    {{ format_amount(Auth::user()->balance) }}
                </div>
                @if (sys_setting('multi_currency') == 1)
                    <div class="currency-switcher">
                        <select id="currency-select" style="background: #ff401a;  color: #fff; font-size: 10px;  border: none;"
                            class="form-control" onchange="changeCurrency(this.value)">
                            @foreach (get_all_active_currency() as $currency)
                                <option value="{{ $currency->code }}" @if (get_system_currency()->code == $currency->code) selected @endif
                                    data-currency="{{ $currency->code }}">{{ $currency->code }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
                <button class="darkmode d-none d-md-block" onclick="change_mode()">
                    <i class="fa fa-sun"></i>
                    <i class="fa fa-moon"></i>
                </button>
                <!-- Notification Bell -->
                <div class="notification-dropdown">
                    <div class="notification-bell" aria-expanded="false" id="notificationDropdown" data-toggle="dropdown"
                        aria-haspopup="true">
                        <i class="far fa-bell"></i>
                        <span class="notification-badge">{{ userUnreadNotifications() }}</span>
                    </div>
                    <div class="dropdown-menu notify-dropdown px-1" aria-labelledby="notificationDropdown">
                        <div class="p-2 d-flex justify-content-between">
                            <h6 class="m-0 fw-semibold"> Notifications</h6>
                            <button type="button" class="d-lg-none btn btn-outline-secondary my-auto" data-dismiss="dropdown"
                                aria-label="Close">X</button>
                        </div>
                        <div style="overflow-y: auto;" class="j-scroller noti-height" id="notifysContent">
                            @forelse (auth()->user()->notifys as $item)
                                <a href="@if ($item->url) {{ $item->url }} @else javascript:void(0); @endif"
                                    class="dropdown-item p-0 notify-item ">

                                    <div class="card-notif px-1">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 text-truncate ms-2">
                                                <h4 class="noti-item-title fw-semibold fs-14" style="text-transform:uppercase;">
                                                    {{ $item->title }} </h4>

                                                <p class="noti-item-subtitle text-muted">{!! nl2br($item->message) !!} </p>
                                                <small
                                                    class="tima text-muted float-right mx-1">{{ $item->created_at->diffForHumans() }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @empty
                                <a href="javascript:void(0);" class="dropdown-item p-0 notify-item">
                                    <div class="d-card px-4 ">
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

                <!-- User Profile Picture -->
                <div class="dropdown user-profile">
                    <img src="{{ static_asset('img/avatar.png') }}" alt="Profile" class="profile-image dropdown-toggle" id="userDropdown"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                    <div class="dropdown-menu" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="{{ route('user.profile') }}"><i class="fas fa-user mr-2"></i> My Profile</a>
                        <a class="dropdown-item" href="{{ route('user.deposit') }}"><i class="fas fa-wallet mr-2"></i> Deposit</a>
                        <a href="javascript::void()" class="dropdown-item darkmode" onclick="change_mode()">
                            <div class="theme-mode">
                                <i class="fa fa-moon"></i>
                                <span class="light-txt">Light Mode</span>
                            </div>
                            <div class="theme-mode">
                                <i class="fa fa-sun"></i>
                                <span class="dark-txt">Dark Mode</span>
                            </div>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('logout') }}"><i class="fas fa-power-off mr-2"></i> Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function changeCurrency(currencyCode) {
        var data = {
            _token: '{{ csrf_token() }}',
            currency_code: currencyCode
        };
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '{{ route('currency') }}', true);
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
