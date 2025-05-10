@extends('admin.layouts.master')
@section('title', 'Edit Service')

@section('content')
<div class="d-card">
    @include('alerts.alert')
    <div class="d-card-body">
        <form action="{{ route('admin.service.update', ['id' => $service->id]) }}" method="POST" class="form">
            @csrf
            <h5 class="fw-bold text-info mb-2 mb-md-3"><span>@lang('Service Details')</span></h5>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">@lang('Service Name')</label>
                        <input type="text" name="name" value="{{ old('name', $service->name) }}" placeholder="@lang('Service Name')" class="form-control">
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
                                <option value="{{ $categorie->id }}" {{ old('category_id', $service->category_id) == $categorie->id ? 'selected' : '' }}>@lang($categorie->name)</option>
                            @endforeach
                        </select>
                        @if($errors->has('category_id'))
                            <div class="error text-danger mt-2">@lang($errors->first('category_id')) </div>
                        @endif
                    </div>
                </div>
            </div>
            <!-- ... (Previous form code) ... -->

            <div class="divider"></div>

            <div class="form-group">
                <div class="switch-field d-flex">
                    <div class="form-check p-0">
                        <input class="form-check-input" type="radio" name="manual_api" id="less" value="1" {{ old('manual_api', $service->manual_api) == '1' ? 'checked' : '' }}>
                        <label class="form-check-label" for="less">
                            @lang('Manual')
                        </label>
                    </div>
                    <div class="form-check p-0 ml-2">
                        <input class="form-check-input" type="radio" name="manual_api" id="more" value="0" {{ old('manual_api', $service->manual_api) == '0' ? 'checked' : '' }}>
                        <label class="form-check-label" for="more">
                            @lang('Api')
                        </label>
                    </div>
                </div>
            </div>

            <div class="row moreField {{ old('manual_api', $service->manual_api) == 1 ? 'd-none' : '' }}">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label " for="apiprovider">@lang('API Provider Name')</label>
                        <select class="form-control" id="providerId" name="api_provider_id">
                            <option value="0" hidden>@lang('Select API Provider name')</option>
                            @foreach($apiProviders as $apiProvider)
                                <option value="{{ $apiProvider->id }}" {{ old('api_provider_id', $service->api_provider_id) == $apiProvider->id ? 'selected' : '' }}>{{ $apiProvider->name }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('api_provider_id'))
                            <div class="error text-danger">@lang($errors->first('api_provider_id')) </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">@lang('API Service ID')</label>
                        <select id="serviceSelect" class="form-control form-control" name="api_service_id" >
                            <option value="0" data-price="1">Choose a service</option>
                        </select>

                        @if($errors->has('api_service_id'))
                            <div class="error text-danger">@lang($errors->first('api_service_id')) </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-sm-6 orm-group ">
                        <label class="form-label">@lang('API Rate ')</label>
                        <input type="text" class="form-control square" id="apiPrice" name="api_price" placeholder="0.00" value="{{ old('api_price', $service->api_price) }}">
                        @if($errors->has('api_price'))
                            <div class="error text-danger">@lang($errors->first('api_price')) </div>
                        @endif
                    </div>
                    <div class="col-sm-6 form-group">
                        <label class="form-label">@lang('Service Type')</label>
                        <select name="s_type" class="form-control" id="stype" required >
                            <option value="normal" {{ old('s_type', $service->s_type) == 'normal' ? 'selected' : '' }} >Normal</option>
                            <option value="special" {{ old('s_type', $service->s_type) == 'special' ? 'selected' : '' }}>Special</option>
                        </select>
                    </div>
                </div>

            </div>
            <div class="divider"></div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">@lang('Minimum Quantity')</label>
                        <input type="number" class="form-control square" id="min" name="min" value="{{ old('min', $service->min) }}">
                        @if($errors->has('min'))
                            <div class="error text-danger">@lang($errors->first('min')) </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="form-label">@lang('Rate per 1000')</label>
                        <input type="text" class="form-control square" name="price" id="price" placeholder="0.00" value="{{ old('price', $service->price) }}">
                        @if($errors->has('price'))
                            <div class="error text-danger">@lang($errors->first('price')) </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">@lang('Maximum Quantity')</label>
                        <input type="number" class="form-control square" name="max" id="max" value="{{ old('max', $service->max) }}">
                        @if($errors->has('max'))
                            <div class="error text-danger">@lang($errors->first('max')) </div>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="d-block form-label">@lang('Status')</label>
                                <select name="status" class="form-control" id="status" required>
                                    <option value="1" {{ old('status', $service->status) == '1' ? 'selected' : '' }}>Active</option>
                                    <option value="2" {{ old('status', $service->status) == '2' ? 'selected' : '' }}>Disabled</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="d-block form-label">@lang('Drip feed')</label>
                                <select name="dripfeed" class="form-control" id="dripfeed" required>
                                    <option value="1" {{ old('dripfeed', $service->dripfeed) == '1' ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ old('dripfeed', $service->dripfeed) == '0' ? 'selected' : '' }}>Deactive</option>
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
                            <option value="1" {{ old('refill', $service->refill) == '1' ? 'selected' : '' }}>@lang('Manual')</option>
                            <option value="2" {{ old('refill', $service->refill) == '2' ? 'selected' : '' }} class="automatic">@lang('Automatic')</option>
                            <option value="3" {{ old('refill', $service->refill) == '3' ? 'selected' : '' }}>@lang('Off')</option>
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
                            <option value="default" {{ old('type', $service->type) == 'default' ? 'selected' : '' }}>Default</option>
                            <option value="subscriptions" {{ old('type', $service->type) == 'subscriptions' ? 'selected' : '' }}>Subscriptions</option>
                            <option value="custom_comments" {{ old('type', $service->type) == 'custom_comments' ? 'selected' : '' }}>Custom comments</option>
                            <option value="custom_comments_package" {{ old('type', $service->type) == 'custom_comments_package' ? 'selected' : '' }}>Custom comments package</option>
                            <option value="mentions_with_hashtags" {{ old('type', $service->type) == 'mentions_with_hashtags' ? 'selected' : '' }}>Mentions with hashtags</option>
                            <option value="mentions_custom_list" {{ old('type', $service->type) == 'mentions_custom_list' ? 'selected' : '' }}>Mentions custom list</option>
                            <option value="mentions_hashtag" {{ old('type', $service->type) == 'mentions_hashtag' ? 'selected' : '' }}>Mentions hashtag</option>
                            <option value="mentions_user_followers" {{ old('type', $service->type) == 'mentions_user_followers' ? 'selected' : '' }}>Mentions user followers</option>
                            <option value="mentions_media_likers" {{ old('type', $service->type) == 'mentions_media_likers' ? 'selected' : '' }}>Mentions media likers</option>
                            <option value="package" {{ old('type', $service->type) == 'package' ? 'selected' : '' }}>Package</option>
                            <option value="comment_likes" {{ old('type', $service->type) == 'comment_likes' ? 'selected' : '' }}>Comment likes</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group mt-4">
                <label class="form-label " for="fieldone">@lang('Description')</label>
                <textarea class="form-control" rows="4" height="250px" placeholder="@lang('Description')" name="description">{{ old('description', $service->description) }}</textarea>
                @if($errors->has('description'))
                    <div class="error text-danger">@lang($errors->first('description')) </div>
                @endif
            </div>
            <div class="mt-md-3  text-center text-md-left">
                <button type="submit" class="btn  btn-primary btn-block mt-3">
                    <span> @lang('Update Service')</span>
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
                    Edit Service.
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
            // $('select[name=refill]').val('')
            $(".automatic").removeClass('d-none');
            return 0;
        }else{
            // $('select[name=refill]').val('')
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
    $(document).ready(function(){
        var provider = $('#providerId').find(":selected").val();
        var service_id = '{{$service->api_service_id}}';
        console.log(provider);
        $.ajax({
            type:'GET',
            url:'{{route('admin.service.get-apiservice')}}',
            data:{ provider, service_id},
            success: function(result){
                console.log(result)
                $("#serviceSelect").html(result);
            },
        });
    });
    $("#providerId").change(function(){
        var provider = $('#providerId').find(":selected").val();
        var service_id = '{{$service->api_service_id}}';
        console.log(service_id);
        $.ajax({
            type:'GET',
            url:'{{route('admin.service.get-apiservice')}}',
            data:{ provider, service_id},
            success: function(result){
                console.log(result)
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
        $('#apiPrice').val(service.data('rate'));
        $('#min').val(service.data('min'));
        $('#max').val(service.data('max'));
        $('#service_desc').val(service.data('desc'));
    }
</script>
@endpush
