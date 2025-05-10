@extends('admin.layouts.master')
@section('title', 'Add Service')

@section('content')
<div class="d-card">
    @include('alerts.alert')
    <div class="d-card-body">
        <form action="{{route('admin.service.store')}}" method="POST" class="form">
            @csrf
            <h5 class="fw-bold text-info mb-2 mb-md-3"><span>@lang('Service Details')</span></h5>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group ">
                        <label class="form-label">@lang('Service Name')</label>
                        <input type="text" name="name" value="{{ old('name') }}" id="name"  placeholder="@lang('Service Name')" class="form-control">
                        @if($errors->has('name'))
                            <div class="error text-danger">@lang($errors->first('name')) </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">@lang('Select Category')</label>
                        <select class="form-control form-select" id="category_id" name="category_id">
                            <option disabled value="" selected hidden>@lang('Select category')</option>
                            @foreach($categories as $categorie)
                                <option value="{{ $categorie->id  }}">@lang($categorie->name)</option>
                            @endforeach
                        </select>
                        @if($errors->has('category_id'))
                            <div class="error text-danger mt-2">@lang($errors->first('category_id')) </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="divider"></div>

            <div class="form-group ">
                <div class="switch-field d-flex">
                    <div class="form-check p-0">
                        <input class="form-check-input" type="radio" name="manual_api" id="less" value="1" {{ old('manual_api', 0) == '0' ? 'checked' : '' }}>
                        <label class="form-check-label" for="less">
                            @lang('Manual')
                        </label>
                    </div>
                    <div class="form-check p-0 ml-2">
                        <input class="form-check-input" type="radio" name="manual_api" id="more" value="0" {{ old('manual_api') == '0' ? 'checked' : '' }}>
                        <label class="form-check-label" for="more">
                            @lang('Api')
                        </label>
                    </div>
                </div>
            </div>

            <div class="row moreField {{ old('manual_api', 1) == 1 ? 'd-none' : ''  }}">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label " for="apiprovider">@lang('API Provider Name')</label>
                        <select class="form-control" name="api_provider_id" id="providerId">
                            <option value="0" hidden>@lang('Select API Provider name')</option>
                            @foreach($apiProviders as $apiProvider)
                                <option value="{{ $apiProvider->id }}" {{ old('api_provider_id') == $apiProvider->id ? 'selected' : '' }}>{{ $apiProvider->name }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('api_provider_id'))
                            <div class="error text-danger">@lang($errors->first('api_provider_id')) </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">@lang('API Service')</label>
                        <select id="serviceSelect" class="form-control form-control" name="api_service_id" >
                            <option value="0" data-price="1">Choose a service</option>
                        </select>
                        @if($errors->has('api_service_id'))
                            <div class="error text-danger">@lang($errors->first('api_service_id')) </div>
                        @endif
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">@lang('Original Rate') </label>
                        <input type="text" class="form-control square" id="apiPrice" name="api_price" readonly placeholder="0.00" value="{{ old('api_price') }}">
                        @if($errors->has('price'))
                            <div class="error text-danger">@lang($errors->first('api_price')) </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="divider"></div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">@lang('Minimum Quantity')</label>
                        <input type="number" class="form-control square" id="min" name="min" value="{{ old('min',500) }}">
                        @if($errors->has('min'))
                            <div class="error text-danger">@lang($errors->first('min')) </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">@lang('Price per 1000')</label>
                        <input type="number" class="form-control square" id="price" name="price" placeholder="0.00" value="{{ old('price') }}">
                        @if($errors->has('price'))
                            <div class="error text-danger">@lang($errors->first('price')) </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="form-label">@lang('Service Type')</label>
                        <select name="s_type" class="form-control" id="stype" required >
                            <option value="normal" selected>Normal</option>
                            <option value="special">Special</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">@lang('Maximum Quantity')</label>
                        <input type="number" class="form-control square" id="max" name="max" value="{{ old('max',5000) }}">
                        @if($errors->has('max'))
                            <div class="error text-danger">@lang($errors->first('max')) </div>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group ">
                                <label class="d-block form-label">@lang('Status')</label>
                                <select name="status" class="form-control" id="status" required >
                                    <option value="1">Active</option>
                                    <option value="2">Disabled</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group ">
                                <label class="d-block form-label">@lang('Drip feed')</label>
                                <select name="dripfeed" class="form-control" id="dripfeed" required >
                                    <option value="1">Active</option>
                                    <option value="0" selected>Deactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row d-none">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">@lang('Select Refill')</label>
                        <select class="form-control" name="refill" id="refill">
                            <option disabled value="" hidden>@lang('Select Refill')</option>
                            <option value="1" {{(old('refill') == '1') ? 'selected':''}} >@lang('Manual')</option>
                            <option value="2" {{(old('refill') == '2') ? 'selected':''}}  selected class="automatic">@lang('Automatic')</option>
                            <option value="3" {{(old('refill') == '3') ? 'selected':''}} selected>@lang('Off')</option>
                        </select>
                        @if($errors->has('refill'))
                            <div class="error text-danger">@lang($errors->first('refill')) </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="serviceType" class="form-label">Service Type</label>
                        <select name="type" class="form-control">
                            <option value="default">Default</option>
                            <option value="subscriptions">Subscriptions</option>
                            <option value="custom_comments">Custom comments</option>
                            <option value="custom_comments_package">Custom comments package</option>
                            <option value="mentions_with_hashtags">Mentions with hashtags</option>
                            <option value="mentions_custom_list">Mentions custom list</option>
                            <option value="mentions_hashtag">Mentions hashtag</option>
                            <option value="mentions_user_followers">Mentions user followers</option>
                            <option value="mentions_media_likers">Mentions media likers</option>
                            <option value="package">Package</option>
                            <option value="comment_likes">Comment likes</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group mt-4">
                <label class="form-label " for="fieldone">@lang('Description')</label>
                <textarea class="form-control" rows="4" id="service_desc" placeholder="@lang('Description') " name="description"></textarea>
                @if($errors->has('description'))
                    <div class="error text-danger">@lang($errors->first('description')) </div>
                @endif
            </div>
            <div class="mt-md-3  text-center text-md-left">
                <button type="submit" class="btn  btn-primary btn-block mt-3">
                    <span> @lang('Create Service')</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('breadcrumb')
<div class="d-card dc-dash">
    <div class="row">
        <div class="col-lg-7 col-md-9 col-12">
            <div class="py-3 px-5">
                <div class="dch-title">
                   @yield('title')
                </div>
                <div class="dch-text">
                    Add New Service.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@push('scripts')
<script>
    "use strict";

    var $serviceType = '';

    $serviceType = $('input[name=manual_api]:checked').val();

    checkType($serviceType);

    $(document).on('click', '#more', function () {
        $(".moreField").removeClass('d-none');

    });
    $(document).on('click', '#less', function () {
        $(".moreField").addClass('d-none');
    });

    $(document).on('click',"input[name=manual_api]:checked", function () {
        $serviceType = $(this).val();
        checkType($serviceType);
    });

    function checkType(serviceType){
        if(serviceType == 0){
            $('select[name=refill]').val('')
            $(".automatic").removeClass('d-none');
            return 0;
        }else{
            $('select[name=refill]').val('')
            $(".automatic").addClass('d-none');
            return 0;
        }

    }

    $(document).ready(function () {
        $('#category_id').select2({
            selectOnClose: true
        });
    });
</script>
<script>
    $("#providerId").change(function(){
        var provider = $('#providerId').find(":selected").val();
        console.log(provider);
        $.ajax({
            type:'GET',
            url:'{{route('admin.service.get-apiservice')}}',
            data:{ provider},
            success: function(result){
                // console.log(result)
                $("#serviceSelect").html(result);
            },
        });
    });

    $("#serviceSelect").change(function(){
        var service = $('#serviceSelect').find(":selected").val();
        generateSummary();
    });

    function generateSummary() {
        var service = $('#serviceSelect').find(":selected")
        console.log(service);
        // Get the selected values from the first and second steps
        //
        $('#name').val(service.text());
        $('#apiPrice').val(service.data('rate'));
        $('#min').val(service.data('min'));
        $('#max').val(service.data('max'));
        $('#service_desc').val(service.data('desc'));
    }
</script>
@endpush
