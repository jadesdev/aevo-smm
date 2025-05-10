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
            <li class="nav-item">
                <a href="{{ route('user.index') }}" class="nav-link">
                    <i class="fa-duotone fa-grid-2 m-icon"></i>
                    <span class="menu-text">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('user.orders.create') }}" class="nav-link">
                   <i class="fa-duotone fa-cart-plus m-icon"></i>
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
                <img src="{{ my_asset(get_setting('favicon')) }}" alt="Logo" height="50" />
            </a>
        </div>
    </div>
    <div class="col d-flex align-items-center">
        <a href="#" id="hamburger" class="nav-link ms-auto pr-0 header__burger">
            <i class="fad fa-bars fa-2x"></i>
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
</style>
