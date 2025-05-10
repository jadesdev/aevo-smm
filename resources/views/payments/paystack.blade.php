@extends('user.layouts.master')
@section('title')
    {{ 'Pay with Paystack' }}
@endsection

@section('content')

<div class="row my-3">
    <div class="col-md-12">
        <div class="d-card">
            <div class="d-card-body text-center">
                <div class="row justify-content-center">
                    <div class="col-md-3">
                        <div class="card">
                            <img src="{{static_asset('payments/paystack.jpg')}}"
                                    class="card-img-top gateway-img" alt="..">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <form action="{{route('paystack.success')}}" method="post">
                            @csrf
                            <ul class="list-group text-center mb-5">
                                <li class="list-group-item d-flex justify-content-between">
                                    @lang('Amount to Pay '):
                                    <strong> {{format_amount($details['final'])}} {{get_system_currency()->code}}</strong>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    @lang('Amount in USD '):
                                    <strong>{{format_number($details['final2'])}} {{'USD'}} </strong>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    @lang('You will Get '):
                                    <strong> {{format_price($details['amount'])}} {{get_setting('currency_code')}}</strong>
                                </li>
                            </ul>

                            <button type="button" class="btn btn-info w-100" id="btn-confirm">@lang('Pay Now')</button>

                            <script src="//js.paystack.co/v1/inline.js" data-key="{{ env('PAYSTACK_PUBLIC_KEY')}}" data-email="{{ $details['email'] }}"
                                data-amount="{{ round($details['final']  * 100 )}}" data-currency="{{ get_setting('currency_code') }}" data-ref="{{ $details['reference'] }}"
                                data-custom-button="btn-confirm"></script>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


@endsection

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
