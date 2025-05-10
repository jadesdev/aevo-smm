@extends('user.layouts.master')
@section('title', 'Listing Wallet')

@section('content')
<div class="row">
    <div class="col-lg-12 col-12 mb-5 mb-lg-0">
        <div class="orders-btn py-3">
            <ul class="nav nav-pills app-ord-nav">
                <li class="mr-2">
                    <a class="" href="{{route('user.listings.deals')}}"><i class="fas fa-filter mr-1"></i>My Listings</a>
                </li>
                <li class="mr-2">
                    <a class="" href="{{route('user.listings.my_account')}}"><i class="fas fa-file-import mr-1"></i>Bought Accounts</a>
                </li>
                <li class="mr-2">
                    <a class="active" href="{{route('user.listings.wallet')}}"><i class="fas fa-wallet mr-1"></i>Wallet</a>
                </li>
                <li class="pull-right search mr-2">

                </li>
            </ul>
        </div>
    </div>
    <div class="col-md-6">
        <div class="d-card" >
            <div class="card-header d-flex justify-content-between">
                <h5 class="">Wallet Details</h5>
                <button class="btn btn-primary btn-sm" data-target="#withdrawMoneyModal" data-toggle="modal">Withdraw Earnings</button>
            </div>
            <div class="d-card-body">
                <div class="ref-item d-blue mb">
                    <div class="row">
                        <div class="col-md-4 col-5 align-self-center">
                            Main Balance
                        </div>
                        <div class="col-md-8 col-7 hlight-second align-self-center text-right">
                            {{format_price(Auth::user()->balance)}}
                        </div>
                    </div>
                </div>
                <div class="ref-item d-blue mb">
                    <div class="row">
                        <div class="col-md-4 col-5 align-self-center">
                            Affiliate Balance
                        </div>
                        <div class="col-md-8 col-7 hlight-second align-self-center text-right">
                            {{format_price(Auth::user()->bonus)}}
                        </div>
                    </div>
                </div>
                <div class="ref-item d-blue mb">
                    <div class="row">
                        <div class="col-md-4 col-5 align-self-center">
                            Deals Balance
                        </div>
                        <div class="col-md-8 col-7 hlight-second align-self-center text-right">
                            {{format_price(Auth::user()->deal_wallet)}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="d-card" >
            <div class="card-header d-flex justify-content-between">
                <h5 class="">Bank Accounts</h5><button class="btn btn-primary btn-sm" style="float:right;" data-target="#BankAccountModal" data-toggle="modal">Add Bank Account</button>
            </div>
            <div class="d-card-body">


                <div class="ref-item d-blue mb">
                    <div class="row">
                        <div class="col-md-4 col-5 align-self-center">
                            Bank
                        </div>
                        <div class="col-md-8 col-7 hlight-second align-self-center text-right">
                            {{get_bank_name(Auth::user()->bank_name)}}
                        </div>
                    </div>
                </div>
                <div class="ref-item d-blue mb">
                    <div class="row">
                        <div class="col-md-4 col-5 align-self-center">
                            Account Name
                        </div>
                        <div class="col-md-8 col-7 hlight-second align-self-center text-right">
                            {{__(Auth::user()->acc_name)}}
                        </div>
                    </div>
                </div>
                <div class="ref-item d-blue mb">
                    <div class="row">
                        <div class="col-md-4 col-5 align-self-center">
                            Account Number
                        </div>
                        <div class="col-md-8 col-7 hlight-second align-self-center text-right">
                            {{(Auth::user()->acc_number)}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="d-card mt-3">
            <div class="card-header d-flex justify-content-between">
                <h5 class="">Bank Payouts</h5>
            </div>
            <div class="d-card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="thead">
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
                                <td>
                                    @if ($item->status == 1)
                                        <span class="badge bg-success">@lang('Completed')</span>
                                    @elseif ($item->status == 2)
                                        <span class="badge bg-warning">@lang('processing')</span>
                                    @elseif ($item->status == 3)
                                        <span class="badge bg-danger">@lang('rejected')</span>
                                    @endif
                                </td>

                                <td>{{show_datetime($item->created_at)}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- Modals --}}
<div class="modal fade" id="BankAccountModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Withdrawal Account</h5>
                <span class="text-white close" data-dismiss="modal">X</span>
            </div>
            <div class="modal-body">
                <form action="{{route('user.withdraw.bank')}}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="" class="form-label">Select Bank</label>
                        <select name="bank_name" id="bankCode" required class="form-control">
                            <option disabled selected>Select Bank</option>
                            @foreach ($banks as $item)
                                <option value="{{$item->code}}" @if(Auth::user()->bank_name == $item->code) selected @endif >{{$item->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="" class="form-label">Account Number</label>
                        <input type="number" class="form-control" value="{{old('acc_number', Auth::user()->acc_number )}}" required name="acc_number" id="accNumber">
                    </div>
                    <div class="form-group">
                        <label for="" class="form-label">Account Name</label>
                        <input type="text" class="form-control" value="{{old('acc_name', Auth::user()->acc_name )}}" readonly name="acc_name" id="accName">
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
                <h5 class="modal-title">Withdraw Money</h5>
                <span class="text-white close" data-dismiss="modal">X</span>
            </div>
            <div class="modal-body">
                <form action="{{route('user.listings.withdraw')}}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="" class="form-label">Balance</label>
                        <input type="text" disabled class="form-control" value="{{format_price(Auth::user()->deal_wallet)}}">
                    </div>
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
@endsection

@section('breadcrumb')
<div class="d-card dc-dash">
    <div class="row">
        <div class="col-lg-7 col-md-9 col-12">
            <div class="py-3 px-5">
                <div class="dch-title">
                   @yield('title')
                </div>
                <div class="dch-text">
                    Buy your social media accounts with us. <a href="{{route('user.listings.add')}}">Start Selling. </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
