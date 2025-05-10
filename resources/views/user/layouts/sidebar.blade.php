<div class="app-sidebar">
    <div class="close-sidebar-btn" onclick="dashMenuToggle()">
        <i class="fas fa-bars"></i>
    </div>
    <div class="sidebar-header">
        <div class="sh-bg"></div>
        <div class="app-logo"><a href="{{ route('user.index') }}">
                <img src="{{ my_asset(get_setting('logo')) }}" class="logo-lg" alt="">
                <img src="{{ my_asset(get_setting('favicon')) }}" class="logo-sm" alt=""></a>
        </div>
        
        
        <div class="col d-inline-block d-md-none align-self-center text-center">
                <div class="app-logo">
                    <img src="{{my_asset(get_setting('logo'))}}" />
                </div>
            </div>
        
       
    </div>
    
    
    <div class="sidebar-content">
        <ul class="sidebar-menu">
            <li class="">
                <a href="{{ route('user.index') }}">
                    
                    <i class="fa fa-tachometer m-icon"></i>
                    <span class="menu-text">Dashboard</span>
                </a>
            </li>
            <li hidden>
                <a href="{{ route('user.services') }}">
                    <i class="fa fa-list-ul m-icon"></i>
                    <span class="menu-text">Services</span>
                </a>
            </li>
            <li class="">
                <a href="{{ route('user.orders.create') }}">
                    <i class="fa fa-cart-shopping m-icon"></i>
                    <span class="menu-text">New Order</span>
                </a>
            </li>
            <li>
                <a href="{{ route('user.orders.index') }}">
                    <i class="fa fa-box m-icon"></i>
                    <span class="menu-text">Order History</span>
                </a>
            </li>
            
            
                <li>
                <a data-toggle="collapse" href="#wallet" class="" aria-expanded="false">
                    <i class="fa fa-wallet m-icon"></i>
                    <span class="menu-text">Wallet</span>
                    <span class="caret"></span>
                </a>
                <div class="collapse" id="wallet" style="">
                    <ul class="nav-collapse">
                        <li>
                            <a href="{{ route('user.deposit') }}">
                              
                                <span class="menu-text">Fund Wallet</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('user.transaction') }}">
                                
                                <span class="menu-text">Transactions</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            

            <li>
                <a href="{{ route('user.affiliate') }}">
                    <i class="fa fa-gift m-icon"></i>
                    <span class="menu-text">Refer & Earn</span>
                </a>
            </li>
            <li>
                <a data-toggle="collapse" href="#support" class="" aria-expanded="false">
                    <i class="fa fa-headset m-icon"></i>
                    <span class="menu-text">Support</span>
                    <span class="caret"></span>
                </a>
                <div class="collapse" id="support" style="">
                    <ul class="nav-collapse">

                        <li>
                            <a href="{{ route('user.tickets') }}">
                                <i class="fa fa-ticket m-icon"></i>
                                <span class="menu-text">Ticket</span>
                            </a>
                        </li>


                        
                        <li>
                            <a href="{{ route('user.terms') }}">
                                <i class="fa fa-scroll m-icon"></i>
                                <span class="menu-text">Panel Policy</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li>
                <a href="{{ route('user.profile') }}">
                    <i class="fa fa-cog m-icon"></i>
                    <span class="menu-text">Settings</span>
                </a>
            </li>

            <li>
                <a href="{{ route('user.api') }}">
                    <i class="fa fa-code m-icon"></i>
                    <span class="menu-text">Developer API</span>
                </a>
            </li>


        </ul>
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
