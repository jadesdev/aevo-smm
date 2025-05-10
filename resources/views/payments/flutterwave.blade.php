@extends('user.layouts.master')
@section('title')
    {{ 'Pay with Flutterwave' }}
@endsection

@section('content')

<div class="row my-3 justify-content-center">
    <div class="col-md-8">
        <div class="d-card">

                <div class="row justify-content-center">
                    <div class="col-md-8"><div class="d-card-body text-center">
                        <div class="card">
                            <img src="{{static_asset('payments/flutter.jpg')}}"
                                    class="card-img-top gateway-img" alt="..">
                        </div>

                        <ul class="list-group text-center mb-5">
                            <li class="list-group-item d-flex justify-content-between">
                                @lang('Amount to Pay '):
                                <strong> {{format_amount($details['final'])}} {{get_system_currency()->code}}</strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between" hidden>
                                @lang('Amount in USD '):
                                <strong>{{format_number($details['final'] / get_setting('currency_rate'))}} {{'USD'}} </strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                @lang('You will Get '):
                                <strong> {{format_price($details['amount'])}} {{get_setting('currency_code')}}</strong>
                            </li>
                        </ul>

                        <button type="button" class="btn btn-info w-100" id="btn-confirm" onClick="payWithRave()">@lang('Pay Now')</button>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>



    {{-- <script src="https://api.ravepay.co/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script> --}}
    <script src="https://checkout.flutterwave.com/v3.js"></script>
    <script>
        var btn = document.querySelector("#btn-confirm");
        btn.setAttribute("type", "button");
        const API_publicKey = "{{env('FLW_PUBLIC_KEY') ?? ''}}";

        function payWithRave() {

            const checkoutData = {
            public_key: API_publicKey, // Replace with your actual public key
            tx_ref: "{{$details['reference']}}", // Assuming get_trx(18) returns a valid transaction reference
            payment_options: "card, banktransfer, ussd,mobilemoneyghana,mobilemoneyfranco,mobilemoneyuganda,mobilemoneyrwanda,mobilemoneyzambia,barter,credit",
            amount: "{{$details['final']}}", // Assuming totalAmount is defined somewhere in your code
            currency:  "{{ get_setting('currency_code') ?? 'USD' }}", // Assuming get_setting('currency_code') returns the currency code
            redirect_url: "{{ route('flutter.success') }}" , // Replace with the actual redirect URL
            onclose: function () {},
            meta: {
                reference : "{{$details['reference']}}",
                user_id : "{{$details['user_id']}}"
            },
            customer: {
                email: "{{ $details['email'] ?? 'example@gmail.com' }}", // Include the email from the form
                phone_number: "{{ $details['phone'] ?? '0123' }}", // Include the phone number from the form
                name: "{{ $details['name'] ?? 'Demo User' }}", // Replace with the actual customer name if available
            },
        };

        FlutterwaveCheckout(checkoutData);

            // var x = getpaidSetup({
            //     PBFPubKey: API_publicKey,
            //     customer_email: "{{$details['email'] ?? 'example@example.com'}}",
            //     amount: "{{ $details['amount'] ?? '0' }}",
            //     customer_phone: "{{ $details['phone'] ?? '0123' }}",
            //     currency: "{{ get_setting('currency_code') ?? 'USD' }}",
            //     txref: "{{ $details['reference'] ?? '' }}",
            //     // meta: ,
            //     onclose: function () {
            //     },
            //     callback: function (response) {
            //         let txref = response.tx.txRef;
            //         let status = response.tx.status;
            //         window.location = '{{ route('flutter.success') }}/?trx_ref=' + txref + '&status=' + status;
            //     }
            // });
        }
    </script>
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
