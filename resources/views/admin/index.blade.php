@extends('admin.layouts.master')
@section('title', 'Admin Dashboard')
@section('content')
@php
    $userz = \App\Models\User::orderByDesc('id')->limit(10)->get();
    $users = \App\Models\User::all();
    $orders = \App\Models\Order::all();
    $orderz = \App\Models\Order::orderByDesc('id')->limit(10)->get();
    $transactions = \App\Models\Transaction::all();
    $deposits = \App\Models\Deposit::all();

    function calculateTotal($days)
    {
        $orders = \App\Models\Order::all();
        $status = ['completed', 'processing', 'inprogress'];
        $filteredOrders = $orders->filter(function ($order) use ($status, $days) {
            return in_array($order->status, $status) && $order->created_at->isBetween(now()->subDays($days), now());
        });

        $totalPrice = $filteredOrders->sum('profit');
        return $totalPrice;
    }
    $todayProfit = calculateTotal(1);
    $profit30 = calculateTotal(30);
    $profit7 = calculateTotal(7);
    $profitAll = $orders->whereIn('status', ['completed', 'processing','inprogress'])->sum('profit');

@endphp
<div class="row">
    <div class="col-lg-3 col-sm-6">
        <div class="d-card border border-success">
            <a href="#" class=" btn btn-block btn-success">Total Users
            </a>
            <div class="d-card-body dash">
                <div class="media align-items-center">
                <div class="media-body text-left">
                    {{-- <span class="text-info">Balance</span> --}}
                    <h4 class="mb-0 text-success">{{ ($users->count()) }}</h4>
                </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6">
        <div class="d-card border border-primary">
            <a href="#" class=" btn btn-block btn-primary">User Balance
            </a>
            <div class="d-card-body dash">
                <div class="media align-items-center">
                <div class="media-body text-left">
                    {{-- <span class="text-info">Balance</span> --}}
                    <h4 class="mb-0 text-primary">{{ format_price($users->sum('balance')) }}</h4>
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
                        <h4 class="mb-0 text-info">{{ format_price($users->sum('bonus')) }}</h4>
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
        <div class="d-card border border-warning">
            <a href="{{route('admin.deposit')}}" class="btn-block btn btn-warning text-white">
                Deposits Today
            </a>
            <div class="d-card-body dash">
                <div class="media align-items-center">
                <div class="media-body text-left">
                    <h4 class="mb-0 text-warning"> {{format_price(App\Models\Deposit::whereYear('updated_at', date('Y'))->whereMonth('updated_at', date('m'))->whereDay('updated_at', date('d'))->where('status', 1)->sum('amount'))}}</h4>
                </div>
                <div class="align-self-center icon-lg d-none d-md-block">
                    <i class="fas fa-money-bill text-warning"></i>
                </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6">
        <div class="d-card border border-dark">
            <a href="{{route('admin.deposit')}}" class="btn btn-block btn-dark">Total Deposits
            </a>
            <div class="d-card-body dash">
                <div class="media align-items-center">
                <div class="media-body text-left">
                    <h4 class="mb-0 text-">{{ format_price($deposits->where('status',1)->sum('amount')) }}</h4>
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
            <a href="#" data-bs-toggle="modal" class="bg-warning btn btn-block text-white">Profits Today
            </a>
            <div class="d-card-body dash">
                <div class="media align-items-center">
                <div class="media-body text-left">
                    <h4 class="mb-0 text-warning"> {{format_price( $todayProfit)}} </h4>
                </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6">
        <div class="d-card border border-info">
            <a href="#" data-bs-toggle="modal" class="bg-info btn btn-block text-white">7Days Profits
            </a>
            <div class="d-card-body dash">
                <div class="media align-items-center">
                <div class="media-body text-left">
                    <h4 class="mb-0 text-info"> {{format_price( $profit7)}} </h4>
                </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6">
        <div class="d-card border border-primary">
            <a href="#" data-bs-toggle="modal" class="bg-primary btn btn-block text-white">30Days Profits
            </a>
            <div class="d-card-body dash">
                <div class="media align-items-center">
                <div class="media-body text-left">
                    <h4 class="mb-0 text-primary"> {{format_price( $profit30)}} </h4>
                </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6">
        <div class="d-card border border-success">
            <a href="#" data-bs-toggle="modal" class="bg-success btn btn-block text-white">All Profits
            </a>
            <div class="d-card-body dash">
                <div class="media align-items-center">
                <div class="media-body text-left">
                    <h4 class="mb-0 text-success"> {{format_price( $profitAll)}} </h4>
                </div>
                </div>
            </div>
        </div>
    </div>


    <div class="col-md-3 col-6">
        <div class="d-card border border-primary">
            <a href="{{route('admin.orders.index')}}" class=" btn btn-block btn-primary">Total Orders
            </a>
            <div class="d-card-body dash">
                <div class="media align-items-center">
                <div class="media-body text-primary">
                    {{-- <span class="text-success">Credit</span> --}}
                    <h4 class="mb-0 text-primary">{{ $orders->count() }}</h4>
                </div>
                <div class="align-self-center icon-lg">
                    <i class="fas fa-shopping-cart text-primary"></i>
                </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="d-card border border-success">
            <a href="{{route('admin.orders.index')}}" class="btn-block btn btn-success text-white">
                Orders Today
            </a>
            <div class="d-card-body dash">
                <div class="media align-items-center">
                <div class="media-body text-left">
                    <h4 class="mb-0 text-success"> {{(App\Models\Order::whereYear('updated_at', date('Y'))->whereMonth('updated_at', date('m'))->whereDay('updated_at', date('d'))->count())}}</h4>
                </div>
                <div class="align-self-center icon-lg d-none d-md-block">
                    <i class="fas fa-money-bill text-success"></i>
                </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="d-card border border-warning">
            <a href="{{route('admin.orders.pending')}}" class=" btn btn-block btn-warning">Pending Orders
            </a>
            <div class="d-card-body dash">
                <div class="media align-items-center">
                <div class="media-body text-left">
                    {{-- <span class="text-success">Credit</span> --}}
                    <h4 class="mb-0 text-warning">{{ ($orders->where('status','pending')->count()) }}</h4>
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
            <a href="{{route('admin.orders.processing')}}" class=" btn btn-block btn-info">Processing Orders
            </a>
            <div class="d-card-body dash">
                <div class="media align-items-center">
                <div class="media-body text-left">
                    {{-- <span class="text-success">Credit</span> --}}
                    <h4 class="mb-0 text-info">{{ ($orders->where('status','processing')->count()) }}</h4>
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
            <a href="{{route('admin.orders.completed')}}" class=" btn btn-block btn-success">Completed Orders
            </a>
            <div class="d-card-body dash">
                <div class="media align-items-center">
                <div class="media-body text-left">
                    {{-- <span class="text-success">Credit</span> --}}
                    <h4 class="mb-0 text-success">{{ ($orders->where('status','completed')->count()) }}</h4>
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
            <a href="{{route('admin.orders.inprogress')}}" class=" btn btn-block btn-info">In Progress Orders
            </a>
            <div class="d-card-body dash">
                <div class="media align-items-center">
                <div class="media-body text-left">
                    {{-- <span class="text-success">Credit</span> --}}
                    <h4 class="mb-0 text-info">{{ ($orders->where('status','inprogress')->count()) }}</h4>
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
            <a href="{{route('admin.orders.canceled')}}" class=" btn btn-block bg-danger text-white">Cancelled Orders
            </a>
            <div class="d-card-body dash">
                <div class="media align-items-center">
                <div class="media-body text-left">
                    {{-- <span class="text-success">Credit</span> --}}
                    <h4 class="mb-0 text-danger">{{ ($orders->where('status','canceled')->count()) }}</h4>
                </div>
                <div class="align-self-center icon-lg">
                    <i class="fas fa-times-circle text-danger"></i>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="d-card my-3" style="display:none;">
    <div class="d-card-body">
        <label for="" class="form-label">Cron Job URL</label>
        <input type="text" class="form-control" value="{{route('cron')}}">
    </div>
</div>

<div class="d-card my-4">
    <h5 class="fw-bold card-header">Recent Orders</h5>
    <div class="d-card-body table-responsive">
        <table class="table app-mtable">
            <thead>
                <tr class="thead-tr">
                    <th>ID</th>
                    {{-- <th class="nowrap">API ID</th> --}}
                    <th class="nowrap">User</th>
                    <th>Date</th>
                    <th class="nowrap">Price</th>
                    <th class="nowrap">Order Details</th>
                    <th class="nowrap" style="min-width: 100px;">Status</th>
                    <th class="nowrap">Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($orderz as $item)
                <tr class="app-block">
                    <td class="app-col" data-title="ID">{{$item->id}}</td>
                    <td class="app-col" data-title="User">
                        <p class="mr-2 my-0">Email: {{$item->user->email ?? ""}}</p>
                        <p class="my-0">User: {{$item->user->username ?? ""}}</p>
                    </td>
                    <td class="app-col" data-title="Date">{{show_datetime2($item->created_at)}}</td>
                    <td class="app-col" data-title="Price">{{format_price($item->price)}}</td>
                    <td class="app-col" data-title="Order Details">
                        <div class="rows">
                            <p class="mb-0 mr-2 ">Service: {{$item->service->name?? "None"}}</p>
                            <p class="mb-0 mr-2 "> Provider: {{$item->provider->name ?? "None"}}</p>
                            <p class="mb-0 mr-2 "> APICode: {{$item->api_order_id}}</p>
                            <p class="my-0 mr-2" >Quantity: {{$item->quantity}} </p>
                            <p class="mb-0 mr-2"> Start Counter: {{$item->start_counter}}</p>
                            <p class="mb-0 mr-2"> Remain: {{$item->remain}}</p>
                            <p class="my-0 mr-2">Link: <a target="_blank" href="{{$item->link}}">{{text_trim($item->link, 50)}}</a></p>
                        </div>

                    </td>
                    <td class="app-col" data-title="Status">{!!get_order_status($item->status)!!} </td>
                    <td class="app-col" data-title="Actions">
                        <a href="{{ route('admin.orders.details', $item->id) }}" title="Details"
                            class="btn btn-sm btn-outline-primary ">
                            <i class="fa fa-edit"></i>
                            {{-- @lang('Details') --}}
                        </a>
                        <a href="{{ route('admin.orders.delete', $item->id) }}"
                            class="btn btn-sm btn-outline-danger mx-1" title="Delete">
                            <i class="fa fa-trash"></i>
                            {{-- @lang('Details') --}}
                        </a>
                        <a href="#" data-toggle="modal" data-target="#response-{{$item->id}}" class="btn btn-sm btn-outline-success" title="API Response">
                            <i class="fa fa-code"></i>
                            {{-- @lang('Details') --}}
                        </a>
                    </td>
                </tr>
                {{-- mODAL for response --}}
                <div class="modal fade" id="response-{{$item->id}}" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header modal-colored-header bg-primary">
                                <h5 class="modal-title">@lang('API Response')</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">X</button>
                            </div>
                            <div class="modal-body">
                                <div form-group>
                                    <textarea class="form-control"  rows="5">{{$item->response}}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="d-card">
    <h5 class="card-header fw-bold">Recent Users</h5>
    <div class="d-card-body table-responsive">
        <table class="table app-mtables" id="datatable">
            <thead class="white">
                <tr class="thead">
                    <th>ID</th>
                    <th class="nowrap">Info</th>
                    <th class="nowrap">Balance</th>
                    <th class="nowrap">Role</th>
                    <th class="nowrap">Joined</th>
                    <th class="nowrap">Status</th>
                    <th >Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($userz as $key => $item)
                <tr class="app-block">
                    <td class="app-col" data-title="ID">{{$item->id}}</td>
                    <td class="app-col" data-title="Info">
                        <div class="">
                           <p>{{$item->name()}}</p>
                           <p class="my-1">{{$item->phone}}</p>
                            {{($item->email)}}
                        </div>
                    </td>
                    <td class="app-col" data-title="Balance">{!! format_price($item->balance) !!}</td>
                    <td class="app-col" data-title="Role">
                        <span class="order-status os-processing">{{$item->user_role}}</span>
                    </td>

                    <td class="app-col" data-title="Joined">{{show_datetime1($item->created_at)}}</td>
                    <td class="app-col" data-title="Status">
                        @if($item->status == 1)
                            <span class="badge bg-success">Active</span>
                        @elseif ($item->status == 2)
                            <span class="badge bg-warning">Unverified</span>
                        @elseif ($item->status == 3)
                            <span class="badge bg-danger">Blocked</span>
                        @elseif ($item->status == 4)
                            <span class="badge bg-info">Blocked</span>
                        @endif
                    </td>
                    <td class="app-col" data-title="Action">
                        <a href="{{route('admin.users.detail', $item->id)}}" class="btn btn-sm btn-outline-primary" title="User Details">
                            <i class="fa fa-eye"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
@section('styles')
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
