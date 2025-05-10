@extends('user3.layouts.master')
@section('title', "Buy Data")
@section('page-title')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0">@yield('title')</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Bills Payment</a></li>
                    <li class="breadcrumb-item active">@yield('title')</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->
@endsection
@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="my-2 row justify-content-between mx-auto px-2">
            <div class="left">
                <a href="#" class="btn btn-light btn-sm" style="background: #fa7f41;border: 0;color: #fff;
" onclick="window.history.back()"> <i class="fa fa-arrow-left"></i> </a>
            </div>
            <div>
                <a href="#" class="btn btn-light btn-sm" onclick="window.location.reload()"> <i class="fa-solid fa-arrow-rotate-right"></i> </a>
                            </div>
        </div>
        <div class="card" style="margin-top:1rem;">
            <div class="card-header"><div class="dch-body">
                    <i class="icon fa fa-wifi mr-3"></i> <span class="">Buy Mobile Data</span>
                </div></div>
            <div class="card-body">
                <div class="preview-block">
                    <!--<span class="preview-title-lg overline-title">Buy Internet Data</span>-->
                    <form action="{{route('user.bills.data')}}" method="post" class="form-validate is-alter" id="buyData">
                        @csrf
                    <div class="rose">
                        <div class="form-group">
                            <label class="form-label" for="network">Network</label>
                            <div class="form-control-wrap">
                                <select class="form-control" name="network" id="networkSelector" data-placeholder="Select Network" required>
                                    <option > Select network </option>
                                    @foreach ($networks as $item)
                                        <option value="{{$item->id}}" discount="{{$item->discount}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group" id="div_data_type_selector" hidden>
                            <label class="form-label" for="data-type">Data Type</label>
                            <div class="form-control-wrap">
                                <select class="form-control" name="type" id="data-type-selector" data-placeholder="Select Data Type" required>
                                    <option value="" disabled> Select Type</option>
                                    <option value="ALL" >ALL PLANS</option>
                                    <option value="GIFTING">GIFTING DATA</option>
                                    <option value="SME">SME DATA</option>
                                    {{-- <option value="SME2">SME2 DATA</option> --}}
                                    <option value="CG">CORPORATE GIFTING </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group " id="div_data_plan_selector">
                            <label class="form-label" for="data-plan">Plan</label>
                            <div class="form-control-wrap">
                                <select class="form-control " name="plan" id="data-plan-selector" data-placeholder="Select Plan" required>
                                    <option value="" disabled > Select plan </option>
                                </select>
                            </div>
                            <p style="font-size: 10px;">All data plans have 30days validity.</p>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="phoneNumber">Phone Number</label>
                            <div class="form-control-wrap">
                                <input type="number" maxlength="11" onkeyup="NumberValidator()" placeholder="Enter Phone Number" required name="phone" class="form-control" id="phoneNumber" >
                                <span id="phone-validator"style="font-size: 10px;"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="amount">Amount</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" name="amount" id="data-amount" placeholder="Amount" readonly required>
                            </div>
                        </div>
                        <div class="form-group" hidden>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" value="1" name="bypass" id="bypass">
                                <label class="custom-control-label" for="bypass">Bypass Validator</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary w-100"><span>Proceed</span></button>
                        </div>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- .card-preview -->
    </div>
</div>
@endsection

@push('scripts')
<script src="{{static_asset('js/phone.js')}}"></script>
<script>
    $("#networkSelector").change(function(){
        var network =$("#networkSelector option:selected").val();
        $('#data-type-selector option[value="CG"]').css('display', 'block');
        $('#data-type-selector option[value="CG"]').attr('disabled', false);
        $('#data-type-selector option[value="SME"]').css('display', 'block');
        $('#data-type-selector option[value="SME"]').attr('disabled',false);
        $('#data-type-selector option[value="SME2"]').css('display', 'block');
        $('#data-type-selector option[value="SME2"]').attr('disabled',false);
        $('#data-type-selector option[value="GIFTING"]').css('display', 'block');
        $('#data-type-selector option[value="GIFTING"]').attr('disabled', false);

        $("#div_data_plan_selector").css("display", "block");
        $("#div_data_type_selector").css("display", "block");

    });
    $("#data-type-selector").change(function(){
        var network = $('#network-selector').find(":selected").text();
        var data_type = $('#data-type-selector').find(":selected").val();
        $('#data-plan-selector option[data-type="CG"]').css('display', 'none');
        $('#data-plan-selector option[data-type="CG"]').attr('disabled', true);
        $('#data-plan-selector option[data-type="SME"]').css('display', 'none');
        $('#data-plan-selector option[data-type="SME"]').attr('disabled',true);
        $('#data-plan-selector option[data-type="GIFTING"]').css('display', 'none');
        $('#data-plan-selector option[data-type="GIFTING"]').attr('disabled', true);
        $('#data-plan-selector option[data-type="CG2"]').css('display', 'none');
        $('#data-plan-selector option[data-type="CG2"]').attr('disabled',true);
        $('#data-plan-selector option[data-type="SME2"]').css('display', 'none');
        $('#data-plan-selector option[data-type="SME2"]').attr('disabled',true);

        if(data_type == 'GIFTING'){
            $('#data-plan-selector option[data-type="GIFTING"]').css('display', 'block');
             $('#data-plan-selector option[data-type="GIFTING"]').attr('disabled', false);
            $("#div_data_plan_selector").css("display", "block");
        }else if(data_type == 'SME'){
            $("#div_data_plan_selector").css("display", "block");
            $('#data-plan-selector option[data-type="SME"]').css('display', 'block');
            $('#data-plan-selector option[data-type="SME"]').attr('disabled',false);
        }else if(data_type == 'CG'){
            $("#div_data_plan_selector").css("display", "block");
            $('#data-plan-selector option[data-type="CG"]').css('display', 'block');
            $('#data-plan-selector option[data-type="CG"]').attr('disabled', false);
        }else if(data_type == 'SME2'){
            $("#div_data_plan_selector").css("display", "block");
            $('#data-plan-selector option[data-type="SME2"]').css('display', 'block');
            $('#data-plan-selector option[data-type="SME2"]').attr('disabled',false);
        }else if(data_type == 'ALL'){
            $("#div_data_plan_selector").css("display", "block");
            $('#data-plan-selector option').css('display', 'block');
            $('#data-plan-selector option').attr('disabled',false);
        }
    });
    $("#networkSelector").change(function(){
        var network = $('#networkSelector').find(":selected").val();
        $.ajax({
            type:'GET',
            url:'{{route('user.bills.data.plans')}}',
            data:{ network},
            success: function(result){
                $("#data-plan-selector").html(result);
                console.log(result)
            },
        });
    });
    $("#data-plan-selector").change(function(){
        var dataid = $("#data-plan-selector").find(":selected").val();
        var amount = $("#data-plan-selector").find(":selected").attr('data-price');
        $("#data-amount").val("₦"+amount);
    });
    // Nuy Data
    $("#buyData").submit(function(event){
        event.preventDefault()
        var form = $(this);

        $.ajax({
            type: 'POST',
            url:"{{route('user.bills.data')}}",
            beforeSend: function(){
                JsLoadingOverlay.show();
            },
            dataType: 'json',
            data:form.serialize(),
            success: function(result){
                console.log(result)
                 JsLoadingOverlay.hide();
                if(result.status == 'success'){
                    // alert('success')
                    Snackbar.show({
                        backgroundColor: '#38c172',
                        pos: 'top-right',
                        text: result.message,
                    });
                    // swal("Transaction successful!", result.message, "success");
                    swal("Transaction Successful!", result.message, "success",{buttons: ["Receipt", "OK"]})
                    .then((willDelete) => {
                        if (willDelete) {
                        } else {
                            // open link
                            window.location = result.url;
                        }
                    });
                }else if(result.status == 'error'){
                    Snackbar.show({
                        backgroundColor: '#e3342f',
                        pos: 'top-right',
                        text: result.message,
                    });
                    swal("Error!", result.message, "warning");
                }
            },
            error: function(result){
                // console.log(result);
                 JsLoadingOverlay.hide();
                if(result.status === 422){
                    var errors = $.parseJSON(result.responseText);
                    // console.log(errors)
                    Snackbar.show({
                        backgroundColor: '#e3342f',
                        pos: 'top-right',
                        text: errors.message,
                    });
                }
                var errors = $.parseJSON(result.responseText);
                // console.log(errors)
                Snackbar.show({
                    backgroundColor: '#e3342f',
                    pos: 'top-right',
                    text: errors.message,
                });
            }
        });
    });

   </script>

@endpush
@section('styles')
<style>
     #div_data_plan_selector{
        display:none;
    }
</style>
@endsection
