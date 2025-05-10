@extends('admin.layouts.master')
@section('title', "API Providers")

@section('content')

<div class="d-card">
    <div class="card-header">
        <div class="d-flex align-items-center justify-content-between">
            <h5 class="mb-0">API Providers</h5>
            <a href="#" data-toggle="modal" data-target="#CreateCategory" class="btn btn-primary btn-sm">Add Provider</a>
        </div>
    </div>
    <div class="d-card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="white">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Url</th>
                        <th>Balance</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($providers as $item)
                    <tr>
                        <td>{{$item->id}}</td>
                        <td>{{$item->name ?? 'N/A'}} </td>
                        <td>{{text_trim($item->api_url, 160)}}</td>
                        <td>{{format_price($item->balance)}}</td>
                        <td>{!! get_status($item->status) !!}</td>
                        <td>
                            <div class="row">
                                <a href="#" title="Edit Provider" data-toggle="modal" data-target="#editProvider{{$item->id}}"  class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                @if($item->status == 1)
                                <a href="{{route('admin.provider.status',$item->id)}}" title="Disable" class="btn btn-danger btn-sm"><i title="" class="fa fa-times-circle"></i></a> @else
                                <a href="{{route('admin.provider.status',$item->id)}}" title="Enable" class="btn btn-success btn-sm"><i class="fa fa-check-circle"></i></a>
                                @endif
                                <a href="javascript:void(0)" class="btn btn-outline-success btn-sm price-change"
                                    data-route="{{ route('admin.provider.priceUpdate',[$item->id] ) }} "
                                    data-toggle="modal" data-target="#updatePriceModal" title=" @lang('Update Service')">
                                    <i class="fa fa-sync text-info" aria-hidden="true"></i>
                                </a>
                                <a href="javascript:void(0)" class="btn btn-outline-warning btn-sm import-service"
                                    data-route="{{ route('admin.provider.import',[$item->id] ) }} "
                                    data-toggle="modal" data-target="#importServiceModal" title=" @lang('Import Service')">
                                    <i class="fa fa-download text-primary" aria-hidden="true"></i>
                                </a>
                                <a class="btn btn-outline-info btn-sm balance-change"
                                    href="{{ route('admin.provider.balanceUpdate',[$item->id] ) }} "
                                    title=" @lang('Update Balance')">
                                    <i class="fa fa-money-bill-alt text-info" aria-hidden="true"></i>
                                </a>
                                <a href="{{route('admin.provider.services', $item->id)}}" class="btn btn-info btn-sm" title="Services List "><i class="fa fa-list"></i></a>
                                <a href="{{route('admin.provider.delete', $item->id)}}" class="btn btn-outline-danger btn-sm delete-btn" title="Delete Provider "><i class="fa fa-trash"></i></a>
                            </div>
                        </td>
                    </tr>
                    {{-- Modals --}}
                    <div class="modal fade" id="editProvider{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h6 class="modal-title" id="myModalLabel"> Edit {{$item->name}}</h6>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"></span></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{route('admin.provider.edit', $item->id)}}" method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$item->id}}" >
                                    <div class="form-group">
                                        <label class="form-label">Name</label>
                                        <input type="text" class="form-control" value="{{$item->name}}" required placeholder="API Name" name="name">
                                    </div>
                                    <div class="form-group">
                                        <label>@lang('Api Url')</label>
                                        <input type="url" class="form-control" value="{{$item->api_url}}"  name="api_url" required>
                                    </div>
                                    <div class="form-group">
                                        <label>@lang('Api Key')</label>
                                        <input type="text" class="form-control" value="{{$item->api_key}}"  name="api_key" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Status</label>
                                        <select name="status" class="form-control">
                                            <option value="1" @if($item->status == 1) selected @endif>Enabled</option>
                                            <option value="2" @if($item->status == 2) selected @endif>Disabled</option>
                                        </select>
                                    </div>
                                    <button class="btn btn-success mt-2 w-100" type="submit">Edit Provider</button>
                                </form>
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

<div class="modal fade" id="updatePriceModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">@lang('Sync API Services')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="post" id="priceForm">
                @csrf
                <div class="modal-body">
                    <p>@lang('Do you want to update provider\'s services?')</p>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                          <label>Synchronous request</label>
                          <select name="request_type" class="form-control form-select">
                            <option value="0">Current Services</option>
                            <option value="1">All</option>
                          </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>@lang('Percentage Increase')</label>
                        <input type="number" class="form-control" value="100" name="percentage" required>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                          <label class=" custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="sync_request_options[new_price]" value="1">
                            <span class="custom-control-label"> Sync New Price</span>
                          </label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                          <label class=" custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="sync_request_options[original_price]" value="1" checked="">
                            <span class="custom-control-label"> Sync Original Price</span>
                          </label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                          <label class=" custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="sync_request_options[min_max_dripfeed]" value="1">
                            <span class="custom-control-label"> Sync Min, Max, DripFeed</span>
                          </label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                          <label class=" custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="sync_request_options[service_name]" value="1">
                            <span class="custom-control-label"> Sync Service Name</span>
                          </label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                          <label class=" custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="sync_request_options[description]" value="1">
                            <span class="custom-control-label"> Sync Services Description </span>
                          </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="w-100 btn btn-primary">
                        <span> @lang('Yes')</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="importServiceModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">@lang('Import services')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="post" id="importForm">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>@lang('Percentage Increase')</label>
                        <input type="number" class="form-control" name="percentage" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">
                        <span> @lang('Yes')</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="CreateCategory" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
              <h6 class="modal-title" id="myModalLabel"> New API Provider</h6>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"></span></button>
          </div>
          <div class="modal-body">
            <form action="{{route('admin.provider.store')}}" method="post">
                @csrf
                <div class="form-group">
                    <label>@lang('Api Name')</label>
                    <input type="text" class="form-control" name="name" required>
                </div>
                <div class="form-group">
                    <label>@lang('Api Url')</label>
                    <input type="url" class="form-control" name="api_url" required>
                </div>
                <div class="form-group">
                    <label>@lang('Api Key')</label>
                    <input type="text" class="form-control" name="api_key" required>
                </div>

                <button class="btn btn-success mt-2 w-100" type="submit">Create Provider</button>
            </form>
          </div>
      </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        "use strict";
        $(document).on('click', '#check-all', function () {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });

        $(document).on('click', '.price-change', function () {
            let route = $(this).data('route');
            $('#priceForm').attr('action', route);
        });
        $(document).on('click', '.import-service', function () {
            let route = $(this).data('route');
            $('#importForm').attr('action', route);
        });
        $(document).on('click', '.dropdown-menu', function (e) {
            e.stopPropagation();
        });

    });
</script>
@endpush
