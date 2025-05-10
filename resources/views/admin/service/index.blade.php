@extends('admin.layouts.master')
@section('title', $title)

@section('content')

<div class="d-card">
    <div class="card-header">
        <div class="d-sm-flex align-items-center justify-content-between">
            <h5 class="mb-0">{{$title}} </h5>
            <div class="row">
                <a href="{{route('admin.service.add')}}" class="btn btn-primary btn-sm mr-2">Add Service</a>
                <div class="dropdown">
                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span><i class="fas fa-bars pr-2"></i> @lang('Action')</span>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <button class="dropdown-item" type="button" data-toggle="modal" data-target="#all_active">@lang('Active')</button>
                        <button class="dropdown-item" type="button" data-toggle="modal" data-target="#all_deactive">@lang('Disable')</button>
                        <button class="dropdown-item" type="button" data-toggle="modal" data-target="#all_delete">@lang('Delete')</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-2">
        @foreach ($categories as $category)
        <div class="text-center">
            <div class="">
                <h5 class="fw-bold">{{$category->name}}</h5>
            </div>
        </div>
        <div class="d-card">
            <div class="d-card-body table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="white">
                        <tr>
                            <th>
                                <input type="checkbox" class="check-all tic-check " name="check-all" id="check-all">
                                <label for="check-all"></label>
                            </th>
                            <th>ID</th>
                            <th>Provider</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Price</th>
                            <th>API</th>
                            <th>Min</th>
                            <th>Max</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($category->service as $item)
                        <tr>
                            <td class="text-center">
                                <input type="checkbox" id="chk-{{ $item->id }}" class="row-tic tic-check" name="check[]" value="{{ $item->id }}" data-id="{{ $item->id }}">
                                <label for="chk-{{ $item->id }}"></label>
                            </td>
                            <td>{{$item->id}}</td>
                            <td>
                                <p class="my-0">{{$item->api_service_id ?? ""}}</p>
                                <p class="my-0">{{$item->provider->name ?? 'N/A'}}</p>
                            </td>
                            <td>{{text_trim($item->name, 160)}}</td>
                            <td><span class="badge bg-warning"> {{$item->s_type}}</span></td>
                            <td>{{format_price($item->price)}}</td>
                            <td>{{format_price($item->api_price)}}</td>
                            <td>{{$item->min}}</td>
                            <td>{{$item->max}}</td>
                            <td>{!! get_status($item->status) !!}</td>
                            <td>
                                <div class="row">
                                    <a href="{{route('admin.service.edit',$item->id)}}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                    {{-- @if($item->status == 1)
                                    <a href="{{route('admin.service.status',$item->id)}}" class="btn btn-primary btn-sm"><i class="fa fa-times-circle"></i></a>
                                    @else
                                    <a href="{{route('admin.service.status',$item->id)}}" class="btn btn-success btn-sm"><i class="fa fa-check-circle"></i></a>
                                    @endif --}}
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
        @endforeach

    </div>
</div>

{{-- Modals --}}
<div class="modal fade" id="all_active" role="dialog">
    <div class="modal-dialog ">
        <div class="modal-content">

            <div class="modal-header modal-colored-header bg-primary">
                <h5 class="modal-title">@lang('Confirm Status Change')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <p>@lang('Are you want to change status?')</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal"><span>@lang('No')</span>
                </button>
                <form action="" method="post">
                    @csrf
                    <input type="hidden" name="action" value="activate">
                    <a href="" class="btn btn-primary active-yes"><span>@lang('Yes')</span></a>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="all_deactive" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header modal-colored-header bg-primary">
                <h5 class="modal-title">@lang('Confirm Status Change')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="post">
                @csrf
                <input type="hidden" name="action" value="deactivate">
            <div class="modal-body">
                <p>@lang('Are you want to deactivate services')</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light red" data-dismiss="modal"><span>@lang('No')</span>
                </button>
                <a href="" class="btn btn-primary deactive-yes"><span>@lang('Yes')</span></a>
            </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="all_delete" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header modal-colored-header bg-primary">
                <h5 class="modal-title">@lang('Confirm Status Change')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="post">
                @csrf
                <input type="hidden" name="action" value="deactivate">
            <div class="modal-body">
                <p>@lang('Are you want to delete services')</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light red" data-dismiss="modal"><span>@lang('No')</span>
                </button>
                <a href="" class="btn-sm btn btn-primary delete-yes"><span>@lang('Yes')</span></a>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        "use strict";
        // $(document).on('click', '#check-all', function () {
        //     $('input:checkbox').not(this).prop('checked', this.checked);
        // });

        // $(document).on('change', ".row-tic", function () {
        //     let length = $(".row-tic").length;
        //     let checkedLength = $(".row-tic:checked").length;
        //     if (length == checkedLength) {
        //         $('#check-all').prop('checked', true);
        //     } else {
        //         $('#check-all').prop('checked', false);
        //     }
        // });
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


        //multiple active
        $(document).on('click', '.active-yes', function (e) {
            e.preventDefault();
            var allVals = [];

            $(".row-tic:checked").each(function () {
                allVals.push($(this).attr('data-id'));
            });

            if (allVals.length > 0) {
                var strIds = allVals.join(",");
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                    url: "{{ route('admin.service.multiple-activate') }}",
                    data: {strIds: strIds},
                    datatType: 'json',
                    type: 'get',
                    success: function (data) {
                        if (data.success == 1) {
                            window.location.reload();
                        }
                    }
                });
            } else {
                var strIds = allVals.join(",");
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                    url: "{{ route('admin.service.multiple-activate') }}",
                    data: {strIds: strIds},
                    datatType: 'json',
                    type: 'get',
                    success: function (data) {
                        if (data.error == 1) {
                            window.location.reload();
                        }
                    }
                });
            }
        });

        //multiple deActive
        $(document).on('click', '.deactive-yes', function (e) {
            e.preventDefault();
            var allVals = [];
            $(".row-tic:checked").each(function () {
                allVals.push($(this).attr('data-id'));
            });
            if (allVals.length > 0) {
                var strIds = allVals.join(",");

                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                    url: "{{ route('admin.service.multiple-deactivate') }}",
                    data: {strIds: strIds},
                    datatType: 'json',
                    type: 'get',
                    success: function (data) {
                        if (data.success == 1) {
                            window.location.reload();
                        }
                    }
                });

            } else {
                var strIds = allVals.join(",");
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                    url: "{{ route('admin.service.multiple-deactivate') }}",
                    data: {strIds: strIds},
                    datatType: 'json',
                    type: 'get',
                    success: function (data) {
                        if (data.error == 1) {
                            window.location.reload();
                        }
                    }
                });
            }

        });

        //multiple delete
        $(document).on('click', '.delete-yes', function (e) {
            e.preventDefault();
            var allVals = [];
            $(".row-tic:checked").each(function () {
                allVals.push($(this).attr('data-id'));
            });
            if (allVals.length > 0) {
                var strIds = allVals.join(",");

                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                    url: "{{ route('admin.service.multiple-delete') }}",
                    data: {strIds: strIds},
                    datatType: 'json',
                    type: 'get',
                    success: function (data) {
                        if (data.success == 1) {
                            window.location.reload();
                        }
                    }
                });

            } else {
                var strIds = allVals.join(",");
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                    url: "{{ route('admin.service.multiple-delete') }}",
                    data: {strIds: strIds},
                    datatType: 'json',
                    type: 'get',
                    success: function (data) {
                        if (data.error == 1) {
                            window.location.reload();
                        }
                    }
                });
            }

        });

    });


</script>
@endpush
