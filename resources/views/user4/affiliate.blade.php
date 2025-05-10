@extends('user4.layouts.master')
@section('title', 'Refer and Earn')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card mb-3">
            <div class="card-body">
                <div class="ref-items">

                    <div class="ref-item">
                        <div class="row">
                            <div class="col align-self-center fw-bold">
                                Every time someone registers an account on our website using your affiliate link, You get a commission on all their transactions for life.
                            </div>
                        </div>
                    </div>


                    <div class="ref-item">
                        <div class="row">
                            <div class="mt-2 col-12 hlight-first align-self-center">
                                Referral Link
                            </div>
                            <div class="col-12 d-flex align-self-center form-group">
                                <input type="text" class="form-control" id="refLink" disabled value="{{route('signup')}}?ref={{Auth::user()->username}}">
                                <button class="btn btn-primary ms-2" style="padding: 12px;" onclick="copyFunction('{{route('signup')}}?ref={{Auth::user()->username}}')"><i class="fa-duotone fa-solid fa-copy"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="ref-item">
                        <div class="row">
                            <div class="col-12 hlight-first align-self-center">
                                Referral Code
                            </div>
                            <div class="col-12 d-flex align-self-center form-group">
                                <input type="text" disabled class="form-control" id="refLink" value="{{Auth::user()->username}}">
                                <button class="btn btn-primary ms-2" style="padding: 12px;" onclick="copyFunction('{{Auth::user()->username}}')"><i class="fa-duotone fa-solid fa-copy"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="ref-item" hidden>
                        <div class="row">
                            <div class="col-md-4 col-12 hlight-first align-self-center" hidden>
                                Referral Commision
                            </div>
                            <div class="col-md-8 col-12 hlight-second align-self-center" hidden>
                                {{sys_setting('referral_commission')}}%
                            </div>
                        </div>
                    </div>
                    <div class="ref-item">
                        <div class="row">
                            <div class="col-md-4 col-12 hlight-first align-self-center">
                                Minimum Withdrawal
                            </div>
                            <div class="col-md-8 col-12 hlight-second align-self-center text-end text-right">
                                {{format_amount(sys_setting('min_withdraw'))}}
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <div class="ref-items">
                    <div class="ref-item d-blue mb-2">
                        <div class="row">
                            <div class="col-md-1 col-1 align-self-center icon">
                                <i class="far fa-thumbs-down"></i>
                            </div>
                            <div class="col-md-9 col-8 align-self-center">
                                Total Referrals
                            </div>
                            <div class="col-md-2 col-2 hlight-second align-self-center text-end">
                                {{Auth::user()->referrals->count()}}
                            </div>
                        </div>
                    </div>
                    <div class="ref-item d-blue mb-2">
                        <div class="row">
                            <div class="col-md-1 col-1 align-self-center icon">
                                <i class="fa fa-database"></i>
                            </div>
                            <div class="col-md-8 col-7 align-self-center">
                                Wallet balance
                            </div>
                            <div class="col-md-3 col-3 hlight-second align-self-center text-end">
                               {{format_amount(Auth::user()->balance)}}
                            </div>
                        </div>
                    </div>
                    <div class="ref-item d-blue mb">
                        <div class="row">
                            <div class="col-md-1 col-1 align-self-center icon">
                                <i class="far fa-clock"></i>
                            </div>
                            <div class="col-md-8 col-7 align-self-center">
                                Referral Balance
                            </div>
                            <div class="col-md-3 col-3 hlight-second text-end">
                                {{format_amount(Auth::user()->bonus)}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(sys_setting('point_system') == 1)
        <div class="card my-3">
            <div class="card-header d-flex justify-content-between">
                <h5 class="">Point System</h5>
                @if(sys_setting('point_withdraw') == 1)<button class="btn btn-primary btn-sm" style="float:right;" data-bs-target="#withdrawPointModal" data-bs-toggle="modal">Withdraw Points</button> @endif
            </div>
            <div class="card-body">
                <div class="ref-item d-blue mb">
                    <div class="row">
                        <div class="col-md-4 col-5 align-self-center">
                            Available Points
                        </div>
                        <div class="col-md-8 col-7 hlight-second align-self-center text-end">
                            {{Auth::user()->points.' '. sys_setting('point_code')}}
                        </div>
                    </div>
                </div>
                <div class="ref-item d-blue mb">
                    <div class="row">
                        <div class="col-md-4 col-5 align-self-center">
                            Conversion Rate
                        </div>
                        <div class="col-md-8 col-7 hlight-second align-self-center text-end">
                            {{'1 '. sys_setting('point_code') ." = ".format_price(sys_setting('point_rate'))}}
                        </div>
                    </div>
                </div>
                <div class="ref-item d-blue mb">
                    <div class="row">
                        <div class="col-md-4 col-5 align-self-center">
                            Point Amount
                        </div>
                        <div class="col-md-8 col-7 hlight-second align-self-center text-end ">
                            {{format_amount(Auth::user()->points * sys_setting('point_rate'))}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <div class="card my-3 hidden">
            <div class="card-header d-flex justify-content-between">
            <h5 class="">Bank Accounts</h5><button class="btn btn-primary btn-sm" style="float:right;" data-bs-target="#BankAccountModal" data-bs-toggle="modal">Add Bank Account</button></div>
            <div class="card-body">


                <div class="ref-item d-blue mb">
                    <div class="row">
                        <div class="col-md-4 col-5 align-self-center">
                            Bank
                        </div>
                        <div class="col-md-8 col-7 hlight-second align-self-center text-end">
                            {{get_bank_name(Auth::user()->bank_name)}}
                        </div>
                    </div>
                </div>
                <div class="ref-item d-blue mb">
                    <div class="row">
                        <div class="col-md-4 col-5 align-self-center">
                            Account Name
                        </div>
                        <div class="col-md-8 col-7 hlight-second align-self-center text-end">
                            {{__(Auth::user()->acc_name)}}
                        </div>
                    </div>
                </div>
                <div class="ref-item d-blue mb">
                    <div class="row">
                        <div class="col-md-4 col-5 align-self-center">
                            Account Number
                        </div>
                        <div class="col-md-8 col-7 hlight-second align-self-center text-end">
                            {{(Auth::user()->acc_number)}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="card mt-3 hidden">
    <div class="card-header d-flex justify-content-between">
        <h5 class="">Bank Payouts</h5>
        <button class="btn btn-primary btn-sm" data-bs-target="#withdrawMoneyModal" data-bs-toggle="modal">Withdraw Earnings</button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead class="thead-tr">
                    <tr>
                        <th>ID</th>
                        <th>Amount</th>
                        <th>Charges</th>
                        <th>Account Details</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($payouts as $item)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{format_price($item->amount)}}</td>
                        <td>{{format_price($item->charge)}}</td>
                        <td>
                            <p>Bank: {{get_bank_name(Auth::user()->bank_name)}} </p>
                            <p class="my-0">Name: {{Auth::user()->acc_name}}</p>
                            <p class="mb-0">Number: {{Auth::user()->acc_number}}</p>
                        </td>
                        <td>{!!get_payout_status($item->status)!!}</td>
                        <td>{{show_datetime($item->created_at)}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modals --}}
<div class="modal fade" id="BankAccountModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Withdrawal Account</h5>
                <span class="text-white btn-close" data-bs-dismiss="modal">X</span>
            </div>
            <div class="modal-body">
                <form action="{{route('user.withdraw.bank')}}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="" class="form-label">Select Bank</label>
                        <select name="bank_name" id="bankCode" required class="form-control">
                            <option disabled selected>Select Bank</option>
                            @foreach ($banks as $item)
                                <option value="{{$item->code}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="" class="form-label">Account Number</label>
                        <input type="number" class="form-control" required name="acc_number" id="accNumber">
                    </div>
                    <div class="form-group">
                        <label for="" class="form-label">Account Name</label>
                        <input type="text" class="form-control" readonly name="acc_name" id="accName">
                    </div>
                    <button class="btn btn-primary w-100 mt-3" type="submit">Add Account</button>
                </form>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="withdrawMoneyModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Withdraw Referral Bonus</h5>
                <span class="text-white btn-close" data-bs-dismiss="modal">X</span>
            </div>
            <div class="modal-body">
                <form action="{{route('user.withdraw')}}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="" class="form-label">Withdraw To</label>
                        <select name="withdraw_type" required class="form-control">
                            <option disabled selected>Select Type</option>
                            <option value="wallet">Main Wallet</option>
                            <option value="bank">Bank Account</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="" class="form-label">Amount</label>
                        <input type="number" class="form-control" required name="amount">
                    </div>
                    <button class="btn btn-success w-100" type="submit">Withdraw </button>
                </form>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="withdrawPointModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{sys_setting('point_code')}} Point Withdrawal </h5>
                <span class="text-white btn-close" data-bs-dismiss="modal">X</span>
            </div>
            <div class="modal-body">
                <form action="{{route('user.withdraw.point')}}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="" class="form-label">Points ({{Auth::user()->points .' '.sys_setting('point_code')}})</label>
                        <input type="number" class="form-control" min="{{sys_setting('point_minimum')}}" required name="points" id="pointIpt" data-rate="{{sys_setting('point_rate')}}">
                    </div>
                    <div class="form-group">
                        <label for="" class="form-label">You get ({{get_setting('currency')}})</label>
                        <input type="number" class="form-control" readonly id="getAmount"">
                    </div>
                    <div class="form-group">
                        <label for="" class="form-label">Withdraw To</label>
                        <select name="withdraw_type" required class="form-control">
                            <option value="wallet" selected>Main Wallet</option>
                        </select>
                    </div>
                    <button class="btn btn-success w-100" type="submit">Withdraw </button>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection

@section('breadcrumb')
<div class="card dc-dash">
    <div class="row">
        <div class="col-lg-7 col-md-9 col-12">
            <div class="py-3 px-5">
                <div class="dch-title">
                   @yield('title')
                </div>
                <div class="dch-text">
                    Refer your friends and earn.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .form-control{

    }
</style>
@endsection

@push('scripts')
<script>
    document.getElementById('pointIpt').addEventListener('input', function() {
        var points = parseFloat(this.value) || 0;
        var rate = parseFloat(this.getAttribute('data-rate')) || 0;
        var amount = points * rate;
        document.getElementById('getAmount').value = amount.toFixed(2);
    });
    $('#accNumber').on('keyup', function () {
        validateAccount();
    });

    $('#bankCode').on('change', function () {
        validateAccount();
    });

    function validateAccount() {
        const accountNumber = $('#accNumber').val();
        const bankCode = $('#bankCode').val();

        if (accountNumber.length === 10) {
            // Validate the account number
            $.ajax({
                url: `https://api.paystack.co/bank/resolve?account_number=${accountNumber}&bank_code=${bankCode}`,
                headers: {
                    'Authorization': 'Bearer {{ env('PAYSTACK_SECRET_KEY') }}', // Assuming your environment variable is correctly loaded
                },
                success: function(response) {
                    console.log(response);

                    if (response.status === true) {
                        $('#accName').val(response.data.account_name);
                    } else {
                        showErrorMessage("Invalid account number. Please try again.");
                    }
                },
                error: function(error) {
                    showErrorMessage("Invalid Bank and account number. Please try again.");
                }
            });
        }
    }

    function showErrorMessage(message) {
        Snackbar.show({
            backgroundColor: '#e3342f',
            pos: 'top-right',
            text: message,
        });
    }


</script>
@endpush
