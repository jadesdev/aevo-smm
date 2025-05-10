@extends('admin.layouts.master')
@section('title', $title)

@section('content')

<div class="d-card">
    <div class="card-header">
        <div class="d-flex align-items-center justify-content-between">
            <h5 class="mb-0">{{$title}} </h5>

            <div class="dropdown">
                <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span><i class="fas fa-bars pr-2"></i> @lang('Action')</span>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <button class="dropdown-item" type="button" data-toggle="modal" data-target="#all_import">@lang('Import Service')</button>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="white">
                    <tr>
                        <th>
                            <input type="checkbox" class="check-all tic-check " name="check-all" id="check-all">
                            <label for="check-all"></label>
                        </th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Rate per 1000</th>
                        <th>Min / Max</th>
                        <th>Dripfeed</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($services as $item)
                    <tr>
                        <td class="text-center">
                            <input type="checkbox" id="chk-{{ $item['service'] }}" class="row-tic tic-check" name="check[]" value="{{ $item['service'] }}" data-id="{{ $item['service'] }}">
                            <label for="chk-{{ $item['service'] }}"></label>
                        </td>
                        <td>{{$item['service']}}</td>
                        <td>{{($item['name'])}}</td>
                        <td>{{($item['category'])}}</td>
                        <td>{{($item['rate'])}}</td>
                        <td>{{($item['min'])}} / {{$item['max']}}</td>
                        <td>{!! get_status($item['dripfeed']) !!}</td>
                        <td>
                            <div class="row">
                                <a href="#" data-toggle="modal" data-target="#addModal" class="btn btn-primary btn-sm addBtn"
                                    data-name="{{ $item['name'] }}" data-api_provider_id={{ $provider->id }}
                                    data-api_price="{{ $item['rate'] }}" data-desc="{{ $item['desc'] ?? $item['description'] ?? ""}}"
                                    data-min="{{ $item['min'] }}" data-max="{{ $item['max'] }}" data-type="{{ $item['type'] }}" data-dripfeed="{{ $item['dripfeed'] }}"
                                    data-api_service_id="{{ $item['service'] }}"><i class="fa fa-plus"></i></a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{-- {{ $services->links() }} --}}
    </div>

</div>
{{-- Modals --}}
{{-- Add MODAL --}}
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">@lang('Add New Service')</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form class="form-horizontal reset" method="post" action="{{ route('admin.provider.service.store') }}">
                @csrf
                <input type="hidden" name="api_provider_id">
                <div class="modal-body">
                    <div class="form-group">
                        <label>@lang('Category')</label>
                        <div class="col-sm-12">
                            <select name="category" class="form-control" id="">
                            @foreach($categories as $categorie)
                                <option value="{{ $categorie->id  }}">@lang($categorie->name)</option>
                            @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-row form-group">
                        <label>@lang('Name')</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="code" name="name" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-6">
                            <label>@lang('Percentage Increase')</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="percentage" required>
                                <div class="input-group-text">% </div>
                            </div>
                        </div>
                        <div class="form-group col-6">
                            <label>@lang('API Price')</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="apiPrice" name="api_price" readonly>
                                <div class="input-group-text">{{ get_setting('currency') }}</div>
                            </div>
                        </div>
                        <div class="form-group col-6">
                            <label>@lang('Min')</label>
                            <input type="text" name="min" class="form-control" required readonly>
                        </div>
                        <div class="form-group col-6">
                            <label>@lang('Max')</label>
                            <input type="text" name="max" class="form-control" readonly required>
                        </div>
                    </div>
                    <div class="form-group d-none">
                        <input type="text" name="type" class="form-control" hidden readonly required>
                        <input type="text" name="dripfeed" class="form-control" hidden readonly required>
                    </div>
                    <div class="form-group">
                        <label>@lang('Details')</label>
                        <textarea class="form-control" rows="4" name="desc" >. </textarea>
                    </div>
                    <div class="form-group">
                        <label>@lang('Service Id (If order process through API)')</label>
                        <input type="text" name="api_service_id" class="form-control" readonly required>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary w-100 btn-md">@lang('Submit')</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="all_import" role="dialog">
    <div class="modal-dialog ">
        <div class="modal-content">

            <div class="modal-header modal-colored-header bg-primary">
                <h5 class="modal-title">@lang('Import Bulk Services')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <p>@lang('Are you want to import Selected Services?')</p>

                <div class="form-group">
                    <label>@lang('Percentage Increase')</label>
                    <input type="number" class="form-control" id="percentage" value="200" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal"><span>@lang('No')</span>
                </button>
                <form action="" method="post">
                    @csrf
                    <input type="hidden" name="percentage" value="">
                    <a href="" class="btn btn-primary import-yes"><span>@lang('Yes')</span></a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('styles')
<style>
.btn {
    padding: 5px 10px!important;
    font-size: 12px!important;
    height: auto!important;
    border-radius: 5px!important;
}
</style>
@endsection
@push('scripts')
<script>
    $(document).ready(function () {
        "use strict";
        $(document).on('click', '#check-all', function () {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });

        $(document).on('change', ".row-tic", function () {
            let length = $(".row-tic").length;
            let checkedLength = $(".row-tic:checked").length;
            if (length == checkedLength) {
                $('#check-all').prop('checked', true);
            } else {
                $('#check-all').prop('checked', false);
            }
        });
        //multiple active
        $(document).on('click', '.import-yes', function (e) {
            e.preventDefault();
            var allVals = [];
            var percentage = $('#percentage').val();
            var provider_id = '{{$provider->id}}';

            $(".row-tic:checked").each(function () {
                allVals.push($(this).attr('data-id'));
            });

            if (allVals.length > 0) {
                var strIds = allVals.join(",");
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                    url: "{{ route('admin.provider.bulkimport') }}",
                    data: {strIds: strIds, percentage: percentage, provider_id},
                    datatType: 'json',
                    type: 'get',
                    success: function (data) {
                        console.log(data);
                        if (data.success == 1) {
                            window.location.reload();
                        }
                    }
                });
            } else {
                var strIds = allVals.join(",");
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                    url: "{{ route('admin.provider.bulkimport') }}",
                    data: {strIds: strIds, percentage, provider_id},
                    datatType: 'json',
                    type: 'get',
                    success: function (data) {
                        console.log(data);
                        if (data.error == 1) {
                            window.location.reload();
                        }
                    }
                });
            }
        });
        // Add modal contents
        $(document).on('click', '.addBtn', function() {
            var modal = $('#addModal');
            $('.reset').trigger("reset");
            var name = $(this).data('name');
            var api_price = $(this).data('api_price');
            var min = $(this).data('min');
            var max = $(this).data('max');
            var type = $(this).data('type');
            var dripfeed = $(this).data('dripfeed');
            var desc = $(this).data('desc');
            var api_provider_id = $(this).data('api_provider_id');
            var api_service_id = $(this).data('api_service_id');
            modal.find('input[name=name]').val(name);
            modal.find('input[name=api_price]').val(api_price);
            modal.find('input[name=min]').val(min);
            modal.find('input[name=max]').val(max);
            modal.find('input[name=dripfeed]').val(dripfeed);
            modal.find('input[name=type]').val(type);
            modal.find('input[name=api_provider_id]').val(api_provider_id);
            modal.find('input[name=api_service_id]').val(api_service_id);
            modal.find('textarea[name=desc]').val(desc);
            modal.modal('show');
        });
    });


</script>
@endpush
