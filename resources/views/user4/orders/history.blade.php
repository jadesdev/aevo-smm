@extends('user4.layouts.master')
@section('title', $title)

@section('content')
<div class="row">
    <div class="col-lg-12 col-12 mb-5 mb-lg-0">
        <div class="orders-btn py-3">
            <ul class="nav nav-pills app-ord-nav">
                <li class=" ">
                    <a class="@if($type == "index") active @endif " href="{{route('user.orders.index')}}"><i class="fas fa-filter mr-1"></i>All Orders</a>
                </li>
                <li class=" ">
                    <a class="@if($type == "pending") active @endif" href="{{route('user.orders.pending')}}"><i class="fas fa-file-import mr-1"></i>Order Received</a>
                </li>
                <li class=" ">
                    <a class="@if($type == "inprogress") active @endif" href="{{route('user.orders.inprogress')}}"><i class="fas fa-spinner mr-1"></i>In Progress</a>
                </li>
                <li class=" ">
                    <a class="@if($type == "completed") active @endif" href="{{route('user.orders.completed')}}"><i class="far fa-check-circle mr-1"></i>Completed</a>
                </li>
                <li class=" ">
                    <a class="@if($type == "partial") active @endif" href="{{route('user.orders.partial')}}"><i class="fas fa-hourglass-start mr-1"></i>Partially Completed</a>
                </li>
                <li class=" ">
                    <a class="@if($type == "processing") active @endif" href="{{route('user.orders.processing')}}"><i class="fas fa-sort-numeric-down mr-1"></i>Processing</a>
                </li>
                <li class=" ">
                    <a class="@if($type == "canceled") active @endif" href="{{route('user.orders.canceled')}}"><i class="fas fa-ban mr-1"></i>Canceled</a>
                </li>
                <li class="pull-right search  ">
                    <form action="" method="get" id="history-search">
                        <div class="app-ord-search">
                            <input type="text" name="search" value="{{$search}}" placeholder="Search Orders" class="app-ord-input" />
                            <button type="submit" class="btn btn-info app-ord-submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </li>
            </ul>
        </div>

        <div class="card" >
            <div class="card-body table-responsive">
                <table class="table app-mtable">
                    <thead>
                        <tr class="thead-tr">
                            <th>ID</th>
                            <th>Date</th>
                            <th>Link</th>
                            <th class="nowrap">Price</th>
                            <th class="nowrap">Start</th>
                            <th class="nowrap">Quantity</th>
                            <th class="nowrap">Service</th>
                            <th class="nowrap">Remaining</th>
                            <th class="nowrap" style="min-width: 100px;">Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($orders as $item)
                        <tr class="app-block">
                            <td class="app-col" data-title="ID">{{$item->id}}</td>
                            <td class="app-col" data-title="Date">{{show_datetime2($item->created_at)}}</td>
                            <td class="app-col" data-title="Link"><a target="_blank" href="{{$item->link}}">{{text_trim($item->link, 50)}}</a></td>
                            <td class="app-col" data-title="Price">{{format_amount($item->price)}}</td>
                            <td class="app-col" data-title="Start">{{$item->start_counter}}</td>
                            <td class="app-col" data-title="Quantity">{{$item->quantity}}</td>
                            <td class="app-col" data-title="Service">{{text_trim(($item->service->name) ?? "N/A", 80)?? null}}</td>
                            <td class="app-col" data-title="Remaining">{{$item->remain}}</td>
                            <td class="app-col" data-title="Status">{!!get_order_status($item->status)!!} </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
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
                    Manage all your Orders
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('styles')
<style>

	.app-ord-nav li {
		width: 49%;
		margin: 0 1%;
		margin-right: auto!important;
	}
	.orders-btn {
		padding-bottom: 0!important
	}
</style>
@endsection
