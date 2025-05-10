@extends('user.layouts.master')
@section('title', 'Place Order')

@section('content')
<div class="row">
    <div class="col-lg-7 col-12 mb-5 mb-lg-0">
        <div class="d-card">
            <div class="d-card-head">
                <div class="dch-body">
                    <i class="icon fa fa-layer-group me-3"></i>
                    <span class="ml-3">Place Order</span>
                </div>
            </div>

            <div class="d-card-body" id="dc-body">
                @include('alerts.alert')
                <form method="POST" action="{{route('user.orders.store')}}" class="sub-form">
                    @csrf
                    <div class="form-group mb-4 mt-3">
                        <label for="orderform-category" class="control-label">Category</label>

                        <select class="form-control optmain" required id="orderform-category" name="category" style="display:none;">
                            <option value="0">Choose a Category</option>
                            @foreach ($category as $item)
                            <option value="{{$item->id}}" {{ old('category') == $item->id ? 'selected' : '' }} > {{$item->name}}</option>
                            @endforeach
                        </select>


                        <div class="dropdown">

                            <button class="form-control text-left" type="button" id="dropdownMenu3" data-toggle="dropdown" aria-haspopup="false" aria-expanded="false">

                                <span id="order-category"></span>
                            </button>

                            <div class="dropdown-menu" aria-labelledby="order-dd" id="category-drop"></div>

                        </div>


                    </div>
                    <!-- form-group end -->
                    <div class="form-group mb-4">
                        <label for="service" class="control-label">Service</label>
                        <select id="serviceSelect" class="form-control optmain form-control-lg" name="service" >
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
                        <small class="ml-2 help-block min-max hidden">Per 1k: {{get_setting('currency')}}<span id="service_price"></span></small>
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
        <div class="d-card">
            <div class="d-card-head">
                <div class="dch-body">
                    <i class="icon fa fa-bell me-3"></i>
                    <span class="ml-3">Announcements</span>
                </div>
            </div>
            @php
                $news = App\Models\Update::orderByDesc('id')->limit(10)->get();
            @endphp
            <div class="d-card-body">
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
        $('#amount_text').val("{{get_system_currency()->symbol}}" +amount.toFixed(3));
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

<script src="{{static_asset('js/order1.js')}}"></script>
@endpush
@section('breadcrumb')
<div class="d-card dc-dash">
    <div class="row">
        <div class="col-lg-7 col-md-9 col-12">
            <div class="py-3 px-5">
                <div class="dch-title">
                   @yield('title')
                </div>
                <div class="dch-text">
                    You can quickly place new order below. </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    #service_desc{
        min-height: 6rem;
    }
    .help-block.min-max {
    margin-left: 5px;
    border: 1px solid #ff401a;
    border-radius: 10px;
    font-size: 8px;
    padding: 2px 8px;
    color: #ff401a;
    font-weight: 600;
}

    button, .form-group .form-control {
    position: relative;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    height: 40px;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    border-radius: 30px;
    padding: 0 15px;
    background: #fff;
    border: none;
    color: #000000;
    font-size: 12px;
    overflow: hidden !important;
    border: .5px solid #0c152525;
}



</style>
@endsection
