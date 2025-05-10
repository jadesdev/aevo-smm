@extends('user.layouts.master')
@section('title')
    {{ 'Pay with Bank Transfer' }}
@endsection

@section('content')

<div class="row my-3">
    <div class="col-md-12">
        <div class="d-card">
            <div class="d-card-body text-center">
                <div class="row justify-content-center">
                    <div class="col-md-3">
                        <div class="card">
                            <img src="{{static_asset('payments/bank.jpg')}}"
                                    class="card-img-top gateway-img" alt="..">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <ul class="list-group text-center mb-5">
                            <li class="list-group-item d-flex justify-content-between">
                                @lang('Amount to Pay '):
                                <strong> {{format_amount($details['final'])}} {{get_setting('currency_code')}}</strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                @lang('Amount in USD '):
                                <strong>{{format_number($details['final'] / get_setting('currency_rate'))}} {{'USD'}} </strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                @lang('Charges'):
                                <strong>{{format_amount($details['final'] -$details['amount'])}} </strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                @lang('You will Get '):
                                <strong> {{format_price($details['amount'])}} {{get_setting('currency_code')}}</strong>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6 border border-primary">
                        <b>PAYMENT INSTRUCTIONS</b>
                        <P class="mb-0">Make your payment to the account below</P>
                        <p>Your account would be funded as soon as we receive payment. ({{format_amount(sys_setting('bank_fee'))}} charges applied).</p>
                        <ul class="list-group my-2 text-left">
                            <li class="list-group-item">BANK NAME: {{sys_setting('bank_name')}}</li>
                            <li class="list-group-item">ACCOUNT NAME: {{sys_setting("account_name")}}</li>
                            <li class="list-group-item">ACCOUNT NUMBER: {{sys_Setting("account_number")}}</li>
                        </ul>
                        <p>Your account will be deleted if you submit invalid <b>payment receipt</b>.</p>
                        <p>Attach your payment receipt below</p>
                    </div>
                    <div class="col-md-6 border border-primary">
                        <form action="{{route('user.deposit.bank')}}" method="post" class="text-left" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="" class="form-label">Account Name</label>
                                <input class="form-control" name="name" type="text" required placeholder="Name on Teller/Receipt" >
                            </div>
                            <div class="form-group">
                                <label for="" class="form-label">Payment Receipt</label>
                                <input class="form-control" name="document" type="file" accept="image/*" required onchange="preview_picture(event)" >
                            </div>
                            <input type="hidden" name="deposit_id" value="{{$details['deposit_id']}}">
                            <div class="form-group text-center">
                                <img id="pimage" class="d-none b-image mb-2"/>
                            </div>
                            <div class="form-group mb-0 text-center">
                                <button type="submit" class="btn btn-md btn-primary w-100">Submit</button>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    function preview_picture(event)
    {
        document.getElementById('pimage').classList.remove('d-none');
        var reader = new FileReader();
        reader.onload = function()
        {
            var output = document.getElementById('pimage');
            output.src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endpush
@section('styles')
<style>
    .b-image{
        min-height: 300px;
        max-height:100%;
        width: auto;
        max-width: 100%;
    }
    .list-group-item {
        position: relative;
        display: block;
        padding: 0.75rem 1.25rem;
        background-color: inherit;
        border: 1px solid rgba(0,0,0,.125);
    }
    .border{padding: 10px;}
</style>
@endsection
