@extends('user4.layouts.master')
@section('title', 'Fund Wallet')

@section('content')
    <div class="row justify-content-center">
        @if (sys_setting('auto_bank') == 1)
            <div class="col-md-8  mb-3">
                <div class="card">
                    <div class="card-header">
                        <div class="dch-body">
                            <i class="icon fa fa-bank"></i> <span class="">Bank Transfer </span>
                        </div>
                    </div>

                    @if (Auth::user()->virtual_ref == null)
                        <div class="card-body">

                            @include('alerts.alerts')

                            Click the button below to generate virtual accounts for seamless wallet funding.<br><br>

                            <a href="{{ route('user.generate_acc') }}" class="btn btn-primary "
                                style="background:#000;">Generate Accounts</a>
                        </div>
                    @else
                        <div class="card-body" style="">
                            <div class="alert alert-success" role="alert" style="style="font-size: 14px; "">
                                Make payment into any account number below to fund your wallet automatically.
                            </div>
                            @if ($banks !== null)
                                @foreach ($banks as $key => $bank)
                                    <div class="bank-panel">

                                        <div> <span style="float:left;" id="bankName">
                                                <p style="font-size: 10px; margin: 0;">Bank Name</p>
                                                <strong>{{ $bank->bankName }}</strong>
                                            </span>

                                            <span style="float:right;text-align:right;" id="accName">
                                                <p style="font-size: 10px; margin: 0;">Account Name</p>
                                                <strong>{{ Auth::user()->fname }} </strong>
                                            </span>
                                        </div>

                                        <div class="col-12 d-flex align-self-center form-group"
                                            style="padding: 0;margin-top:10px;">
                                            <input type="text"
                                                style="background:transparent; border:1px solid #eeeeee;font-size: 17px;color: #fa7f41;font-weight:bolder;"
                                                class="form-control" id="accum" readonly value="{{ $bank->accountNumber }}">
                                            <button class="btn btn-primary ml-2" id="copyNum" onclick="copyFunction('{{ $bank->accountNumber }}')"> <i class="icon fa fa-copy"></i></button>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    @endif
                </div>

            </div>
        @endif

        <div class="col-md-8 col-12 mb-3 mb-lg-0">
            <div class="card">
                <div class="card-header">
                    <div class="dch-body">
                        <i class="icon far fa-credit-card"></i>
                        <span class="ml-3">Payment Options</span>
                    </div>
                </div>

                <div class="card-body" id="dc-body">

                    <form method="post" action="{{ route('user.deposit.confirm') }}" class="sub-form">
                        @csrf
                        <div class="form-groups my-2">
                            <label for="gateway" class="form-label">Select Payment Option</label>

                            <select class="form-select form-control" name="method" id="payGateway" required>
                                <option value="" disabled>Select Payment Method</option>
                                @if (sys_setting('flutterwave_payment') == 1)
                                    <option value="flutterwave">Flutterwave</option>
                                @endif
                                @if (sys_setting('monnify_payment') == 1)
                                    <option value="monnify">Monnify</option>
                                @endif
                                @if (sys_setting('paypal_payment') == 1)
                                    <option value="paypal">Paypal</option>
                                @endif
                                @if (sys_setting('paystack_payment') == 1)
                                    <option value="paystack">Paystack</option>
                                @endif
                                @if (sys_setting('coinbase_payment') == 1)
                                    <option value="coinbase">Coinbase</option>
                                @endif
                                @if (sys_setting('binance_payment') == 1)
                                    <option value="binance">Binance Pay </option>
                                @endif
                                @if (sys_setting('perfect_payment') == 1)
                                    <option value="perfect">Perfect Money</option>
                                @endif
                                @if (sys_setting('bank_transfer') == 1)
                                    <option value="bank">Bank Transfer</option>
                                @endif
                            </select>
                        </div>
                        <div class="form-groups my-2">
                            <label for="method" class="form-label">Amount ({{ get_setting('currency_code') }})</label>
                            <input type="number" class="form-control" value="{{ old('amount') }}" required step="any"
                                placeholder="1000" name="amount" id="amount">
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Make Payment</button>
                    </form>
                </div>
            </div>
        </div>

    </div>
    <div class="row justify-content-center">
    <div class="col-md-8">
    <div class="card" style="margin-top:15px;">
        <h5 class="card-header">Recent Deposits</h5>
        <div class="card-body table-responsive">
            <table class="w-100 table table-bordered table-hover" id="dataTable2">
                <thead class="thead-tr">
                    <tr>
                        <th>ID</th>
                        <th>Gateway</th>
                        <th>Amount</th>
                        <th>Charge</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($deposits as $key => $item)
                        <tr>
                            <td>{{ $item->code }}</td>
                            <td>{{ $item->gateway }}</td>
                            <td>{{ format_amount($item->amount) }}</td>
                            <td>{{ format_amount($item->charge) }}</td>
                            <td>{!! get_trx_status($item->status) !!}</td>
                            <td>{{ show_datetime($item->created_at) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $deposits->links() }}
        </div></div>
    </div>  </div>

@endsection

@section('breadcrumb')
    <div class="card dc-dash">
        <div class="row">
            <div class="col-lg-6 col-md-8 col-12">
                <div class="py-3 px-5">
                    <div class="dch-title">
                        @yield('title')
                    </div>
                    <div class="dch-text">
                        Fund your wallet and view past deposit transactions.
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('styles')
@endsection
