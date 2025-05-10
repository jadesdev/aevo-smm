@extends('admin.layouts.master')
@section('title', 'Payment Settings')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-card">
            <h5 class="fw-bold card-header">Webhook Urls</h5>
            <div class="d-card-body">
                <div class="form-group">
                    <label class="form-label">Binance</label>
                    <input type="text"class="form-control" placeholder="{{route('binance.webhook')}}" value="{{route('binance.webhook')}}">
                </div>
                <div class="form-group">
                    <label class="form-label">Coinbase</label>
                    <input type="text"class="form-control" placeholder="{{route('coinbase.success')}}" value="{{route('coinbase.success')}}">
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="d-card">
            <div class="card-header">
                <h5 class="mb-0 fw-bold ">Paystack Payment</h5>
            </div>
            <div class="d-card-body">
                <div class="form-group row">
                    <div class="col-9">
                        <label class="form-label">Enable Paystack</label>
                    </div>
                    <div class="col-3">
                        <label class="jdv-switch jdv-switch-success mb-0">
                            <input type="checkbox" onchange="updateSystem(this, 'paystack_payment')" @if(sys_setting('paystack_payment') == 1) checked @endif>
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="d-card">
            <div class="card-header">
                <h5 class="mb-0 fw-bold ">Coinbase Payment</h5>
            </div>
            <div class="d-card-body">
                <div class="form-group row">
                    <div class="col-9">
                        <label class="form-label">Enable Coinbase</label>
                    </div>
                    <div class="col-3">
                        <label class="jdv-switch jdv-switch-success mb-0">
                            <input type="checkbox" onchange="updateSystem(this, 'coinbase_payment')" @if(sys_setting('coinbase_payment') == 1) checked @endif>
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="d-card">
            <div class="card-header">
                <h5 class="mb-0 fw-bold ">Binance Payment</h5>
            </div>
            <div class="d-card-body">
                <div class="form-group row">
                    <div class="col-9">
                        <label class="form-label">Enable Binance</label>
                    </div>
                    <div class="col-3">
                        <label class="jdv-switch jdv-switch-success mb-0">
                            <input type="checkbox" onchange="updateSystem(this, 'binance_payment')" @if(sys_setting('binance_payment') == 1) checked @endif>
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="d-card">
            <div class="card-header">
                <h5 class="mb-0 fw-bold ">Perfect Money</h5>
            </div>
            <div class="d-card-body">
                <div class="form-group row">
                    <div class="col-9">
                        <label class="form-label">Perfect Money</label>
                    </div>
                    <div class="col-3">
                        <label class="jdv-switch jdv-switch-success mb-0">
                            <input type="checkbox" onchange="updateSystem(this, 'perfect_payment')" @if(sys_setting('perfect_payment') == 1) checked @endif>
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="d-card">
            <div class="card-header">
                <h5 class="mb-0 fw-bold ">Flutterwave Payment</h5>
            </div>
            <div class="d-card-body">
                <div class="form-group row">
                    <div class="col-9">
                        <label class="form-label">Enable Fluttterwave</label>
                    </div>
                    <div class="col-3">
                        <label class="jdv-switch jdv-switch-success mb-0">
                            <input type="checkbox" onchange="updateSystem(this, 'flutterwave_payment')" @if(sys_setting('flutterwave_payment') == 1) checked @endif>
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="d-card">
            <div class="card-header">
                <h5 class="mb-0 fw-bold ">Bank Transfer</h5>
            </div>
            <div class="d-card-body">
                <div class="form-group row">
                    <div class="col-9">
                        <label class="form-label">Enable Transfer</label>
                    </div>
                    <div class="col-3">
                        <label class="jdv-switch jdv-switch-success mb-0">
                            <input type="checkbox" onchange="updateSystem(this, 'bank_transfer')" @if(sys_setting('bank_transfer') == 1) checked @endif>
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-9">
                        <label class="form-label">Enable Bank Accounts</label>
                    </div>
                    <div class="col-3">
                        <label class="jdv-switch jdv-switch-success mb-0">
                            <input type="checkbox" onchange="updateSystem(this, 'auto_bank')" @if(sys_setting('auto_bank') == 1) checked @endif>
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="col-sm-6 col-md-3">
        <div class="d-card">
            <div class="card-header">
                <h5 class="mb-0 fw-bold ">Bank Accounts</h5>
            </div>
            <div class="d-card-body">
                <div class="form-group row">
                    <div class="col-9">
                        <label class="form-label">Enable Bank Accounts</label>
                    </div>
                    <div class="col-3">
                        <label class="jdv-switch jdv-switch-success mb-0">
                            <input type="checkbox" onchange="updateSystem(this, 'auto_bank')" @if(sys_setting('auto_bank') == 1) checked @endif>
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="col-sm-6 col-md-3">
        <div class="d-card">
            <div class="card-header">
                <h5 class="mb-0 fw-bold ">Paypal Payment</h5>
            </div>
            <div class="d-card-body">
                <div class="form-group row">
                    <div class="col-9">
                        <label class="form-label">Enable Paypal</label>
                    </div>
                    <div class="col-3">
                        <label class="jdv-switch jdv-switch-success mb-0">
                            <input type="checkbox" onchange="updateSystem(this, 'paypal_payment')" @if(sys_setting('paypal_payment') == 1) checked @endif>
                            <span class="slider round"></span>
                        </label>
                    </div>

                </div>
                <div class="form-group row">
                    <div class="col-9">
                        <label class="form-label">Demo Mode</label>
                    </div>
                    <div class="col-3">
                        <label class="jdv-switch jdv-switch-success mb-0">
                            <input type="checkbox" onchange="updateSystem(this, 'paypal_demo')" @if(sys_setting('paypal_demo') == 1) checked @endif>
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="d-card">
            <div class="card-header">
                <h5 class="mb-0 fw-bold ">Monnify Activation</h5>
            </div>
            <div class="d-card-body">
                <div class="form-group row">
                    <div class="col-9">
                        <label class="form-label">Enable Monnify</label>
                    </div>
                    <div class="col-3">
                        <label class="jdv-switch jdv-switch-success mb-0">
                            <input type="checkbox" onchange="updateSystem(this, 'monnify_payment')" @if(sys_setting('monnify_payment') == 1) checked @endif>
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>
                <hr>
                <div class="form-group row">
                    <div class="col-9">
                        <label class="form-label">Demo Mode</label>
                    </div>
                    <div class="col-3">
                        <label class="jdv-switch jdv-switch-success mb-0">
                            <input type="checkbox" onchange="updateSystem(this, 'monnify_demo')" @if(sys_setting('monnify_demo') == 1) checked @endif>
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-6 col-md-4">
        <div class="d-card">
            <div class="card-header">
                <h5 class="mb-0 fw-bold ">Paystack Credentials</h5>
            </div>
            <div class="d-card-body">
                <form class="form-horizontal" action="{{ route('admin.setting.env_key') }}" method="POST">
                    @csrf
                    <input type="hidden" name="payment_method" value="paystack">
                    <div class="form-group">
                        <input type="hidden" name="types[]" value="PAYSTACK_PUBLIC_KEY">
                        <label class="form-label">{{__('PUBLIC KEY')}}</label>
                        <input type="text" class="form-control" name="PAYSTACK_PUBLIC_KEY" value="{{  env('PAYSTACK_PUBLIC_KEY') }}" placeholder="PUBLIC KEY" required>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="types[]" value="PAYSTACK_SECRET_KEY">
                        <label class="form-label">{{__('SECRET KEY')}}</label>
                        <input type="text" class="form-control" name="PAYSTACK_SECRET_KEY" value="{{  env('PAYSTACK_SECRET_KEY') }}" placeholder="SECRET KEY" required>
                    </div>
                    <div class="form-group mb-0 text-end">
                        <button type="submit" class="btn btn-md btn-success w-100">{{__('Save')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-4">
        <div class="d-card">
            <div class="card-header">
                <h5 class="mb-0 fw-bold ">Perfect Money Credentials</h5>
            </div>
            <div class="d-card-body">
                <form class="form-horizontal" action="{{ route('admin.setting.env_key') }}" method="POST">
                    @csrf
                    <input type="hidden" name="payment_method" value="paystack">
                    <div class="form-group">
                        <input type="hidden" name="types[]" value="PM_PASSPHRASE">
                        <label class="form-label">{{__('PERFECT MONEY PASSPHRASE')}}</label>
                        <input type="text" class="form-control" name="PM_PASSPHRASE" value="{{  env('PM_PASSPHRASE') }}" placeholder="PM PASSPHRASE" required>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="types[]" value="PM_WALLET">
                        <label class="form-label">{{__('PERFECT MONEY WALLET')}}</label>
                        <input type="text" class="form-control" name="PM_WALLET" value="{{  env('PM_WALLET') }}" placeholder="PERFECT MONEY WALLET" required>
                    </div>
                    <div class="form-group mb-0 text-end">
                        <button type="submit" class="btn btn-md btn-success w-100">{{__('Save')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-4">
        <div class="d-card">
            <div class="card-header">
                <h5 class="mb-0 fw-bold ">Flutterwave Credentials</h5>
            </div>
            <div class="d-card-body">
                <form class="form-horizontal" action="{{ route('admin.setting.env_key') }}" method="POST">
                    @csrf
                    <input type="hidden" name="payment_method" value="flutter">
                    <div class="form-group">
                        <input type="hidden" name="types[]" value="FLW_PUBLIC_KEY">
                        <label class="form-label">{{__('FLW PUBLIC KEY')}}</label>
                        <input type="text" class="form-control" name="FLW_PUBLIC_KEY" value="{{  env('FLW_PUBLIC_KEY') }}" placeholder="FLUTTERWAVE PUBLIC KEY" required>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="types[]" value="FLW_SECRET_KEY">
                        <label class="form-label">{{__('FLW SECRET KEY')}}</label>
                        <input type="text" class="form-control" name="FLW_SECRET_KEY" value="{{  env('FLW_SECRET_KEY') }}" placeholder="FLUTTERWAVE PUBLIC KEY" required>
                    </div>
                    <div class="form-group mb-0 text-end">
                        <button type="submit" class="btn btn-md btn-success w-100">{{__('Save')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-4 ">
        <div class="d-card ">
            <div class="card-header">
                <h5 class="fw-bold mb-0">{{__('Paypal Credential')}}</h5>
            </div>
            <form action="{{ route('admin.setting.env_key') }}" method="POST">
                @csrf
                <div class="d-card-body">
                    <input type="hidden" name="payment_method" value="paypal">
                    <div class="form-group">
                        <input type="hidden" name="types[]" value="PAYPAL_CLIENT_ID">
                        <label class="form-label">{{__('Paypal Client Id')}}</label>
                        <input type="text" class="form-control" name="PAYPAL_CLIENT_ID" value="{{  env('PAYPAL_CLIENT_ID') }}" placeholder="Paypal Client ID" required>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="types[]" value="PAYPAL_CLIENT_SECRET">
                        <label class="form-label">{{__('Paypal Client Secret')}}</label>
                        <input type="text" class="form-control" name="PAYPAL_CLIENT_SECRET" value="{{  env('PAYPAL_CLIENT_SECRET') }}" placeholder="Paypal Client Secret" required>
                    </div>
                </div>
                <div class="">
                    <button class="btn btn-success btn-block" type="submit">{{__('Save')}}</button>
                </div>
            </form>
        </div>
    </div>
    <div class="col-sm-6 col-md-4">
        <div class="d-card">
            <div class="card-header">
                <h5 class="mb-0 fw-bold ">Monnify Credentials</h5>
            </div>
            <div class="d-card-body">
                <form class="form-horizontal" action="{{ route('admin.setting.env_key') }}" method="POST">
                    @csrf
                    <input type="hidden" name="payment_method" value="monnify">
                    <div class="form-group">
                        <input type="hidden" name="types[]" value="MONNIFY_API_KEY">
                        <label class="form-label">Monnify Api Key</label>
                        <input type="text" class="form-control" name="MONNIFY_API_KEY" value="{{  env('MONNIFY_API_KEY') }}" placeholder="Monnify Api key" required>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="types[]" value="MONNIFY_CONTRACT">
                        <label class="form-label">Monnify Contract</label>
                        <input type="text" class="form-control" name="MONNIFY_CONTRACT" value="{{  env('MONNIFY_CONTRACT') }}" placeholder="Monnify Contract Code" required>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="types[]" value="MONNIFY_SECRET_KEY">
                        <label class="form-label">Monnify Secret</label>
                        <input type="text" class="form-control" name="MONNIFY_SECRET_KEY" value="{{  env('MONNIFY_SECRET_KEY') }}" placeholder="Monnify secret key" required>
                    </div>
                    <div class="form-group mb-0 text-end">
                        <button type="submit" class="btn btn-md btn-success w-100">{{__('Save')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-md-4 ">
        <div class="d-card mb-2">
            <h5 class="card-header fw-bold">{{__('Coinbase Credential')}}</h5>
            <form action="{{ route('admin.setting.env_key') }}" method="POST">
                @csrf
                <div class="d-card-body">
                    <div class="form-group">
                        <input type="hidden" name="types[]" value="COINBASE_KEY">
                        <label class="form-label">{{__('COINBASE API KEY')}}</label>
                        <input type="text" class="form-control" name="COINBASE_KEY" value="{{  env('COINBASE_KEY') }}" placeholder="COINBASE API KEY" required>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="types[]" value="COINBASE_SECRET">
                        <label class="form-label">{{__('COINBASE SECRET KEY')}}</label>
                        <input type="text" class="form-control" name="COINBASE_SECRET" value="{{  env('COINBASE_SECRET') }}" placeholder="COINBASE SECRET KEY" required>
                    </div>
                    <button class="btn btn-success btn-md w-100" type="submit">{{__('Save')}}</button>
                </div>
            </form>
        </div>
    </div>

    <div class="col-sm-6 col-md-4 ">
        <div class="d-card mb-2">
            <h5 class="card-header fw-bold">{{__('Binance Credential')}}</h5>
            <form action="{{ route('admin.setting.env_key') }}" method="POST">
                @csrf
                <div class="d-card-body">
                    <div class="form-group">
                        <input type="hidden" name="types[]" value="BINANCE_KEY">
                        <label class="form-label">{{__('BINANCE API KEY')}}</label>
                        <input type="text" class="form-control" name="BINANCE_KEY" value="{{  env('BINANCE_KEY') }}" placeholder="BINANCE API KEY" required>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="types[]" value="BINANCE_SECRET">
                        <label class="form-label">{{__('BINANCE SECRET KEY')}}</label>
                        <input type="text" class="form-control" name="BINANCE_SECRET" value="{{  env('BINANCE_SECRET') }}" placeholder="BINANCE SECRET KEY" required>
                    </div>

                    <button class="btn btn-success btn-md w-100" type="submit">{{__('Save')}}</button>
                </div>
            </form>
        </div>
    </div>

    <div class="col-sm-6 col-md-4">
        <div class="d-card">
            <h5 class="card-header fw-bold mb-0">Bank Payment Details</h5>
            <div class="d-card-body">
                <form action="{{route('admin.setting.store_settings')}}" method="post">
                    @csrf
                    <div class="form-group">
                        <input type="hidden" name="types[]" value="bank_name">
                        <label class="form-label">Bank Name</label>
                        <input type="text"class="form-control" name="bank_name" placeholder="Bank Name" value="{{sys_setting('bank_name')}}" required>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="types[]" value="account_name">
                        <label class="form-label">Account Name</label>
                        <input type="text"class="form-control" name="account_name" placeholder="Account Name" value="{{sys_setting('account_name')}}" required>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="types[]" value="account_number">
                        <label class="form-label">Account Number</label>
                        <input type="text"class="form-control" name="account_number" placeholder="Account Number" value="{{sys_setting('account_number')}}" required>
                    </div>
                    <div class="form-group text-end mb-0">
                        <button class="btn btn-success btn-md w-100" type="submit">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-md-4">
        <div class="d-card">
            <h5 class="card-header fw-bold mb-0">Payment Charges</h5>
            <div class="d-card-body">
                <form action="{{route('admin.setting.store_settings')}}" method="post">
                    @csrf
                    <div class="form-group">
                        <input type="hidden" name="types[]" value="bank_fee">
                        <label class="form-label">Manual Transfer Charges</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="bank_fee" placeholder="Bank Charges" value="{{sys_setting('bank_fee')}}" required>
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-info text-white">{{get_setting('currency')}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="types[]" value="auto_fee">
                        <label class="form-label">Auto Transfer Charges</label>
                        <div class="input-group">
                            <input type="text"class="form-control" name="auto_fee" placeholder="Transfer Charges" value="{{sys_setting('auto_fee')}}" required>
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-info text-white">%</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="types[]" value="auto_cap">
                        <label class="form-label">Auto Transfer Capped @</label>
                        <div class="input-group">
                            <input type="text"class="form-control" name="auto_cap" placeholder="Autobank Capped" value="{{sys_setting('auto_cap')}}" required>
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-info text-white">{{get_setting('currency')}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="types[]" value="deposit_fee">
                        <label class="form-label">Deposit Fee (%)</label>
                        <div class="input-group">
                            <input type="text"class="form-control" name="deposit_fee" placeholder="Deposit fee" value="{{sys_setting('deposit_fee')}}" required>
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-info text-white">%</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="types[]" value="min_deposit">
                        <label class="form-label">Minimum Deposit({{get_Setting('currency')}})</label>
                        <div class="input-group">
                            <input type="text"class="form-control" name="min_deposit" placeholder="Minimum Deposit" value="{{sys_setting('min_deposit')}}" required>
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-info text-white">{{get_setting('currency')}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-0">
                        <button class="btn btn-success w-100 btn-md" type="submit">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-4">
        <div class="d-card">
            <div class="card-header h4">Currency Settings</div>
            <div class="d-card-body">
                <form action="{{route('admin.setting.update')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group col-sm-12 ">
                        <label class="form-label">Currency Symbol</label>
                        <input type="text" class="form-control" name="currency" value="{{get_setting('currency')}}" required placeholder="Currency Symbol"/>
                    </div>
                    <div class="form-group col-sm-12">
                        <label class="form-label">Currency Code</label>
                        <input type="text" class="form-control" name="currency_code" value="{{get_setting('currency_code')}}" required placeholder="Currency Code"/>
                    </div>
                    <div class="form-group col-sm-12">
                        <label class="form-label">Currency Rate [1 USD to {{get_setting('currency_code')}}]</label>
                        <input type="text" class="form-control" name="currency_rate" value="{{get_setting('currency_rate')}}" required placeholder="Currency Conversion rate"/>
                    </div>
                    <div class="text-end">
                        <button class="btn btn-success btn-md w-100" type="submit">@lang('Update Setting')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('breadcrumb')

<div class="d-card dc-dash">
    <div class="row">
        <div class="col-lg-6 col-md-8 col-12">
            <div class="py-3 px-5">
                <div class="dch-title">
                   @yield('title')
                </div>
                <div class="dch-text">

                </div>
            </div>
        </div>
    </div>
</div>
<!-- end page title -->
@endsection

@push('scripts')
<script>
    function updateSystem(el, name){
        if($(el).is(':checked')){
            var value = 1;
        }
        else{
            var value = 0;
        }
        $.post('{{ route('admin.setting.sys_settings') }}', {_token:'{{ csrf_token() }}', name:name, value:value}, function(data){
            if(data == '1'){
                Snackbar.show({
                    text: '{{__('Settings Updated Successfully')}}',
                    pos: 'top-right',
                    backgroundColor: '#38c172'
                });
            }
            else{
                Snackbar.show({
                    text: '{{__('Something went wrong')}}',
                    pos: 'top-right',
                    backgroundColor: '#e3342f'
                });
            }
        });
    }
</script>
@endpush
@section('styles')
<style>
    .primage {
        max-height: 50px !important;
        max-width: 150px !important;
        margin: 0;
    }
    .card-header{border-top:1px solid #1d1f1d }
    .d-card{margin-bottom: 20px;}
</style>
@endsection
