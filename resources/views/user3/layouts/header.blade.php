<div class="row my--header">
    <div class="col d-flex align-items-center">
        <h3 class="my--title">@yield('title')</h3>

        @yield('page-btn')
    </div>

    <div class="col d-flex align-items-center header__logout">
        <a href="{{route('user.logout')}}" class="nav-link ms-auto pe-0 ">
            <i class="fa fa-power-off my-auto"></i>
            <span>Logout</span>
        </a>
    </div>
</div>

