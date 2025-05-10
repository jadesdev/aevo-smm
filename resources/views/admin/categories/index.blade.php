@extends('admin.layouts.master')
@section('title', $title)

@section('content')
<div class="d-card">
    <div class="card-header">
        <div class="d-sm-flex align-items-center justify-content-between">
            <h5 class="mb-0">{{$title}} </h5>
            <div class="row">
                <a href="#" data-toggle="modal" data-target="#CreateCategory" class="btn btn-primary btn-sm mr-2">Add Catgeory</a>
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
    <div class="d-card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="white">
                    <tr>
                        <th>
                            <input type="checkbox" class="check-all tic-check" name="check-all" id="check-all">
                            <label for="check-all"></label>
                        </th>
                        <th>#</th>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Services</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $item)
                    <tr>
                        <td class="app-col text-md-center" data-title="Option">
                            <input type="checkbox" id="chk-{{ $item->id }}" class="row-tic tic-check" name="check[]" value="{{ $item->id }}" data-id="{{ $item->id }}">
                            <label for="chk-{{ $item->id }}"></label>
                        </td>
                        <td>{{$item->id}}</td>
                        <td>{{$item->name}}</td>
                        <td>{!! get_status($item->status) !!}</td>
                        <td>
                            <a href="{{route('admin.category.services', $item->id)}}" class="btn btn-secondary btn-sm">View</a>
                        </td>
                        <td>
                            <div>
                                <a href="#" data-toggle="modal" data-target="#TrackEdit{{$item->id}}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                <a href="{{route('admin.category.delete', $item->id)}}" class="delete-btn btn btn-danger ml-2 btn-sm"><i class="fa fa-trash"></i></a>
                            </div>
                        </td>
                    </tr>
                    <div class="modal fade" id="TrackEdit{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <h6 class="modal-title" id="myModalLabel"> Edit {{$item->name}}</h6>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"></span></button>
                              </div>
                              <div class="modal-body">
                                <form action="{{route('admin.category.store')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$item->id}}" >
                                    <div class="form-group">
                                        <label class="form-label">Name</label>
                                        <input type="text" class="form-control" value="{{$item->name}}" required placeholder="Category Name" name="name">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Status</label>
                                        <select name="status" class="form-control">
                                            <option value="1" @if($item->status == 1) selected @endif>Enabled</option>
                                            <option value="2" @if($item->status == 2) selected @endif>Disabled</option>
                                        </select>
                                    </div>
                                    <button class="btn btn-success mt-2 w-100" type="submit">Edit Category</button>
                                </form>
                              </div>
                          </div>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>

            <span class="mt-2">
                {{$categories->links()}}
            </span>
        </div>
    </div>
</div>

<div class="modal fade" id="CreateCategory" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
              <h6 class="modal-title" id="myModalLabel"> Create New Category</h6>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true"></span></button>
          </div>
          <div class="modal-body">
            <form action="{{route('admin.category.store')}}" method="post">
                @csrf
                <div class="form-group">
                    <label class="form-label">Name</label>
                    <input type="text" class="form-control" required placeholder="Category Name" name="name">
                </div>
                <button class="btn btn-success mt-2 w-100" type="submit">Create Category</button>
            </form>
          </div>
      </div>
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

@section('breadcrumb')

@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        "use strict";

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
                    url: "{{ route('admin.category.multiple-activate') }}",
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
                    url: "{{ route('admin.category.multiple-activate') }}",
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
                    url: "{{ route('admin.category.multiple-deactivate') }}",
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
                    url: "{{ route('admin.category.multiple-deactivate') }}",
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
                    url: "{{ route('admin.category.multiple-delete') }}",
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
                    url: "{{ route('admin.category.multiple-delete') }}",
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
