@extends('user.layouts.master')
@section('title', "Betsite Payment")

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
        <div class="d-card" style="margin-top:1rem;">
            <div class="d-card-head"><div class="dch-body">
                    <i class="icon fa fa-soccer-ball mr-3"></i> <span class="">Fund Betting</span>
                </div></div>
            <div class="d-card-body">
                <form action="{{route('user.bills.bet.buy')}}" method="post" id="betForm" class="form-validate is-alter">
                    @csrf
                    <div class="rose">
                        <div class="form-group ">
                        <label class="form-label" for="betsiteSelector">Bet Provoder</label>
                        <select class="form-control form-select" name="betsite" id="betsiteSelector" data-placeholder="Select Provider" required>
                            <option label="Select Type"> Select </option>
                            @foreach ($plans as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group ">
                        <label class="form-label" for="accountId">Account ID</label>
                        <div class="form-control-wrap">
                            <input type="text" required name="number" class="form-control" id="accountId" >
                        </div>
                    </div>
                    <div class="form-group " id="div_account_name">
                        <label class="form-label" for="account_name">Account Name</label>
                        <input type="text"   class="form-control" name="customer_name" id="account_name" readonly>
                    </div>
                    <div class="form-group ">
                        <label class="form-label" for="amount">Amount</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" name="amount" id="amount" placeholder="Amount">
                        </div>
                    </div>
                    <div class="form-group" >
                        <div class="custom-control custom-radio">
                            <input type="checkbox" class="custom-control-input" name="bypass" id="bypass">
                            <label class="custom-control-label" for="bypass">Bypass Validator</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary w-100 mb-2" id="sbutton" style="display: none"><span>Proceed</span></button>
                        <button type="button" class="btn btn-primary w-100 mb-2" id="validate"><span>Validate</span></button>
                    </div></div>
                </form>
            </div>
        </div><!-- .card-preview -->
    </div>

</div>
@endsection

@push('scripts')
<script>
    $('#bypass').click(function(){
       bypass = $('#bypass').is(":checked");
       if(bypass == true){
           $("#validate").css('display','none');
           $("#sbutton").css('display','block');
       }else{
          $("#validate").css('display','block');
           $("#sbutton").css('display','none');
       }
    });
    $("#betForm").submit(function(event){
        event.preventDefault();
        var form = $(this);
        $.ajax({
            type: 'POST',
            url:form.attr('action'),
            beforeSend: function(){
                JsLoadingOverlay.show();
            },
            dataType: 'json',
            data:form.serialize(),
            success: function(result){
                console.log(result)
                 JsLoadingOverlay.hide();
                if(result.status == 'success'){
                    form.trigger('reset')
                    // swal("Transaction Successful!", result.message, "success");
                    Snackbar.show({
                        backgroundColor: '#38c172',
                        pos: 'top-right',
                        text: result.message,
                    });
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
                    console.log(errors)
                    Snackbar.show({
                        backgroundColor: '#e3342f',
                        pos: 'top-right',
                        text: errors.message,
                    });
                }
                var errors = (result.responseText);
                console.log(errors)
                Snackbar.show({
                    backgroundColor: '#e3342f',
                    pos: 'top-right',
                    text: result.statusText,
                });
            }
        });
    });

    $("#validate").on('click',function(){
        var betsite = $("#betsiteSelector").find(":selected").val();
        var accountId = $("#accountId").val();
        // alert('Heplpp')
        if(betsite == '' || accountId == ''){
            Snackbar.show({
                backgroundColor: '#e3342f',
                pos: 'top-right',
                text: 'All field Required',
            });
        }else{
            $.ajax({
                type: 'POST',
                url:"{{route('user.bills.bet.validation')}}",
                beforeSend: function(){
                    JsLoadingOverlay.show();
                },
                dataType: 'json',
                data:{
                    betsite,
                    accountId,
                    _token:"{{ csrf_token() }}"
                },
                success: function(result){
                    console.log(result)
                     JsLoadingOverlay.hide();
                    if(result.status == 'success'){
                        $("#account_name").val(result.name);
                        $("#div_account_name").css('display','block');
                        $("#validate").css('display','none');
                        $("#sbutton").css('display','block');
                    }else{
                        $("#div_account_name").css('display','none');
                        Snackbar.show({
                            backgroundColor: '#e3342f',
                            pos: 'top-right',
                            text: result.message,
                        });
                        $("#validate").css('display','block');
                        $("#sbutton").css('display','none');
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
                    }
                    //var errors = $.parseJSON(result.responseText);
                    $("#div_account_name").css('display','none');
                    Snackbar.show({
                        backgroundColor: '#e3342f',
                        pos: 'top-right',
                        text: "Unable to verify Meter",
                    });
                    $("#validate").css('display','block');
                    $("#sbutton").css('display','none');

                }
            });
        }
    });
</script>

@endpush
@section('styles')
<style>
    #div_account_name{
        display: none;
    }
    .form-group{
        margin-bottom: 15px;
    }
</style>
@endsection
