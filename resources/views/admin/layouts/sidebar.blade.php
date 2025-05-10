@php
$utc = Cache()->remember('support_ticket_count', 30, function () {
    return \App\Models\SupportTicket::where('status', '!=', 3)->count();
});
@endphp
<div class="app-sidebar">
    <div class="close-sidebar-btn" onclick="dashMenuToggle()">
        <i class="fas fa-bars"></i>
    </div>
    <div class="sidebar-header" style="padding-bottom:20px;">
        <div class="sh-bg"></div>
        <div class="app-logo">
            <img src="{{ my_asset(get_setting('logo')) }}" class="logo-lg" alt="">
            <img src="{{ my_asset(get_setting('favicon')) }}" class="logo-sm" alt="">
        </div>

    </div>
    <div class="sidebar-content">
        <ul class="sidebar-menu">
            <li class="">
                <a href="{{ route('admin.dashboard') }}">
                    <i class="fa fa-tachometer m-icon"></i>
                    <span class="menu-text">Dashboard</span>
                </a>
            </li>

            <li>

                <a data-toggle="collapse" href="#prov" class="" aria-expanded="false">
                    <i class="fa fa-code m-icon"></i>
                    <span class="menu-text">Service Management</span>
                    <span class="caret"></span>
                </a>
                <div class="collapse" id="prov" style="">
                    <ul class="nav-collapse">
                        <li>
                            <a href="{{ route('admin.provider.index') }}">
                                <i class="fa fa-code m-icon"></i>
                                <span class="menu-text">API Providers</span>
                            </a>
                        </li>

                        <li class="">
                            <a href="{{ route('admin.stats') }}">
                                <i class="fa fa-tachometer m-icon"></i>
                                <span class="menu-text">Provider Stats</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('admin.category.index') }}">
                                <i class="fa fa-list-ul m-icon"></i>
                                <span class="menu-text">Categories</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('admin.service.index') }}">
                                <i class="fa fa-list-ul m-icon"></i>
                                <span class="menu-text">Services</span>
                            </a>
                        </li>

                    </ul>
                </div>
            </li>
            <li>
                <a data-toggle="collapse" href="#user" class="" aria-expanded="false">
                    <i class="fa fa-user-friends m-icon"></i>
                    <span class="menu-text">Manage Users</span>
                    <span class="caret"></span>
                </a>
                <div class="collapse" id="user" style="">
                    <ul class="nav-collapse">
                        <li>
                            <a href="{{ route('admin.users.index') }}">
                                <i class="fa fa-user-friends m-icon"></i>
                                <span class="menu-text">All Users</span>
                            </a>
                            <a href="{{ route('admin.users.downline') }}">
                                <i class="fa fa-user-friends m-icon"></i>
                                <span class="menu-text">User Downlines</span>
                            </a>
                            <a href="{{ route('admin.users.settings') }}">
                                <i class="fa fa-cog m-icon"></i>
                                <span class="menu-text">Settings</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li>
                <a data-toggle="collapse" href="#finance" class="" aria-expanded="false">
                    <i class="fa fa-dollar-sign m-icon"></i>
                    <span class="menu-text">Finance</span>
                    <span class="caret"></span>
                </a>
                <div class="collapse" id="finance" style="">
                    <ul class="nav-collapse">
                        <li>
                            <a href="{{ route('admin.deposit') }}">
                                <i class="fa fa-dollar-sign m-icon"></i>
                                <span class="menu-text">Deposits</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.transactions') }}">
                                <i class="fa fa-history m-icon"></i>
                                <span class="menu-text">Transaction Logs</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.mdeposit') }}">
                                <i class="fa fa-history m-icon"></i>
                                <span class="menu-text">Manual Deposits</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('admin.withdrawal') }}">
                                <i class="fa fa-history m-icon"></i>
                                <span class="menu-text">Withdrawals</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li>
                <a href="{{ route('admin.orders.index') }}">
                    <i class="fa fa-shopping-cart m-icon"></i>
                    <span class="menu-text">Manage Orders</span>
                </a>
            </li>
            <li style="display:none;">
                <a href="{{route('admin.listing.pending')}}">
                    <i class="fa fa-lock m-icon"></i>
                    <span class="menu-text">Manage Listings</span>
                </a>
            </li>



            <li class="sidebar-title">
                {{-- <span class="text-white ml-5">Supports</span> --}}
            </li>

            <li>
                <a href="{{ route('admin.support.tickets') }}">
                    <i class="fa fa-headset m-icon"></i>
                    <span class="menu-text">Support
                        <span class="badge bg-primary ml-4">{{$utc}}</span>
                    </span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.newsletter') }}">
                    <i class="fa fa-envelope m-icon"></i>
                    <span class="menu-text">Newsletter</span>
                </a>
            </li>
            <li class="sidebar-title">
                {{-- <span class="text-white ml-5 menu-text">Reports</span> --}}
            </li>
            <li>
                <a href="{{ route('admin.faqs.index') }}">
                    <i class="fa fa-folder m-icon"></i>
                    <span class="menu-text">FAQs</span>
                </a>
            </li>
            <li> <a data-toggle="collapse" href="#settings" class="" aria-expanded="false">
                    <i class="fa fa-cogs m-icon"></i>
                    <span class="menu-text">Settings</span>
                    <span class="caret"></span>
                </a>
                <div class="collapse" id="settings" style="">
                    <ul class="nav-collapse">
                        <li>
                            <a href="{{ route('admin.setting.index') }}">
                                <i class="fa fa-cog m-icon"></i>
                                <span class="menu-text">General Settings</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.setting.payment') }}">
                                <i class="fa fa-credit-card m-icon"></i>
                                <span class="menu-text">Payment Settings</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('admin.currency.index') }}">
                                <i class="fa fa-cog m-icon"></i>
                                <span class="menu-text">Currency Settings</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('admin.setting.features') }}">
                                <i class="fa fa-cogs m-icon"></i>
                                <span class="menu-text">System Settings</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('admin.setting.email') }}">
                                <i class="fa fa-envelope m-icon"></i>
                                <span class="menu-text">Email Settings</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.point-system') }}">
                                <i class="fa fa-coins m-icon"></i>
                                <span class="menu-text">Point System</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('admin.bonus') }}">
                                <i class="fa fa-money-bill m-icon"></i>
                                <span class="menu-text">Payment Bonus</span>
                            </a>
                        </li>

                    </ul>
                </div>
            </li>
            <li class="sidebar-title">
                {{-- <span class="ml-5 menu-text">Settings</span> --}}
            </li>


            <li>
                <a href="{{ route('admin.setting.news') }}">
                    <i class="fa fa-file m-icon"></i>
                    <span class="menu-text">News Section</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.setting.custom') }}">
                    <i class="fa fa-code m-icon"></i>
                    <span class="menu-text">Custom CSS & JS</span>
                </a>
            </li>
            <li style="display:none;">
                <a href="{{ route('admin.panel.status') }}">
                    <i class="fa fa-server m-icon"></i>
                    <span class="menu-text">Panel Status</span>
                </a>
            </li>
        </ul>
    </div>
</div>

<style>
    .nav-collapse {
        margin: 0;
        padding: 0;
    }
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

    .app-container .app-sidebar .sidebar-content .sidebar-menu>li a {
    display: block;
    padding:  10px;
    margin: 0;
    border-radius: 0;
    border-left: 5px solid transparent;
    color: #fff;
    font-size: 14px;
    line-height: 1.5;
    height: 40px;
    font-weight: 400;
    text-decoration: none;
    -webkit-transition: .2s ease;
    transition: .2s ease;
}
.app-container .app-sidebar {
  background-color: #000;

}

.app-sidebar .sidebar-header .sh-bg {

  background: #000;

}


    .app-container .app-sidebar .sidebar-content {
    -webkit-box-flex: 1;
    -ms-flex: 1;
    flex: 1;
    padding-bottom: 40px;
    margin-top: 0;
}




</style>
