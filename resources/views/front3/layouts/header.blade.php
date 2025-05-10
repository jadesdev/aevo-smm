
<nav class="navbar navbar-expand-sm fixed-top">
    <div class="container flex-wrap flex-sm-nowrap">
        <a class="navbar-brand order-1" href="{{route('index')}}">
            <img src="{{ my_asset(get_setting('logo')) }}" alt="Logo" height="40" width="auto" class="d-none d-md-inline-block">
            <img src="{{ my_asset(get_setting('favicon')) }}" alt="Logo" width="30" height="30" class="d-inline-block d-md-none">
        </a>
        <button class="navbar-toggler order-2" type="button" data-bs-toggle="collapse" data-bs-target="#perfectnavbar" aria-controls="perfectnavbar" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fa-sharp fa-regular fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse justify-content-center order-4 order-sm-3" id="perfectnavbar">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('services')}}">Services </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('faq')}}">FAQ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('api_docs')}}">API</a>
                </li>

                <li class="nav-item d-sm-none d-block">
                    @guest
                        <a href="{{route('login')}} " class="">Sign In </a>
                        <a href="{{route('register')}}" class="btn btn-primary">Sign Up </a>
                    @else
                        <a href="{{route('user.index')}}" class="btn btn-secondary">Dashboard </a> 
                    @endguest
                </li>
            </ul>
        </div>
        <div class="navbar-sign order-3 order-sm-4">
            @guest
                <a href="{{route('login')}}" style="background:#000;" class="btn btn-primary d-none d-sm-block"> Sign In </a>
                <a href="{{route('register')}}" class="btn btn-primary d-none d-sm-block">Sign Up </a>
            @else
                <a href="{{route('user.index')}}" class="btn btn-secondary">Dashboard </a>
            @endguest

        </div>
    </div>
</nav>
