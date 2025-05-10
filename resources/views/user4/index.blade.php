@extends('user4.layouts.master')
@section('title', 'Dashboard')

@section('content')
@php
    $user = Auth::user();
    // orders
    $category = App\Models\Category::whereHas('activeServices')->whereStatus(1)->orderBy('name')->get();
@endphp
<div class="row admin-fa_icon">

    <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
        <div class="card   ">
            <div class="card-body">
                <div class="d-flex d-lg-flex d-md-block align-items-center justify-content-between">
                    <div>
                        <div class="d-inline-flex align-items-center">
                            <h3 class=" mb-1 font-weight-medium">{{format_amount(Auth::user()->balance)}}
                            </h3>
                        </div>
                        <p class="text-muted font-weight-normal mb-0 w-100 text-truncate">Your Balance</p>
                    </div>

                    <div class=" mt-md-3 mt-lg-0">
                        <span class="opacity-7 primary-color"><i class="fa-duotone fa-dollar-sign fa-2x"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3" style="display:none;">
        <div class="card  ">
            <div class="card-body">
                <div class="d-flex d-lg-flex d-md-block align-items-center justify-content-between">
                    <div>
                        <h3 class="mb-1 w-100 text-truncate font-weight-medium">{{ format_amount($user->transactions->where('status', 1)->where('type',2)->sum('amount')) }}</h3>
                        <p class="text-muted font-weight-normal mb-0 w-100 text-truncate">Total Spent </p>
                    </div>

                    <div class=" mt-md-3 mt-lg-0">
                        <span class="opacity-7 primary-color"><i class="fas fa-exchange-alt fa-2x"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
        <div class="card  ">
            <div class="card-body">
                <div class="d-flex d-lg-flex d-md-block align-items-center justify-content-between">
                    <div>
                        <div class="d-inline-flex align-items-center">
                            <h2 class="mb-1 font-weight-medium">{{ format_amount($user->deposits->where('status',1)->sum('amount')) }} </h2>
                        </div>
                        <p class="text-muted font-weight-normal mb-0 w-100 text-truncate">Total Deposit</p>
                    </div>

                    <div class=" mt-md-3 mt-lg-0">
                        <span class="opacity-7 primary-color"><i class="fa-duotone fa-credit-card fa-2x"></i></span>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
        <div class="card  ">
            <div class="card-body">
                <div class="d-flex d-lg-flex d-md-block align-items-center justify-content-between">
                    <div>
                        <h2 class=" mb-1 font-weight-medium">{{ $user->transactions->count() }}</h2>
                        <p class="text-muted font-weight-normal mb-0 w-100 text-truncate">Total Transactions</p>
                    </div>

                    <div class="mt-md-3 mt-lg-0">
                        <span class="opacity-7 primary-color"><i class="fa-duotone fa-arrow-right-arrow-left fa-2x"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
        <div class="card  ">
            <div class="card-body">
                <div class="d-flex d-lg-flex d-md-block align-items-center justify-content-between">
                    <div>
                        <div class="d-inline-flex align-items-center">
                            <h2 class="mb-1 font-weight-medium">{{ $user->orders->count() }}</h2>
                        </div>
                        <p class="text-muted font-weight-normal mb-0 w-100 text-truncate">Total Orders</p>
                    </div>

                    <div class=" mt-md-3 mt-lg-0">
                        <span class="opacity-8 primary-color"><i class="fa-duotone fa-solid fa-loader fa-2x"></i></span>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3" style="display:none;">
        <div class="card  ">
            <div class="card-body">
                <div class="d-flex d-lg-flex d-md-block align-items-center justify-content-between">
                    <div>
                        <h2 class="mb-1 font-weight-medium">{{ ($user->orders->where('status','processing')->count()) }}</h2>
                        <p class="text-muted font-weight-normal mb-0 w-100 text-truncate">Processing Orders</p>
                    </div>

                    <div class=" mt-md-3 mt-lg-0">
                        <span class="opacity-7 primary-color"><i class="fab fa-first-order fa-2x"></i></span>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3" style="display:none;">
        <div class="card  ">
            <div class="card-body">
                <div class="d-flex d-lg-flex d-md-block align-items-center justify-content-between">
                    <div>
                        <h2 class=" mb-1 font-weight-medium">{{ ($user->orders->where('status','pending')->count()) }}</h2>
                        <p class="text-muted font-weight-normal mb-0 w-100 text-truncate">Pending Orders</p>
                    </div>

                    <div class=" mt-md-3 mt-lg-0">
                        <span class="opacity-7 primary-color"><i class="fas fa-spinner fa-2x"></i></span>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3" style="display:none;">
        <div class="card  ">
            <div class="card-body">
                <div class="d-flex d-lg-flex d-md-block align-items-center justify-content-between">
                    <div>
                        <h2 class="mb-1 font-weight-medium">{{ ($user->orders->where('status','completed')->count()) }}</h2>
                        <p class="text-muted font-weight-normal mb-0 w-100 text-truncate">Completed Orders</p>
                    </div>

                    <div class=" mt-md-3 mt-lg-0">
                        <span class="opacity-7 " style="border:2px solid #B54CE9; padding: 20px;border-radius: 15px;font-size: 38px;background: -webkit-linear-gradient(left, #fa5560 0%, #b14bf4 52%, #4d91ff 100%);background-clip: border-box;background-clip: border-box;-webkit-background-clip: text;-webkit-text-fill-color: transparent;"><i class="fas fa-star"></i></span>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


<div class="card" style="display:none;">
    <div class="card-body">
        <div class="row align-items-center">
        <div class="col-md-4">
      <h5 class="fw-bold">Refer & Earn</h5>
      <p>Refer your friends and get paid a commision for all their transactions.</p>
      </div><div class="col-md-2"></div>
      <div class="col-md-6">
      <div class="input-group mb-3 form-group">
        <span class="input-group-text btn btn-"><i class="fa fa-link"></i></span>
        <input class="form-control" type="text" placeholder="{{route('signup').'/?ref='.Auth::user()->username}}" value="{{route('signup').'/?ref='.Auth::user()->username}}">
        <button class="btn btn-primary input-group-text" onclick="copyFunction('{{route('signup').'/?ref='.Auth::user()->username}}')"><i class="fa-duotone fa-copy"></i> </button>
      </div></div>
    </div></div>
  </div>


<div class="row mt-3">
    <div class="col-lg-7 col-12 mb-5 mb-lg-0">
        <div class="card">
            <div class="card-header">
                <div class="dch-body">
                    <i class="icon fa fa-layer-group"></i>
                    <span class="ml-3">New Order</span>
                </div>
            </div>

            <div class="card-body" id="dc-body">
                @include('alerts.alerts')
                <form method="POST" action="{{route('user.orders.store')}}" class="sub-form">
                    @csrf
                    <div class="form-group mb-4 mt-3">
                        <label for="orderform-category" class="control-label">Category</label>
                        <select class="form-select optmain" required id="orderform-category" name="category">
                            <option value="0">Choose a Category</option>
                            @foreach ($category as $item)
                            <option value="{{$item->id}}" {{ old('category') == $item->id ? 'selected' : '' }} >{{$item->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- form-group end -->
                    <div class="form-group mb-4">
                        <label for="service" class="control-label">Service</label>
                        <select id="serviceSelect" class="form-select optmain form-control-lg" name="service" >
                            <option value="0" data-price="1">Choose a service</option>
                        </select>
                        {{-- <div class="dropdown">
                            <button class="form-control text-left" type="button" id="order-dd" data-toggle="dropdown" aria-haspopup="false" aria-expanded="false">
                                <span id="order-services"></span>
                                <i class="fa fa-angle-down float-right" aria-hidden="true"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="order-dd" id="orders-drop"></div>
                        </div> --}}

                        <div class="form-group" style="margin-top:10px;">
                        <small class="ml-2 help-block min-max">Per 1k: {{get_setting('currency')}}<span id="service_price"></span></small>
                        <small class="help-block min-max">Min: <span id="service_min"></span>- Max: <span id="service_max"></span></small>
                    </div>
                    </div>
                    <!-- form-group end -->
                    <div class="form-group">
                        <label>
                            Description
                        </label>
                        <div class="panel-body border-solid border-rounded" id="service_desc">

                        </div>
                    </div>
                    <!-- form-group end -->

                    <div id="serviceForm">

                    </div>
                    <div class="form-group">
                        <label for="quantity"> Quantity </label>
                        <input class="form-control" type="number" min="1" id="quantity" onkeydown="generateSummary()" value="{{old('quantity', 1)}}"  required name="quantity"/>
                    </div>
                    <div id="dripFeed">

                    </div>
                    <div class="form-group drip_feed"style="{{ old('runs') || old('interval')  || $errors->has('runs') || $errors->has('interval') ? '' : 'display: none;' }}">
                        <label>@lang('Drip-feed')</label>
                        <div class="custom-switch-btn w-50">
                            <input type="checkbox" name="drip_feed" class="custom-switch-checkbox dripfeed" id="status" value="0" {!!  old('runs') || old('interval') || $errors->has('runs') || $errors->has('interval') ? '' : 'checked="false"' !!}>
                            <label class="custom-switch-checkbox-label" for="status">
                                <span class="custom-switch-checkbox-inner"></span>
                                <span class="custom-switch-checkbox-switch"></span>
                            </label>
                        </div>
                    </div>
                    <div class="drip_feed_check" style="{{ old('runs') || old('interval')  || $errors->has('runs') || $errors->has('interval') ? '' : 'display: none;' }}">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group drip_feed">
                                    <label>@lang('Runs')</label>
                                    <input type="number" id="runs" name="runs" class="form-control" value="{{ old('runs', 1) }}">
                                    @if($errors->has('runs'))
                                        <div class="error text-danger">@lang($errors->first('runs'))</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group drip_feed">
                                    <label>@lang('Interval (in minutes)')</label>
                                    <select name="interval" class="form-control form-select">
                                        <option value="10" selected="">10</option>
                                        <option value="20">20</option>
                                        <option value="30">30</option>
                                        <option value="40">40</option>
                                        <option value="50">50</option>
                                        <option value="60">60</option>
                                    </select>
                                    @if($errors->has('interval'))
                                        <div class="error text-danger">@lang($errors->first('interval'))</div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group drip_feed">
                            <label>@lang('Total Quantity')</label>
                            <input type="text" class="form-control total_quantity" name="total_quantity" value="{{ (old('runs')) * (old('quantity')) }}" disabled>
                        </div>
                    </div>

                    <!-- form-group end -->

                    <div class="form-group mb-4">
                        <label>Amount</label>
                        <input class="form-control" type="text" id="amount_text" name="" readonly />
                    </div>
                    <!-- form-group end -->

                    <button class="btn btn-primary btn-block">Place Order</button>
                </form>
            </div>

        </div>
    </div>
    <div class="col-lg-5 col-12 mb-5 mb-lg-0">
        <div class="card">
            <div class="card-header">
                <div class="dch-body">
                    <i class="icon fa fa-bell"></i>
                    <span class="">Announcements</span>
                </div>
            </div>
            @php
                $news = App\Models\Update::orderByDesc('id')->limit(10)->get();
            @endphp
            <div class="card-body">
                <div class="dh-noti">
                    <ul class="app-news">
                        @foreach($news as $item)
                        <li>
                            <div class="group">
                                <div class="d-flex align-items-center">
                                    <div class="icon facebook">
                                        <i class="fa fa-star"></i>
                                    </div>
                                    <div class="title">
                                        {{$item->title}}
                                    </div>
                                </div>
                                <div class="text">
                                    {{$item->message}}
                                </div>
                                <div class="date"><i class="fa fa-calendar-alt"></i> {{news_date($item->created_at)}}</div>
                            </div>
                        </li>
                        <!-- <hr class="line my-0" /> -->
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

</div>


{{-- Latest Transactions --}}
<div class="card" style="display:none;">
    <div class="card-header d-flex justify-content-between">
        <h5>Latest Transaction</h5>
    </div>
   <div class="card-body table-responsive">
    <table class="table app-mtable" id="datatable">
        <thead class="white">
            <tr class="thead-tr">
                <th>#</th>
                <th class="nowrap">Type</th>
                <th class="nowrap">Service</th>
                <th class="nowrap">TRX Code</th>
                <th class="nowrap">Date</th>
                <th class="nowrap">Amount</th>
                <th class="nowrap">Status</th>
                <th >Message</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($trx as $key => $item)
            <tr class="app-block">
                <td class="app-col" data-title="#">{{$key + 1}}</td>
                <td class="app-col" data-title="Type">{!! get_trx_type($item->type) !!}</td>
                <td class="app-col" data-title="Service">
                    <span class="order-status os-processing">{{$item->service}}</span>
                </td>
                <td class="app-col" data-title="TRX Code">{{$item->code}}</td>
                <td class="app-col" data-title="Date">{{show_datetime($item->created_at)}}</td>
                <td class="app-col" data-title="Amount">{{format_amount($item->amount)}}</td>
                <td class="app-col" data-title="Status">
                    @if($item->status == 1)
                        <span class="badge bg-success">successful</span>
                    @elseif ($item->status == 2)
                        <span class="badge bg-warning">pending</span>
                    @elseif ($item->status == 3)
                        <span class="badge bg-danger">canceled</span>
                    @elseif ($item->status == 4)
                        <span class="badge bg-info">reversed</span>
                    @endif
                </td>
                <td class="app-col" data-title="Message">{{$item->message}}</td>
            </tr>

        @endforeach
        </tbody>
    </table>
   </div>



</div>
@endsection
@section('styles')
<style>
    .card{
        margin-bottom: 15px;
    }
    #service_desc{
        min-height: 6rem;
    }

</style>
@endsection

@push('scripts')
<script>
    $("#orderform-category").change(function(){
        var category = $('#orderform-category').find(":selected").val();
        $.ajax({
            type:'GET',
            url:'{{route('user.orders.get-services')}}',
            data:{ category},
            success: function(result){
                // console.log(result)
                $("#serviceSelect").html(result);
            },
        });
    });

    $("#serviceSelect").change(function(){
        var service = $('#serviceSelect').find(":selected").val();
        $.ajax({
            type:'GET',
            url:'{{route('user.orders.service-form')}}',
            data:{ service},
            success: function(result){
                // console.log(result)
                $("#serviceForm").html(result.html);
                $('#runs').val(1);
                generateSummary();
            },
        });
    });


    function generateSummary() {
        // Get the selected values from the first and second steps
        var category = $('#categorySelect option:selected').text();
        var service = $('#serviceSelect option:selected').text();
        var quantity = $('#quantity').val();
        var servicePrice1 = parseFloat($('#serviceSelect option:selected').data('price'));
        var servicePrice = parseFloat($('#serviceSelect option:selected').data('price')/1000);
        var serviceMin = $('#serviceSelect option:selected').data('min');
        var serviceMax = $('#serviceSelect option:selected').data('max');
        var serviceDesc = $('#serviceSelect option:selected').data('desc');
        serviceDesc = serviceDesc.replace(/\n/g, '<br>');
        var dripfeed = $('#serviceSelect option:selected').data('dripfeed');
        var run = parseFloat($('#runs').val());
        // show dripfeed form
        if (dripfeed == 0) {
            $('.drip_feed').css("display", "none");
            $('#status').val(0);
            //reset dripfeed form
            $('#runs').val(1);
        } else {
            $('.drip_feed').css("display", "block");
        }

        // Calculate the total amount
        var amount = servicePrice * quantity * run;
        $('#service_name').val(service);
        $('#service_price').text(servicePrice1);
        $('#service_min').text(serviceMin);
        $('#service_max').text(serviceMax);
        $('#service_desc').html(serviceDesc);
        $('#amount_text').val('{{get_setting('currency')}}' +amount.toFixed(3));
    }


    $(document).on('change click', '#status', function () {
        var re = $('#status').is(":checked");
        if (re == true) {
            $('.drip_feed_check').css("display", "none");
            $('#runs').val(1);
        } else {
            $('.drip_feed_check').css("display", "block");
        }
        generateSummary();
    });
    var total = 1;
    $(document).on('change keyup', '#quantity, #runs', function () {
        var quan = parseInt($('#quantity').val());
        var run = parseFloat($('#runs').val());
        var total = quan * run;
        $('.total_quantity').val(total);
        generateSummary();

    });
</script>

{{-- <script src="{{static_asset('js/order1.js')}}"></script> --}}
@endpush
