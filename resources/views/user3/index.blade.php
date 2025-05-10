@extends('user3.layouts.master')
@section('title', 'Dashboard')

@section('content')
@php
    $user = Auth::user();
@endphp
<div class="row my-4 admin-fa_icon">

    <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
        <div class="card   ">
            <div class="card-body">
                <div class="d-flex d-lg-flex d-md-block align-items-center justify-content-between">
                    <div>
                        <div class="d-inline-flex align-items-center">
                            <h3 class=" mb-1 font-weight-medium">{{format_price(Auth::user()->balance)}}
                            </h3>
                        </div>
                        <p class="text-muted font-weight-normal mb-0 w-100 text-truncate">Your Balance</p>
                    </div>

                    <div class=" mt-md-3 mt-lg-0">
                        <span class="opacity-7 primary-color"><i class="fa-duotone fa-dollar-sign fa-2x"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3" style="display:none;">
        <div class="card  ">
            <div class="card-body">
                <div class="d-flex d-lg-flex d-md-block align-items-center justify-content-between">
                    <div>
                        <h3 class="mb-1 w-100 text-truncate font-weight-medium">{{ format_price($user->transactions->where('status', 1)->where('type',2)->sum('amount')) }}</h3>
                        <p class="text-muted font-weight-normal mb-0 w-100 text-truncate">Total Spent </p>
                    </div>

                    <div class=" mt-md-3 mt-lg-0">
                        <span class="opacity-7 primary-color"><i class="fas fa-exchange-alt fa-2x"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
        <div class="card  ">
            <div class="card-body">
                <div class="d-flex d-lg-flex d-md-block align-items-center justify-content-between">
                    <div>
                        <div class="d-inline-flex align-items-center">
                            <h2 class="mb-1 font-weight-medium">{{ format_price($user->deposits->where('status',1)->sum('amount')) }} </h2>
                        </div>
                        <p class="text-muted font-weight-normal mb-0 w-100 text-truncate">Total Deposit</p>
                    </div>

                    <div class=" mt-md-3 mt-lg-0">
                        <span class="opacity-7 primary-color"><i class="fa-duotone fa-credit-card fa-2x"></i></span>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
        <div class="card  ">
            <div class="card-body">
                <div class="d-flex d-lg-flex d-md-block align-items-center justify-content-between">
                    <div>
                        <h2 class=" mb-1 font-weight-medium">{{ $user->transactions->count() }}</h2>
                        <p class="text-muted font-weight-normal mb-0 w-100 text-truncate">Total Transactions</p>
                    </div>

                    <div class="mt-md-3 mt-lg-0">
                        <span class="opacity-7 primary-color"><i class="fa-duotone fa-arrow-right-arrow-left fa-2x"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
        <div class="card  ">
            <div class="card-body">
                <div class="d-flex d-lg-flex d-md-block align-items-center justify-content-between">
                    <div>
                        <div class="d-inline-flex align-items-center">
                            <h2 class="mb-1 font-weight-medium">{{ $user->orders->count() }}</h2>
                        </div>
                        <p class="text-muted font-weight-normal mb-0 w-100 text-truncate">Total Orders</p>
                    </div>

                    <div class=" mt-md-3 mt-lg-0">
                        <span class="opacity-7 primary-color"><i class="fa-duotone fa-loader fa-2x"></i></span> 
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3" style="display:none;">
        <div class="card  ">
            <div class="card-body">
                <div class="d-flex d-lg-flex d-md-block align-items-center justify-content-between">
                    <div>
                        <h2 class="mb-1 font-weight-medium">{{ ($user->orders->where('status','processing')->count()) }}</h2>
                        <p class="text-muted font-weight-normal mb-0 w-100 text-truncate">Processing Orders</p>
                    </div>

                    <div class=" mt-md-3 mt-lg-0">
                        <span class="opacity-7 primary-color"><i class="fab fa-first-order fa-2x"></i></span>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3" style="display:none;">
        <div class="card  ">
            <div class="card-body">
                <div class="d-flex d-lg-flex d-md-block align-items-center justify-content-between">
                    <div>
                        <h2 class=" mb-1 font-weight-medium">{{ ($user->orders->where('status','pending')->count()) }}</h2>
                        <p class="text-muted font-weight-normal mb-0 w-100 text-truncate">Pending Orders</p>
                    </div>

                    <div class=" mt-md-3 mt-lg-0">
                        <span class="opacity-7 primary-color"><i class="fas fa-spinner fa-2x"></i></span>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3" style="display:none;">
        <div class="card  ">
            <div class="card-body">
                <div class="d-flex d-lg-flex d-md-block align-items-center justify-content-between">
                    <div>
                        <h2 class="mb-1 font-weight-medium">{{ ($user->orders->where('status','completed')->count()) }}</h2>
                        <p class="text-muted font-weight-normal mb-0 w-100 text-truncate">Completed Orders</p>
                    </div>

                    <div class=" mt-md-3 mt-lg-0">
                        <span class="opacity-7 primary-color"><i class="fas fa-check fa-2x"></i></span>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


<div class="card mb-3">
    <div class="card-body">
        <div class="row align-items-center">
        <div class="col-md-4">
      <h5 class="fw-bold">Refer & Earn</h5>
      <p>Refer your friends and get paid a commision for all their transactions.</p>
      </div><div class="col-md-2"></div>
      <div class="col-md-6">
      <div class="input-group mb-3 form-group">
        <span class="input-group-text btn btn-"><i class="fa fa-link"></i></span>
        <input class="form-control" type="text" placeholder="{{route('signup').'/?ref='.Auth::user()->username}}" value="{{route('signup').'/?ref='.Auth::user()->username}}">
        <button class="btn btn-primary input-group-text" onclick="copyFunction('{{route('signup').'/?ref='.Auth::user()->username}}')"><i class="fa-duotone fa-copy"></i> </button>
      </div></div>
    </div></div>
  </div>


{{-- Latest Transactions --}}
<div class="card" style="display:none;">
    <div class="card-header d-flex justify-content-between">
        <h5>Latest Transaction</h5>
    </div>
   <div class="card-body table-responsive">
    <table class="table app-mtable" id="datatable">
        <thead class="white">
            <tr class="thead-tr">
                <th>#</th>
                <th class="nowrap">Type</th>
                <th class="nowrap">Service</th>
                <th class="nowrap">TRX Code</th>
                <th class="nowrap">Date</th>
                <th class="nowrap">Amount</th>
                <th class="nowrap">Status</th>
                <th >Message</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($trx as $key => $item)
            <tr class="app-block">
                <td class="app-col" data-title="#">{{$key + 1}}</td>
                <td class="app-col" data-title="Type">{!! get_trx_type($item->type) !!}</td>
                <td class="app-col" data-title="Service">
                    <span class="order-status os-processing">{{$item->service}}</span>
                </td>
                <td class="app-col" data-title="TRX Code">{{$item->code}}</td>
                <td class="app-col" data-title="Date">{{show_datetime($item->created_at)}}</td>
                <td class="app-col" data-title="Amount">{{format_price($item->amount)}}</td>
                <td class="app-col" data-title="Status">
                    @if($item->status == 1)
                        <span class="badge bg-success">successful</span>
                    @elseif ($item->status == 2)
                        <span class="badge bg-warning">pending</span>
                    @elseif ($item->status == 3)
                        <span class="badge bg-danger">canceled</span>
                    @elseif ($item->status == 4)
                        <span class="badge bg-info">reversed</span>
                    @endif
                </td>
                <td class="app-col" data-title="Message">{{$item->message}}</td>
            </tr>

        @endforeach
        </tbody>
    </table>
   </div>
   
   
   
</div>
@endsection
@section('styles')
<style>
    .card{
        margin-bottom: 15px;
    }
    

</style>
@endsection
