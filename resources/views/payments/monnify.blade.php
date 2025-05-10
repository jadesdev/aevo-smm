@extends('user.layouts.master')
@section('title')
    {{ 'Pay with Monnify' }}
@endsection

@section('content')

<div class="row my-3">
    <div class="col-md-12">
        <div class="d-card">
            <div class="d-card-body text-center">
                <div class="row justify-content-center">
                    <div class="col-md-3">
                        <div class="card">
                            <img src="{{static_asset('payments/monnify.jpg')}}"
                                    class="card-img-top gateway-img" alt="..">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <ul class="list-group text-center mb-5">
                            <li class="list-group-item d-flex justify-content-between">
                                @lang('Amount to Pay '):
                                <strong> {{format_amount($details['final'])}} {{get_system_currency()->code}}</strong>
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
                        <button type="button" class="btn btn-info btn-block mt-2" id="btn-confirm" onclick="payWithMonnify()">@lang('Pay via Monnify')
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script type="text/javascript" src="//sdk.monnify.com/plugin/monnify.js"></script>
<script type="text/javascript">
    function payWithMonnify() {
        MonnifySDK.initialize({
            amount: {{ $details['amount'] ?? '0' }},
            currency: "{{ get_setting('currency_code') ?? 'NGN' }}",
            reference: "{{ $details['reference'] }}",
            customerName: "{{$details['name'] ?? 'John Doe'}}",
            customerEmail: "{{$details['email'] ?? 'example@example.com'}}",
            customerMobileNumber: "{{ $details['phone'] ?? '0123' }}",
            apiKey: "{{ env('MONNIFY_API_KEY') }}",
            contractCode: "{{ env('MONNIFY_CONTRACT') }}",
            paymentDescription: "{{ $details['description'] }}",
            // isTestMode: true,
            onComplete: function (response) {
                if (response.paymentReference) {
                    window.location.href = '{{ route('monnify.success') }}?reference='+"{{ $details['reference'] }}";
                } else {
                    window.location.href = '{{ route('user.deposit') }}';
                }
            },
            onClose: function (data) {
            }
        });
    }
</script>
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
