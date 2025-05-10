
<div class="app-header">
    <div class="container-fluid">
        <div class="row row-80">
            <div class="col-auto align-self-center">
                <div class="dash-menu-btn" onclick="dashMenuToggle()">
                    <i class="fa fa-bars"></i>
                </div>
            </div>
            <div class="col d-inline-block d-md-none align-self-center text-center">
                <div class="app-logo">
                    <img src="{{my_asset(get_setting('logo'))}}" />
                </div>
            </div>
            <div class="col col-100 d-none d-md-inline-block align-self-center"> </div>
            <div class="col-auto align-self-center">
             <button class="darkmode" onclick="change_mode()">
                 <i class="fa fa-sun"></i>
                 <i class="fa fa-moon"></i>
             </button>
             <button class="btn-sm btn-primary"><a href="{{ route('user.index') }}">
                    <i class="fa fa-user m-icon"></i>
                    <span class="menu-tex">User Login</span>
                </a></button>
            </div>

            

        </div><!-- row -->
    </div>
</div><!-- header -->
