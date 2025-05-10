@extends('admin.layouts.master')
@section('title', 'Statistics')
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
<div class="row" style="display:none;">
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


<div class="d-card">
    <h3 class="card-header fw-bold">Provider Stats</h3>
    <div class="d-card-body table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>S/N</th>
                    <th>Name</th>
                    <th>Sales (30 Days)</th>
                    <th>Sales (Today)</th>
                    <th>Profit (30 Days)</th>
                    <th>Profit(Today)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($providers as $item)
                    <tr>
                        <td>{{$loop->iteration}} </td>
                        <td>{{$item->name}}</td>
                        <td>{{format_price($item->orders()->whereIn('status', ['completed', 'processing','inprogress'])->whereBetween('created_at', [now()->subDays(30), now()])->sum('price') )}}</td>
                        <td>{{format_price( $item->orders()->whereIn('status', ['completed', 'processing','inprogress'])->whereDate('created_at', now())->sum('price') )}}</td>
                        <td>{{format_price( $item->orders()->whereIn('status', ['completed', 'processing','inprogress'])->whereBetween('created_at', [now()->subDays(30), now()])->sum('profit'))}}</td>
                        <td>{{format_price( $item->orders()->whereIn('status', ['completed', 'processing','inprogress'])->whereDate('created_at', now())->sum('profit') )}}</td>
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
