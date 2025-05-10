@extends('user3.layouts.master')
@section('title', "Cable Subscription")
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
            <h5 class="card-header">Cable TV Subscription</h5>
            <div class="card-body">
                <form action="#" method="post" id="cableForm" class="form-validate is-alter">
                    @csrf
                    <div class="form-group mb-2">
                        <label class="form-label" for="cable">Cable TV</label>
                        <div class="form-control-wrap">
                            <select class="form-select form-control" name="cable" id="cableSelector" data-placeholder="Select a Decoder" required>
                                <option value="" label="Select A Decoder"> Select Type </option>
                                @foreach ($cables as $item)
                                    <option value="{{$item->id}}" discount="{{$item->discount}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group mb-2" id="div_planSelector">
                        <label class="form-label" for="cab-plan">CableTV Plan</label>
                        <div class="form-control-wrap">

                            <select class="form-control js-select" name="cable_plan" id="cable-plan" data-placeholder=" Select Plan " required>
                                <option value="" > Select Plann </option>

                            </select>
                        </div>
                    </div>

                    <div class="form-group mb-2">
                        <label class="form-label" for="iucnumber">IUC Number</label>
                        <div class="form-control-wrap">
                            <input type="number" required name="iuc" class="form-control" id="iucnumber" placeholder="Decoder Number">
                        </div>
                    </div>

                    <div class="form-group" id="div_account_name">
                        <div class="form-group col-md-5">
                            <label class="form-label" for="account_name">Account Name</label>
                            <input type="text" class="form-control" id="account_name" disabled>
                        </div>
                        <div class="form-group col-md-5">
                            <label class="form-label" for="current_bouquet">Current Plan</label>
                            <input type="text" class="form-control" id="current_bouquet" disabled>
                        </div>
                    </div>

                    <div class="form-group mb-2">
                        <label class="form-label" for="amount">Amount</label>
                        <div class="form-control-wrap mb-2">
                            <input type="text" class="form-control" name="amount" required  id="amount" placeholder="Amount" readonly>
                        </div>
                        <span id="discount"></span>
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-radio">
                            <input type="checkbox" class="custom-control-input" value="1" name="bypass" id="validator">
                            <label class="custom-control-label" for="validator">Bypass IUC Validator</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="button" id="validate" class="btn btn-primary w-100"><span>Validate</span></button>
                        <button type="submit" style="display:none" id="sbutton" class="btn btn-primary w-100"><span>Proceed</span></button>
                    </div>
                </form>
            </div>
        </div><!-- .card-preview -->
    </div>

</div>
@endsection

@push('scripts')
<script>
    $("#cableSelector").change(function(){
        var cable_name = $('#cableSelector').find(":selected").val();
        $.ajax({
        type:'GET',
        url:"{{route('user.bills.cable.plans')}}",
        data:{
            "cable" : cable_name,
        },
        success: function(result){
            // console.log(result)
            $("#div_planSelector").css('display','block');
            $("#cable-plan").html(result);

        },
        });
    });

    $("#cable-plan").change(function(){
        var amount = $("#cable-plan").find(":selected").attr('data-price');
        var cableid = $("#cable-plan").find(":selected").val();
        $.ajax({
            type:'GET',
            url:"{{route('user.bills.cable.discount')}}",
            dataType: 'json',
            data:{"cable" : cableid},
            success: function(result){
                console.log(result)
                if(result.status == 'success'){
                    $("#discount").html(result.message);
                    $("#amount").val("₦"+amount);
                }else if(result.status == 'fail'){
                    $("#discount").html('unable to caculate discount');
                    $("#amount").val("₦"+amount);
                }
            },
        });
    });
    $('#validator').click(function(){
       bypass = $('#validator').is(":checked");
       if(bypass == true){
           $("#validate").css('display','none');
           $("#sbutton").css('display','block');
       }else{
          $("#validate").css('display','block');
           $("#sbutton").css('display','none');
       }
    });
    $("#validate").on('click',function(){
        var cable = $("#cableSelector").find(":selected").val();
        var iuc = $("#iucnumber").val();
        // alert('Heplpp')
        if(iuc == '' || cable == ''){
            Snackbar.show({
                backgroundColor: '#e3342f',
                pos: 'top-right',
                text: 'All field Required',
            });
        }else{
            $.ajax({
                type: 'POST',
                url:"{{route('user.bills.cable.validation')}}",
                beforeSend: function(){
                    JsLoadingOverlay.show();
                },
                dataType: 'json',
                data:{
                    "cable" : cable,
                    "iuc" : iuc,
                    _token:"{{ csrf_token() }}"
                },
                success: function(result){
                     JsLoadingOverlay.hide();
                    if(result.status == 'success'){
                        $("#account_name").val(result.name);
                        $("#current_bouquet").val(result.current_plan);
                        $("#div_account_name").css('display','flex');
                        $("#validate").css('display','none');
                        $("#sbutton").css('display','block');
                    }else if(result.status == 'fail'){
                        $("#div_account_name").css('display','none');
                        Snackbar.show({
                            backgroundColor: '#e3342f',
                            pos: 'top-right',
                            text: result.message,
                        });
                        $("#validate").css('display','block');
                        $("#sbutton").css('display','none');
                        swal("Error!", result.message, "warning");
                    }
                },
                error: function(result){
                    console.log(result);
                     JsLoadingOverlay.hide();
                    if(result.status === 422){
                        var errors = $.parseJSON(result.responseText);
                        console.log(errors)
                        Snackbar.show({
                            backgroundColor: '#e3342f',
                            pos: 'top-right',
                            text: errors.message,
                        });
                        swal("Error!", result.message, "warning");
                    }
                    var errors = $.parseJSON(result.responseText);
                    console.log(errors)
                    Snackbar.show({
                        backgroundColor: '#e3342f',
                        pos: 'top-right',
                        text: errors.message,
                    });
                    swal("Error!", errors.message, "warning");
                }
            });
        }
    });

    $("#cableForm").submit(function(event){
        event.preventDefault()
        var form = $(this);

        $.ajax({
            type: 'POST',
            url:"{{route('user.bills.cable.buy')}}",
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
                //console.log(result);
                 JsLoadingOverlay.hide();
                if(result.status === 422){
                    var errors = $.parseJSON(result.responseText);
                    //console.log(errors)
                    Snackbar.show({
                        backgroundColor: '#e3342f',
                        pos: 'top-right',
                        text: errors.message,
                    });
                }
                var errors = $.parseJSON(result.responseText);
                //console.log(errors)
                Snackbar.show({
                    backgroundColor: '#e3342f',
                    pos: 'top-right',
                    text: errors.message,
                });
            }
        });
    });
</script>
<script>

</script>
@endpush
@section('styles')
<style>
    #div_planSelector{
        display: none;
    }
    #div_account_name{
        display: none;
    }
</style>
@endsection
