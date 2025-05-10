@extends('user4.layouts.master')
@section('title', "Buy Airtime")
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
                    <i class="icon fa fa-phone mr-3"></i> <span class="">@yield('title') </span>
                </div></div>
            <div class="card-body">
                <form action="{{route('user.bills.airtime')}}" method="post" id="buyAirtime" class="form-validate is-alter">
                    @csrf
                    <div class="form-group">
                        <label class="form-label" for="network">Network</label>
                        <div class="form-control-wrap">
                            <select class="form-select form-control" name="network" id="networkSelector" data-placeholder="Select Network" required>
                                <option value="" disabled> Select Network</option>
                                @foreach ($networks as $item)
                                    <option value="{{$item->id}}" discount="{{$item->discount}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="phoneNumber">Phone Number</label>
                        <div class="form-control-wrap">
                            <input type="number" maxlength="11" onkeyup="NumberValidator()" required name="phone" class="form-control" id="phoneNumber" >
                            <span id="phone-validator" style="font-size: 10px;"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="amount">Amount</label>
                        <div class="form-control-wrap">
                            <input type="number" pattern="[0-9]*" maxlength="11" name="amount" class="form-control" id="amount" placeholder="Amount">
                        </div>
                        <label><span class="b" id="charge"></span><span class="b" id="discount"></span></label>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary w-100 mb-2" id="sbutton"><span>Proceed</span></button>
                    </div>
                </form>
            </div>
        </div><!-- .card-preview -->
    </div>
</div>

@endsection

@push('scripts')
<script src="{{static_asset('js/phone.js')}}"></script>
{{-- discount calculator --}}
<script>
    $(document).ready(function(){
        $("#networkSelector").change(function(){
            var network =$("#networkSelector option:selected").val();
            var discount =$("#networkSelector option:selected").attr('discount');

            $("#charge").text('You will pay ₦' + (Number($("#amount").val()) * Number(discount) / 100 ));
            $("#discount").text( (', that is ' +  (100 - discount ))  + '% Discount');
            $("#amount").keyup(function() {
                $("#charge").text('You will pay ₦' + (Number($("#amount").val()) * Number(discount) / 100 ));
                $("#discount").text( (', that is ' +  (100 - discount ))  + '% Discount');
            });
        });


        // submit form
        $("#buyAirtime").submit(function(event){
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
                        // form.trigger('reset')
                        swal("Transaction Successful!", result.message, "success",{buttons: ["Receipt", "OK"]})
                        .then((willDelete) => {
                            if (willDelete) {
                            } else {
                                // open link
                                window.location = result.url;
                            }
                        });
                        Snackbar.show({
                            backgroundColor: '#38c172',
                            pos: 'top-right',
                            text: result.message,
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
    });
</script>
@endpush
@section('styles1')
<style>
    .form-group{
        margin-bottom: 10px;
    }
</style>
@endsection
