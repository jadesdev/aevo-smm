@extends('admin.layouts.master')
@section('title', 'User Details')

@section('content')
<div class="row">
    <div class="col-lg-3 col-sm-6">
        <div class="d-card border border-primary">
            <a href="#" data-toggle="modal" data-target="#fundwallet" class=" btn btn-block btn-primary">Manage Balance
            </a>
            <div class="d-card-body dash">
                <div class="media align-items-center">
                <div class="media-body text-left">
                    {{-- <span class="text-info">Balance</span> --}}
                    <h4 class="mb-0 text-primary">{{ format_price($user->balance) }}</h4>
                </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6">
        <div class="d-card border border-info">
            <a href="#" class=" btn btn-block btn-info">Referral Balance
            </a>
            <div class="d-card-body dash">
                <div class="media align-items-center">
                    <div class="media-body text-left">
                        <h4 class="mb-0 text-info">{{ format_price($user->bonus) }}</h4>
                        {{-- <span class="text-info">Referral Bonus</span> --}}
                    </div>
                    <div class="align-self-center icon-lg">
                        <i class="fas fa-users text-info"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6">
        <div class="d-card border border-dark">
            <a href="{{route('admin.deposit')}}?search={{$user->username}}" class="btn btn-block btn-dark">Total Deposits
            </a>
            <div class="d-card-body dash">
                <div class="media align-items-center">
                <div class="media-body text-left">
                    <h4 class="mb-0 text-">{{ format_price($user->deposits->where('status',1)->sum('amount')) }}</h4>
                    {{-- <span class="text-dark">Total Deposits</span> --}}
                </div>
                <div class="align-self-center icon-lg">
                    <i class="fas fa-money-bill text-dark"></i>
                </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6">
        <div class="d-card border border-warning">
            <a href="{{route('admin.transactions')}}?search={{$user->username}}" class="btn-block btn btn-warning">
                Total Transactions
            </a>
            <div class="d-card-body dash">
                <div class="media align-items-center">
                <div class="media-body text-left">
                    <h4 class="mb-0 text-warning">{{ $user->transactions->where('status',1)->count()}}</h4>
                    {{-- <span class="text-warning">Total Transactions</span> --}}
                </div>
                <div class="align-self-center icon-lg d-none d-md-block">
                    <i class="fas fa-exchange-alt text-warning"></i>
                </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6">
        <div class="d-card border border-danger">
            <a href="#" data-bs-toggle="modal" class="bg-danger btn btn-block text-white">Total Spent
            </a>
            <div class="d-card-body dash">
                <div class="media align-items-center">
                <div class="media-body text-left">
                    {{-- <span class="text-danger">Debit</span> --}}
                    <h4 class="mb-0 text-danger">{{ format_price($user->transactions->where('status', 1)->where('type',2)->sum('amount')) }}</h4>
                </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-6">
        <div class="d-card border border-primary">
            <a href="{{route('admin.orders.index')}}?search={{$user->username}}" class=" btn btn-block btn-primary">Total Orders
            </a>
            <div class="d-card-body dash">
                <div class="media align-items-center">
                <div class="media-body text-primary">
                    {{-- <span class="text-success">Credit</span> --}}
                    <h4 class="mb-0 text-primary">{{ $user->orders->count() }}</h4>
                </div>
                <div class="align-self-center icon-lg">
                    <i class="fas fa-shopping-cart text-primary"></i>
                </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="d-card border border-warning">
            <a href="{{route('admin.orders.pending')}}?search={{$user->username}}" class=" btn btn-block btn-warning">Pending Orders
            </a>
            <div class="d-card-body dash">
                <div class="media align-items-center">
                <div class="media-body text-left">
                    {{-- <span class="text-success">Credit</span> --}}
                    <h4 class="mb-0 text-warning">{{ ($user->orders->where('status','pending')->count()) }}</h4>
                </div>
                <div class="align-self-center icon-lg">
                    <i class="fas fa-refresh text-warning"></i>
                </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="d-card border border-info">
            <a href="{{route('admin.orders.processing')}}?search={{$user->username}}" class=" btn btn-block btn-info">Processing Orders
            </a>
            <div class="d-card-body dash">
                <div class="media align-items-center">
                <div class="media-body text-left">
                    {{-- <span class="text-success">Credit</span> --}}
                    <h4 class="mb-0 text-info">{{ ($user->orders->where('status','processing')->count()) }}</h4>
                </div>
                <div class="align-self-center icon-lg">
                    <i class="fas fa-spinner text-info"></i>
                </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="d-card border border-success">
            <a href="{{route('admin.orders.completed')}}?search={{$user->username}}" class=" btn btn-block btn-success">Completed Orders
            </a>
            <div class="d-card-body dash">
                <div class="media align-items-center">
                <div class="media-body text-left">
                    {{-- <span class="text-success">Credit</span> --}}
                    <h4 class="mb-0 text-success">{{ ($user->orders->where('status','completed')->count()) }}</h4>
                </div>
                <div class="align-self-center icon-lg">
                    <i class="fas fa-check-circle text-success"></i>
                </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="d-card border border-info">
            <a href="{{route('admin.orders.inprogress')}}?search={{$user->username}}" class=" btn btn-block btn-info">In Progress Orders
            </a>
            <div class="d-card-body dash">
                <div class="media align-items-center">
                <div class="media-body text-left">
                    {{-- <span class="text-success">Credit</span> --}}
                    <h4 class="mb-0 text-info">{{ ($user->orders->where('status','inprogress')->count()) }}</h4>
                </div>
                <div class="align-self-center icon-lg">
                    <i class="fas fa-refresh text-info"></i>
                </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="d-card border border-danger">
            <a href="{{route('admin.orders.canceled')}}?search={{$user->username}}" class=" btn btn-block bg-danger text-white">Cancelled Orders
            </a>
            <div class="d-card-body dash">
                <div class="media align-items-center">
                <div class="media-body text-left">
                    {{-- <span class="text-success">Credit</span> --}}
                    <h4 class="mb-0 text-danger">{{ ($user->orders->where('status','canceled')->count()) }}</h4>
                </div>
                <div class="align-self-center icon-lg">
                    <i class="fas fa-times-circle text-danger"></i>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="d-card">
    <h5 class="card-header fw-bold">{{$user->name()}} Details</h5>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="d-card">
            <div class="d-card-body">
                <p class="clearfix">
                    <span class="float-left">Username</span>
                    <span class="float-right font-weight-bold"><a href="#">{{ $user->username }}</a></span>
                </p>
                <p class="clearfix">
                    <span class="float-left">Email</span>
                    <span class="float-right text-muted">{{ $user->email }}</span>
                </p>
                <p class="clearfix">
                    <span class="float-left">Phone</span>
                    <span class="float-right text-muted">{{ $user->phone ?: 'Not available'}}</span>
                </p>
                <p class="clearfix">
                    <span class="float-left">Balance</span>
                    <span class="float-right text-muted">{{ format_price($user->balance) }}</span>
                </p>
                <p class="clearfix">
                    <span class="float-left">Ref Balance</span>
                    <span class="float-right text-muted">{{ format_price($user->bonus) }}</span>
                </p>
                <p class="clearfix">
                    <span class="float-left">Refer By</span>
                    <span class="float-right text-muted">{{isset($user->refer->username) ? $user->refer->username : "None"}}</span>
                </p>
                <p class="clearfix">
                    <span class="float-left">Joined</span>
                    <span class="float-right text-muted">{{show_datetime($user->created_at)}}</span>
                </p>
                <p class="clearfix">
                    <span class="float-left">Status</span>
                    <span class="float-right text-muted">
                        @if($user->status == 1)
                        <span class="badge badge-pill badge-success">Verified</span> @elseif($user->status == 2)
                        <span class="badge badge-pill badge-warning">Unverified</span> @else
                        <span class="badge badge-pill badge-danger">Deactivated</span>
                        @endif
                    </span>
                </p>
                <div class="border border-primary bg-primary text-white p-2 mb-2">
                    <h6 class="fw-bold">Actions</h6>

                </div>
                <div class="btn-list">
                    <a href="#" data-toggle="modal" data-target="#fundwallet" class="btn btn-primary">Manage Balance</a>
                    <a href="{{route('admin.deposit')}}?search={{$user->username}}" class="btn btn-primary">Deposits</a>
                    <a href="{{route('admin.orders.index')}}?search={{$user->username}}" class="btn btn-primary">Orders</a>
                    <a href="{{route('admin.transactions')}}?search={{$user->username}}" class="btn btn-primary">Transactions</a>
                    <a href="#" data-toggle="modal" data-target="#sendEmail" class="btn btn-primary">Send Email</a>
                    <a href="{{route('admin.users.login', encrypt($user->id))}}" target="_blank" class="btn btn-primary">Login as User</a>
                </div>

            </div>
        </div>

    </div>
    <div class="col-md-8">
        <div class="d-card">
            <div class="d-card-body">
                <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="row">
                    @csrf
                    <div class="form-group col-md-6">
                        <label class="form-label" for="name">@lang('First Name')</label>
                        <input type="text" placeholder="@lang('First Name')" id="fname" name="fname" class="form-control" value="{{$user->fname}}" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label" for="name">@lang('Last Name')</label>
                        <input type="text" placeholder="@lang('Last Name')" id="lname" name="lname" class="form-control" value="{{$user->lname}}" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label" for="email">@lang('Email Address')</label>
                        <input type="text" placeholder="@lang('Email Address')" id="email" name="email" class="form-control" value="{{$user->email}}" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label" >@lang('Username')</label>
                        <input type="text" placeholder="@lang('Username')" name="username" class="form-control" value="{{$user->username}}">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label" >@lang('Phone')</label>
                        <input type="text" placeholder="@lang('Phone')" name="phone" class="form-control" value="{{$user->phone}}">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label" >Address</label>
                        <input type="text" placeholder="Address" name="address" class="form-control" value="{{$user->address}}">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label" for="password">@lang('Password')</label>
                        <input type="password" placeholder="@lang('Password')" id="password" name="password" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label" >Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="1" @if($user->status == 1) selected @endif>Active</option>
                            <option value="2" @if($user->status == 2) selected @endif>Unverified</option>
                            <option value="3" @if($user->status == 3) selected @endif>Deactivated</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label" >User Role</label>
                        <select name="user_role" id="type" class="form-control ">
                            <option value="user" @if($user->user_role == 'user') selected @endif>User</option>
                            <option value="admin" @if($user->user_role == 'admin') selected @endif>ADMIN</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label" >API Key</label>
                        <input type="text" disabled class="form-control" value="{{$user->api_token}}">
                    </div>

                    <div class="col-12 mb-0">
                        <button type="submit" class="btn btn-block btn-primary w-100">@lang('Save')</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

{{-- Send Email Modal --}}
<div id="sendEmail" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Send Email to {{$user->username}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>

            </div>
            <div class="modal-body">
                <form method="POST" action="{{route('admin.users.sendmail', $user->id)}}" enctype="multipart/form-data" >
                   @csrf
                    <input type="hidden" name="id" value="{{$user->id}}">
                    <div class="form-group row">
                        <label class="form-label">Subject </label>
                        <input type="text" name="subject" required class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Message </label>
                        <textarea name="message" id="tiny1" cols="30" class="form-control" rows="10"></textarea>
                    </div>
                    <div class="form-group mb-0">
                        <button type="submit" class="btn-block btn btn-primary"><span> Send Email </span></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="fundwallet" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel"><strong><i class="ti ti-wallet"></i> Fund Wallet</strong></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>

            </div>
            <div class="modal-body">
                <span class="mt-0 mb-2 fw-bold">User Balance : {{format_price($user->balance)}}</span>
                <form method="POST" action="{{route('admin.users.balance', $user->id)}}" enctype="multipart/form-data" >
                   @csrf
                    <input type="hidden" name="id" value="{{$user->id}}">
                    <div class="form-group row">
                        <label class="form-label col-sm-3">Select Option</label>
                        <div class="col-sm-9">
                            <select class="form-select form-control js-select2" name="type">
                                <option value="1">Credit</option>
                                <option value="0">Debit</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 form-label">Amount </label>
                        <div class="col-sm-9">
                            <input type="number" name="amount" step="any" class="form-control" placeholder="Amount" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Message </label>
                        <input type="text" name="message" class="form-control" placeholder="Write Message to user.." required>
                    </div>
                    <div class="form-group mb-0">
                        <button type="submit" class="btn-block btn btn-primary"><span> Update Balance </span></button>
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
        <div class="col-lg-7 col-md-9 col-12">
            <div class="py-3 px-5">
                <div class="dch-title">
                   @yield('title')
                </div>
                <div class="dch-text">
                    Manage User accounts.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('styles')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{static_asset('summer/summernote-lite.css')}}">
<style>
    .d-card{
        margin-bottom: 10px;
    }
    .dash{
        padding: 10px !important;
    }
    .btn-list {
        margin-left: -8px;
        margin-bottom: -12px
    }

    .btn-list .btn {
        margin-bottom: 12px;
        margin-left: 8px;
    }
</style>
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script src="{{ static_asset('summer/summernote-lite.js') }}"></script>
<script>
$(document).ready(function() {
    $('#tiny1').summernote({
        height:200
    });
});
</script>
@endpush
