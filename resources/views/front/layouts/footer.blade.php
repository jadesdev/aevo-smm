

<div class="footer">
    <div class="container">
      <div class="ft-content">
        <div class="ftc-top">
          <div class="row">
            <div class="col-md-auto col-12 text-center text-md-left">
              <div class="ftc-name">
                <div class="row">
                  <div class="col align-self-center">
                    <div class="fct-name">
                      <img class="img-fluid" src="{{my_asset(get_setting('logo'))}}" style="max-height: 40px;" />
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md col-12 mt-4 mt-lg-0 align-self-center">
              <div class="footer-links text-md-right text-center">
                 
          <p style="color:#fff;"> Copyright ©{{date('Y')}} {{get_setting('title')}}. All rights reserved.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="ft-content-bot">
        <div class="ft-content-bot-text"><br />
         <img src="{{static_asset('theme4/front/images/payment_method_banner73.png')}}" alt="payment" width="auto" />
        </div>
      </div>
    </div>
</div>



@guest
<nav class="mob-nav">
    <ul class="mob-nav-link">
      <li>
        <a href="{{route('index')}}">
          <i class="fa fa-sign-in-alt"></i>
          <span>Login</span> 
        </a>
      </li>
      <li>
        <a href="{{route('services')}}">
          <i class="fa fa-tags"></i>
          <span>Services</span> 
        </a>
      </li>
      <li>
        <a href="{{route('signup')}}">
          <i class="fa fa-user"></i>
          <span>Sign Up</span> 
        </a>
      </li>
    </ul>
</nav>

@else
<nav class="mob-nav">
    <ul class="mob-nav-link">
        <li>
            <a href="{{route('user.services')}}">
                <i class="fa fa-tags"></i>
                <span>Services</span>
            </a>
        </li>
        <li>
            <a href="{{route('user.deposit')}}">
                <i class="fa fa-wallet"></i>
                <span>Add Balance</span>
            </a>
        </li>
        <li>
            <a href="{{route('user.orders.create')}}" class="active">
                <i class="fa fa-edit"></i>
                <span>Place Order</span>
            </a>
        </li>
        <li>
            <a href="{{route('user.orders.index')}}">
                <i class="fa fa-shopping-bag"></i>
                <span>Orders</span>
            </a>
        </li>
        <li>
            <a href="{{route('user.tickets')}}">
                <i class="fa fa-ticket"></i>
                <span>Support</span>
            </a>
        </li>
    </ul>
</nav>
@endguest
