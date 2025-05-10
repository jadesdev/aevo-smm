@extends('user.layouts.master')
@section('title')
    {{ 'Pay with Binance Pay' }}
@endsection

@section('content')

<div class="row my-3">
    <div class="col-md-12">
        <div class="d-card">
            <div class="d-card-body text-center">
                <div class="row justify-content-center">
                    <div class="col-md-3">
                        <div class="card">
                            <img src="{{static_asset('payments/binance.jpg')}}"
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
                                @lang('You will Get '):
                                <strong> {{format_price($details['amount'])}} {{get_setting('currency_code')}}</strong>
                            </li>
                        </ul>

                        <a type="button" href="{{$data['redirect_url']}}" target="_blank" class="btn btn-info w-100" id="btn-confirm" >@lang('Pay Now')</a>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')

@endpush
@section('styles')
<style>
    .list-group-item {
        position: relative;
        display: block;
        padding: 0.75rem 1.25rem;
        background-color: inherit;
        border: 1px solid rgba(0,0,0,.125);
    }
</style>
@endsection
