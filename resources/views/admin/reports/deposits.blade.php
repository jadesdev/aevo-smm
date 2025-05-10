@extends('admin.layouts.master')

@section('title', 'Deposits')

@section('content')
<div class="d-card">
    <div class="card-header d-flex justify-content-between app-block">
        {{-- <h5></h5> --}}
        <div class="pull-left mr-2">
            <form action="" method="get" id="history-search">
                <div class="app-ord-search">
                    <input type="text" name="search" value="{{$search}}" placeholder="Search Deposits" class="app-ord-input" />
                    <button type="submit" class="app-ord-submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>
        <div class="dropdown">
            <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span><i class="fas fa-bars pr-2"></i> @lang('Action')</span>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <button class="dropdown-item depositChangeStatus" type="button" data-toggle="modal" data-target="#depositChangeStatus" data-status="delete">@lang('Delete')</button>
                <button class="dropdown-item depositChangeStatus" type="button" data-toggle="modal" data-target="#depositChangeStatus" data-status="pending">@lang('Pending')</button>
                <button class="dropdown-item depositChangeStatus" type="button" data-toggle="modal" data-target="#depositChangeStatus" data-status="approve">@lang('Successful')</button>
                <button class="dropdown-item depositChangeStatus" type="button" data-toggle="modal" data-target="#depositChangeStatus" data-status="canceled">@lang('Canceled')</button>
            </div>
        </div>
    </div>
   <div class="d-card-body table-responsive">
    <table class="table app-mtable" id="datatable">
        <thead class="white">
            <tr class="thead-tr">
                <th class="text-md-center">
                    <input type="checkbox" class="check-all tic-check " name="check-all" id="check-all">
                    <label for="check-all"></label>
                </th>
                <th>#</th>
                <th class="nowrap">User</th>
                <th class="nowrap">Code</th>
                <th class="nowrap">Method</th>
                <th class="nowrap">Amount</th>
                <th class="nowrap">Fee</th>
                <th class="nowrap">Status</th>
                <th >Action</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($deposits as $key => $item)
            <tr class="app-block">
                <td class="app-col text-md-center" data-title="Option">
                    <input type="checkbox" id="chk-{{ $item->id }}" class="row-tic tic-check" name="check[]" value="{{ $item->id }}" data-id="{{ $item->id }}">
                    <label for="chk-{{ $item->id }}"></label>
                </td>
                <td class="app-col" data-title="#">{{$item->id}}</td>
                <td class="app-col" data-title="User">
                    <a href="{{route('admin.users.detail', $item->user->id)}}">{{$item->user->username}}</a>
                </td>
                <td class="app-col" data-title="TRX Code">
                    <div class="">
                       <p>{{$item->code}}</p>
                        {{show_datetime($item->created_at)}}
                    </div>
                </td>
                <td class="app-col" data-title="Gateway">
                    <span class="badge badge-primary">{{payment_gateway($item->gateway)}}</span>
                </td>
                <td class="app-col" data-title="Amount">{{format_price($item->amount)}}</td>
                <td class="app-col" data-title="Fee">{{format_price($item->charge)}}</td>
                <td class="app-col" data-title="Status">
                    {!!get_trx_status($item->status)!!}
                </td>
                <td class="app-col" data-title="Action">
                    <a href="#" data-toggle="modal" data-target="#editTrx-{{$item->id}}" class="btn btn-sm btn-outline-success" title="Edit">
                        <i class="fa fa-edit"></i>
                    </a>
                </td>
            </tr>
            <div class="modal fade" id="editTrx-{{$item->id}}" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header modal-colored-header bg-primary">
                            <h5 class="modal-title">@lang('Edit Trx')</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">X</button>
                        </div>
                        <div class="modal-body">
                            @if($item->type == "manual")
                            <p class="fw-bold">Payment Image:</p>
                            <img src="{{my_asset($item->image)}}" alt="" class="man-img">
                            @endif
                            <form action="{{route('admin.deposit.edit', $item->id)}}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-6">
                                        <label class="form-label">Transaction ID</label>
                                        <input type="text" readonly class="form-control" value="{{$item->code}}"/>
                                    </div>
                                    <div class="form-group col-6">
                                        <label class="form-label">Payment Method</label>
                                        <input type="text" class="form-control" readonly value="{{$item->gateway}}"/>
                                    </div>
                                    <div class="form-group col-6">
                                        <label class="form-label">Amount</label>
                                        <input type="number" step="any" class="form-control" name="amount" value="{{$item->amount}}" required placeholder="Amount"/>
                                    </div>
                                    <div class="form-group col-6">
                                        <label class="form-label">Status</label>
                                        <select class="form-control form-select" id="status" name="status">
                                            <option value="1" {{ $item->status == '1' ? 'selected' : '' }}>@lang('Approved')</option>
                                            <option value="2" {{ $item->status == '2' ? 'selected' : '' }}>@lang('Pending')</option>
                                            <option value="3" {{ $item->status == '3' ? 'selected' : '' }}>@lang('Canceled')</option>
                                        </select>
                                    </div>
                                </div>
                                <button class="btn btn-success btn-md w-100" type="submit">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        </tbody>
    </table>
   </div>
   <div class="" >
       {{$deposits->links()}}
   </div>
</div>

<div class="modal fade" id="depositChangeStatus" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-colored-header bg-primary">
                <h5 class="modal-title">@lang('Order Status Change')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">X</button>
            </div>

            <div class="modal-body">
                <p>@lang("Are you sure you want to <span class='text-info text-status'>Pending</span> the deposits ?")</p>
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
                    Manage Deposits.
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
    $(document).on('click', '.depositChangeStatus', function () {
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
            url: "{{ route('admin.deposit.status') }}",
            data: {
                strIds,
                status
            },
            datatType: 'json',
            type: "get",
            success: function (data) {
                // console.log(data);
                swal("Successful!", "Transactiom Updated Successful", "success")
                .then(function() {
                    location.reload();
                });
                // location.reload();
            }
        });
    })
</script>
@endpush
