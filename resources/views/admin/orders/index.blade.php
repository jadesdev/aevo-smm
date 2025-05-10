@extends('admin.layouts.master')
@section('title', $title)

@section('content')

<div class="row">
    <div class="col-lg-12 col-12 mb-5 mb-lg-0">
        <div class="orders-btn py-3">
            <ul class="nav nav-pills app-ord-nav">
                <li class="mr-2">
                    <a class="@if($type == "index") active @endif " href="{{route('admin.orders.index')}}"><i class="fas fa-filter mr-1"></i>All Orders</a>
                </li>
                <li class="mr-2">
                    <a class="@if($type == "pending") active @endif" href="{{route('admin.orders.pending')}}"><i class="fas fa-file-import mr-1"></i>Pending</a>
                </li>
                <li class="mr-2">
                    <a class="@if($type == "inprogress") active @endif" href="{{route('admin.orders.inprogress')}}"><i class="fas fa-spinner mr-1"></i>In Progress</a>
                </li>
                <li class="mr-2">
                    <a class="@if($type == "completed") active @endif" href="{{route('admin.orders.completed')}}"><i class="far fa-check-circle mr-1"></i>Completed</a>
                </li>
                <li class="mr-2">
                    <a class="@if($type == "partial") active @endif" href="{{route('admin.orders.partial')}}"><i class="fas fa-hourglass-start mr-1"></i>Partially Completed</a>
                </li>
                <li class="mr-2">
                    <a class="@if($type == "processing") active @endif" href="{{route('admin.orders.processing')}}"><i class="fas fa-sort-numeric-down mr-1"></i>Processing</a>
                </li>
                <li class="mr-2">
                    <a class="@if($type == "canceled") active @endif" href="{{route('admin.orders.canceled')}}"><i class="fas fa-ban mr-1"></i>Canceled</a>
                </li>
                <li class="mr-2">
                    <a class="@if($type == "error") active @endif" href="{{route('admin.orders.error')}}"><i class="fas fa-ban mr-1"></i>Error <span class="bg-danger">({{ error_orders() }})</span></a>
                </li>
                <li class="pull-right search mr-2">
                    <form action="" method="get" id="history-search">
                        <div class="app-ord-search">
                            <input type="text" name="search" required value="{{$search}}" placeholder="Search Orders" class="app-ord-input" />
                            <button type="submit" class="app-ord-submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </li>
            </ul>
        </div>
        <div class="card-header">
            <div class="d-flex align-items-center justify-content-between">
                <h5 class="mb-0">{{$title}} </h5>
                <div class="row">
                    <div class="dropdown">
                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span><i class="fas fa-bars pr-2"></i> @lang('Action')</span>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <button class="dropdown-item usersOrderChangeStatus" type="button" data-toggle="modal" data-target="#usersOrderChangeStatus" data-status="pending">@lang('Pending')</button>
                            <button class="dropdown-item usersOrderChangeStatus" type="button" data-toggle="modal" data-target="#usersOrderChangeStatus" data-status="processing">@lang('Processing')</button>
                            <button class="dropdown-item usersOrderChangeStatus" type="button" data-toggle="modal" data-target="#usersOrderChangeStatus" data-status="inprogress">@lang('In Progress')</button>
                            <button class="dropdown-item usersOrderChangeStatus" type="button" data-toggle="modal" data-target="#usersOrderChangeStatus" data-status="completed">@lang('Completed')</button>
                            <button class="dropdown-item usersOrderChangeStatus" type="button" data-toggle="modal" data-target="#usersOrderChangeStatus" data-status="canceled">@lang('Canceled & Refund')</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-card" >
            <div class="d-card-body table-responsive">
                <table class="table app-mtable">
                    <thead>
                        <tr class="thead-tr">
                            <th>
                                <input type="checkbox" class="check-all tic-check " name="check-all" id="check-all">
                                <label for="check-all"></label>
                            </th>
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
                        @foreach ($orders as $item)
                        <tr class="app-block">
                            <td class="app-col text-md-center" data-title="Option">
                                <input type="checkbox" id="chk-{{ $item->id }}" class="row-tic tic-check" name="check[]" value="{{ $item->id }}" data-id="{{ $item->id }}">
                                <label for="chk-{{ $item->id }}"></label>
                            </td>
                            <td class="app-col" data-title="ID">{{$item->id}}</td>
                            <td class="app-col" data-title="User">
                                <p class="mr-2 my-0">Email: {{$item->user->email ?? ""}}</p>
                                <p class="my-0">User: {{$item->user->username ?? ""}}</p>
                            </td>
                            <td class="app-col" data-title="Date">{{show_datetime2($item->created_at)}}</td>
                            <td class="app-col" data-title="Price">{{format_price($item->price)}} /</td>
                            <td class="app-col" data-title="Order Details">
                                <div class="rows">
                                    @if($item->error)
                                    <p class="alert alert-danger mb-0 "> Error: <span class="text-danger">{{$item->error_message}}</span> </p>
                                    @endif
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
                                    class="btn btn-sm btn-outline-danger" title="Delete">
                                    <i class="fa fa-trash"></i>
                                    {{-- @lang('Details') --}}
                                </a>
                                <a href="#" data-toggle="modal" data-target="#response-{{$item->id}}" class="btn btn-sm btn-outline-success" title="API Response">
                                    <i class="fa fa-code"></i>
                                    {{-- @lang('Details') --}}
                                </a>
                                @if($item->error)
                                <a href="{{route('admin.orders.resend', $item->id)}}" class="btn btn-sm btn-outline-primary" title="Resend Order">
                                    <i class="fa fa-paper-plane"></i>
                                    {{-- @lang('Details') --}}
                                </a>
                                @endif
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

    </div>
</div>


<div class="modal fade" id="usersOrderChangeStatus" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-colored-header bg-primary">
                <h5 class="modal-title">@lang('Order Status Change')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    ×
                </button>
            </div>

            <div class="modal-body">
                <p>@lang("Do you really want to change this orders to <span class='text-info text-status'>Pending</span> ?")</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal"><span>@lang('No')</span></button>
                <form action="" method="post" id="changeOrderStatus">
                    @csrf
                    <a href="" class="btn btn-primary awaiting-yes" data-status=""><span>@lang('Yes')</span></a>
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
                    Manage all Orders.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    "use strict";
    var status = null;
    $(document).on('click', '.check-all', function () {
        const table = $(this).closest('table');
        table.find('input:checkbox').not(this).prop('checked', this.checked);
    });

    $(document).on('change', '.row-tic', function () {
        const table = $(this).closest('table');
        const length = table.find('.row-tic').length;
        const checkedLength = table.find('.row-tic:checked').length;
        if (length === checkedLength) {
            table.find('.check-all').prop('checked', true);
        } else {
            table.find('.check-all').prop('checked', false);
        }
    });
    $(document).on('click', '.dropdown-menu', function (e) {
        e.stopPropagation();
    });
    $(document).on('click', '.usersOrderChangeStatus', function () {
        status = $(this).data('status');
        $('.text-status').text(status)
    });
    $(document).on('click', '.awaiting-yes', function (e) {
        e.preventDefault();
        var allVals = [];

        $(".row-tic:checked").each(function () {
            allVals.push($(this).attr('data-id'));
        });


        var strIds = allVals.join(",");


        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
            url: "{{ route('admin.orders.status') }}",
            data: {
                strIds,
                status
            },
            datatType: 'json',
            type: "get",
            success: function (data) {
                // console.log(data);
                location.reload();
            }
        });
    })
</script>
@endpush
