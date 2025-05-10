@extends('user4.layouts.master')
@section('title', 'Bills Payment')

@section('content')
<div class="row g-3"  style="padding: 10px 20px;">
  @if (sys_setting('is_airtime') == 1)
    <div class="col-6 col-sm-4 col-lg-3">



     <a href="{{route('user.bills.airtime')}}"> <div class="carda-content"><div class="product">
			<i class="fa fa-phone serv"></i>
				<h5 style="margin-top: 10px;font-size:14px;">Airtime</h5>

			</div></div></a>
    </div>
  @endif
  @if (sys_setting('is_data') == 1)
    <div class="col-6 col-sm-4 col-lg-3">

         <a href="{{route('user.bills.data')}}"><div class="carda-content"><div class="product">
			<i class="fa fa-wifi serv"></i>
				<h5 style="margin-top: 10px;font-size:14px;">Data</h5>

			</div></div></a>


    </div>
  @endif


  @if (sys_setting('is_betting') == 1)
    <div class="col-6 col-sm-4 col-lg-3">
       <a href="{{route('user.bills.bet')}}"><div class="carda-content"><div class="product">
			<i class="fa fa-soccer-ball serv"></i>
				<h5 style="margin-top: 10px;font-size:14px;">Betting</h5>

			</div></div></a>


    </div>
  @endif


  @if (sys_setting('is_cable') == 1)
    <div class="col-6 col-sm-4 col-lg-3">
       <a href="{{route('user.bills.cable')}}"><div class="carda-content"><div class="product">
			<i class="fa fa-tv serv"></i>
				<h5 style="margin-top: 10px;font-size:14px;">CableTV</h5>

			</div></div></a>


    </div>
  @endif
  @if (sys_setting('is_power') == 1)
    <div class="col-6 col-sm-4 col-lg-3">


        <a href="{{route('user.bills.power')}}"><div class="carda-content"><div class="product">
			<i class="fa fa-bolt serv"></i>
				<h5 style="margin-top: 10px;font-size:14px;">Electricity</h5>

			</div></div></a>



    </div>
  @endif

  <div class="col-6 col-sm-4 col-lg-3">
       <a href="#"><div class="carda-content"><div class="product">
			<i class="fa fa-tv serv"></i>
				<h5 style="margin-top: 10px;font-size:14px;">Coming Soon</h5>

			</div></div></a>


    </div>

</div>
<span class="pb-5"></span>
@endsection

@section('breadcrumb')
<div class="card dc-dash">
    <div class="row">
        <div class="col-lg-7 col-md-9 col-12">
            <div class="py-3 px-5">
                <div class="dch-title">
                   @yield('title')
                </div>
                <div class="dch-text">
                    You can quickly pay for your Bills and Purchase Airtime. </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('styles')
<style>



    /* :: Product CSS */
    .product-details-card {
    position: relative;
    z-index: 1;
    }
    .product-details-card .product-badge {
    top: 2.5rem;
    left: 2.5rem;
    z-index: 100;
    }
    .product-details-card .product-gallery > a {
    cursor: -webkit-zoom-in;
    cursor: zoom-in;
    }

    .single-product-card {
    position: relative;
    z-index: 1;
    }
    .single-product-card .product-thumbnail {
    position: relative;
    z-index: 1;
    }
    .single-product-card .product-thumbnail img {
    border-radius: 0.375rem;
    }
    .single-product-card .product-thumbnail .badge {
    position: absolute;
    right: 1rem;
    bottom: 1rem;
    z-index: 10;
    }
    .single-product-card .product-title {
    font-size: 1.125rem;
    color: #000;
    margin-top: 0.75rem;
    font-weight: 500;
    margin-bottom: 0.25rem;
    }
    .single-product-card .sale-price {
    font-size: 1rem;
    color: #0d5afd;
    font-weight: 500;
    }
    .single-product-card .sale-price span {
    font-size: 1rem;
    margin-left: 0.25rem;
    text-decoration: line-through;
    color: #ea4c62;
    }

    .product-list-wrap .single-product-card .product-thumbnail img {
    max-height: 7rem;
    }
    .g-3 { row-gap: 1rem;}
    .bill-img{width: 90%;height:90% ; }
</style>
@endsection
