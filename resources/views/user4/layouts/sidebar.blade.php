@php
$atc = Cache()->remember('open_ticket'.auth()->id(), 240, function () {
    return \App\Models\SupportTicket::where('user_id', auth()->id())->whereNotIn('status', [1,3])->count();
});
@endphp
<div class="sidebar__mask"></div>
<div class="my--sidebar animated">
    <button type="button" class="sidebar__close animated fadeCloseBtn">
        <i class="fas fa-close fa-2x"></i>
    </button>
    <div class="sidebar__header bg-secondary">
        <div class="header__logo" >
            <a href="{{route('user.index')}}">
                <img src="{{ my_asset(get_setting('logo')) }}" alt="Logo" height="50" width="auto" />


            </a>
        </div>
    </div>
    <nav class="sidebar__menu">
        <ul class="nav flex-column">

            <a href="{{route('user.index')}}" class="ms" style="margin-bottom:30px;">
                <img src="{{ my_asset(get_setting('logo')) }}" alt="Logo" height="40" width="auto" />


            </a>


            <li class="nav-item">
                <a href="#" class="nav-link btn-primary mb-3">
                   Balance: {{format_amount(Auth::user()->balance)}}
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('user.index') }}" class="nav-link">
                    <i class="fa-duotone fa-grid-2 m-icon"></i>
                    <span class="menu-text">New Order</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('user.orders.index') }}" class="nav-link">
                    <i class="fa-duotone fa-inboxes"></i>
                    <span class="menu-text">Order History</span>
                </a>
            </li>
            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#wallet" class="nav-link" aria-expanded="false">
                    <i class="fa-duotone fa-wallet"></i>
                    <span class="menu-text">Wallet</span>
                    <span class="ms-auto fa fa-caret-down"></span>
                </a>
                <div class="collapse" id="wallet" style="">
                    <ul class="nav-collapse ms-3">
                        <li class="nav-item">
                            <a href="{{ route('user.deposit') }}" class="nav-link">
                                <i class="fa-duotone fa-credit-card"></i>
                                <span class="menu-text">Fund Wallet</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('user.transaction') }}" class="nav-link">
                               <i class="fa-duotone fa-arrow-right-arrow-left"></i>
                                <span class="menu-text">Transactions</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a href="{{ route('user.affiliate') }}" class="nav-link">
                    <i class="fa-duotone fa-gift"></i>
                    <span class="menu-text">Refer & Earn</span>
                </a>
            </li>
            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#support" class="nav-link" aria-expanded="false">
                    <i class="fa-duotone fa-headset"></i>
                    <span class="menu-text">Support</span>
                    <span class="ms-auto fa fa-caret-down"></span>
                </a>
                <div class="collapse" id="support" style="">
                    <ul class="nav-collapse ms-3">

                        <li class="nav-item">
                            <a href="{{ route('user.tickets') }}" class="nav-link">
                                <i class="fa fa-ticket m-icon"></i>
                                <span class="menu-text">Ticket</span>
                                <span class="badge badge-danger">{{$atc}}</span>
                            </a>
                        </li>


                        <li class="nav-item hidden">
                            <a href="{{ route('user.faq') }}" class="nav-link">
                                <i class="fa fa-comment m-icon"></i>
                                <span class="menu-text">FAQs</span>
                            </a>
                        </li>
                        <li class="nav-item hidden">
                            <a href="{{ route('user.terms') }}" class="nav-link">
                                <i class="fa fa-scroll m-icon"></i>
                                <span class="menu-text">User Agreement</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a href="{{ route('user.profile') }}" class="nav-link">
                    <i class="fa-duotone fa-gear"></i>
                    <span class="menu-text">Settings</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('user.api') }}" class="nav-link">
                    <i class="fa-duotone fa-code"></i>
                    <span class="menu-text">Developer API</span>
                </a>
            </li>

            {{-- <li class="nav-item">
                <a class="nav-link" href="/invoices">
                    <svg height="24" width="24"><use xlink:href="/themes/img/icons/sprite.svg?1716186385#invoices"></use></svg><span>Invoices</span><span class="badge badge-danger">1</span>
                </a>
            </li> --}}
            <li class="nav-item nav-item__logout">
                <a href="{{route('user.logout')}}" class="nav-link">
                    <i class="fa-duotone fa-power-off"></i>
                    <span>Logout</span>
                </a>
            </li>
        </ul>
    </nav>
</div>

<div class="row my--header__response">
    <div class="col d-flex align-items-center">
        <div class="header__logo">
            <a href="{{route('user.index')}}">
                 <img src="{{ my_asset(get_setting('logo')) }}" alt="Logo" height="40px" />
            </a>
        </div>
    </div>
    <div class="col d-flex align-items-center">
        <a href="#" id="hamburger" class="nav-link ms-auto pr-0 header__burger">
            <svg width="24" height="20" viewBox="0 0 24 20" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M23.1992 2.00039C23.1992 1.57604 23.0306 1.16908 22.7306 0.869015C22.4305 0.568967 22.0236 0.400391 21.5992 0.400391H2.39922C1.9749 0.400391 1.56786 0.568967 1.26786 0.869015C0.967859 1.16908 0.799219 1.57604 0.799219 2.00039C0.799219 2.42474 0.967859 2.8317 1.26786 3.13177C1.56786 3.43181 1.9749 3.60039 2.39922 3.60039H21.5992C22.0236 3.60039 22.4305 3.43181 22.7306 3.13177C23.0306 2.8317 23.1992 2.42474 23.1992 2.00039ZM23.1992 10.0004C23.1992 9.57604 23.0306 9.16908 22.7306 8.86901C22.4305 8.56897 22.0236 8.40039 21.5992 8.40039H11.9992C11.5749 8.40039 11.1679 8.56897 10.8679 8.86901C10.5679 9.16908 10.3992 9.57604 10.3992 10.0004C10.3992 10.4247 10.5679 10.8318 10.8679 11.1318C11.1679 11.4318 11.5749 11.6004 11.9992 11.6004H21.5992C22.0236 11.6004 22.4305 11.4318 22.7306 11.1318C23.0306 10.8318 23.1992 10.4247 23.1992 10.0004ZM23.1992 18.0004C23.1992 17.5761 23.0306 17.169 22.7306 16.869C22.4305 16.569 22.0236 16.4004 21.5992 16.4004H2.39922C1.9749 16.4004 1.56786 16.569 1.26786 16.869C0.967859 17.169 0.799219 17.5761 0.799219 18.0004C0.799219 18.4247 0.967859 18.8318 1.26786 19.1318C1.56786 19.4318 1.9749 19.6004 2.39922 19.6004H21.5992C22.0236 19.6004 22.4305 19.4318 22.7306 19.1318C23.0306 18.8318 23.1992 18.4247 23.1992 18.0004Z"
                                fill="#fff" />
                        </svg>
        </a>
    </div>
</div>

<style>
    .caret {
        margin: 10px;
        float: right;
        display: inline-block;
        width: 0;
        height: 0;
        margin-left: .255em;
        vertical-align: .255em;
        content: "";
        border-top: .3em solid;
        border-right: 0.3em solid transparent;
        border-bottom: 0;
        border-left: 0.3em solid transparent;

    }

    .ms {

    display:none;
}

@media (max-width: 600px) {

.ms {

    display:inline-block;
}

.mh {

    display:none;
}

]

</style>
