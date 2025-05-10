<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="title" Content="Payment Successful">
    <meta name="description" content="{{get_setting('description')}}">

    <meta itemprop="image" content="{{my_asset(get_setting('logo'))}}">
    <!-- Facebook Meta Tags -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{get_setting('title')}}">
    <meta property="og:description" content="{{get_setting('description')}}">
    <meta property="og:image" content="{{my_asset(get_setting('logo'))}}"/>
    <meta property="og:image:type" content="image/png" />
    <meta property="og:image:width" content="600" />
    <meta property="og:image:height" content="315" />
    <meta property="og:url" content="{{url()->current()}}">
    <!-- Twitter Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <link rel="stylesheet" href="{{static_asset('theme2/css/bootstrap.css')}}" />
    {{-- <link rel="stylesheet" href="{{static_asset('css/invoice.css')}}" /> --}}
    <title> Payment Error | {{ get_setting('title') }}</title>
    <link rel="icon" type="image/png" href="{{my_asset(get_setting('favicon'))}}" sizes="16x16">

  </head>
  <body>
    <div class="container">
      <div class="row justify-content-center mt-5">
        <div class="col-md-8">
            <div class="row mt-3">
              <div class="col-lg-12">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-sm-5 text-center">
                        <img src="{{my_asset(get_setting('logo'))}}" alt="logo" class="invoice-logo-filter" style="max-width: 100%;">
                      </div>
                      <div class="col-sm-7 mt-5">
                        <h5 class="h2 text-uppercase text-danger">Payment </br> Was not Succesful</h5>
                      </div>
                    </div>
                    <br><br>
                    <hr>
                    <h3 class="px-2 text- text-uppercase h2" style="color: red;">
                      @if(Session::get('error'))
                        {{Session::get('error')}}
                      @else
                      PAYment was not successful. Please try again
                      @endif
                    </h3>
                    {{-- <h6 class="text-uppercase">Payment might have been completed</h6> --}}
                    <br>
                        <p class="font-weight-bold text-center text-uppercase">Thanks for choosing us</p>
                    <br>
                    <br>
                  </div>
                </div>
              </div>
            </div>
          </div>
      </div>
    </div>
  <style>
    .invoice-logo-filter{
      filter: contrast(400%) brightness(90%);
      height: 200px;
    }
  </style>
    <script type="text/javascript" src="{{static_asset('theme2/js/vendors/bootstrap.bundle.min.js')}}"></script>

  <script>
    var dwnldBtn = document.getElementById('download-btn')
    dwnldBtn.addEventListener('click',function () {
      window.print();
    })
  </script>
  </body>
</html>
