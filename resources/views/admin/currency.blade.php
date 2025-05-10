@extends('admin.layouts.master')
@section('title') @lang('Manage Currency') @stop
@section('content')

<div class="d-card">
    <div class="card-header">
        <div class="d-flex align-items-center justify-content-between">
            <h5 class="mb-0">@lang('Manage Currency')</h5>
            <a href="#" data-toggle="modal" data-target="#addCurrency" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> @lang('Add Currency')</a>
        </div>
    </div>
    <div class="d-card-body table-responsive">
        <table class="table-hover table table-bordered" id="datatable">
            <thead class="text-primary">
                <tr class="text-primary">
                    <th>#</th>
                    <th class="text-primary">@lang('Name')</th>
                    <th class="text-primary">@lang('Symbol')</th>
                    <th class="text-primary">@lang('Code')</th>
                    <th class="text-primary">@lang('Rate') [1 {{get_setting('currency_code') }} =] </th>
                    <th class="text-primary">@lang('Status')</th>
                    <th class="text-primary">@lang('Action')</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($currencies as $currency)
                <tr>
                    <td>{{ $loop->iteration}}</td>
                    <td>{{$currency->name}}</td>
                    <td>{{$currency->symbol}}</td>
                    <td>{{$currency->code}}</td>
                    <td>{{$currency->rate}} {{$currency->code}}</td>
                    <td>
                        <label class="jdv-switch jdv-switch-info mb-0">
                            <input type="checkbox" onchange="updateStatus(this)" value="{{$currency->id}}" @if($currency->status == 1) checked @endif >
                            <span class="slider round"></span>
                        </label>
                    </td>
                    <td class="text-e">
                        <a href="#" data-toggle="modal" data-target="#editCurrency" class="btn btn-primary btn-sm editBtn"
                            data-name="{{ $currency['name'] }}" data-symbol={{ $currency->symbol }} data-code="{{ $currency['code'] }}" data-id="{{ $currency['id'] }}"
                            data-rate="{{ $currency['rate'] }}" data-status="{{ $currency['status']}}" title="@lang('Edit')"><i class="fa fa-edit"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-md-6 mt-4">
        <div class="d-card">
            <div class="card-header">
                <h5 class="mb-0 fw-bold">{{__('Default Currency')}}</h5>
            </div>
            <div class="d-card-body">
                <form action="{{ route('admin.currency.update_default') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <input type="hidden" name="types[]" value="default_currency">
                        <select class="form-control form-select  select2" data-toggle="select2" name="default_currency" >
                        @foreach ($currencies->where('status',1) as $currency)
                            <option value="{{ $currency->id }}" @if(get_setting('currency_code') == $currency->code) selected @endif >
                                {{ $currency->name }}
                            </option>
                        @endforeach
                        </select>
                    </div>
                    <div class="mb-0">
                        <button class="btn btn-sm btn-primary w-100" type="submit">@lang('Save')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-4 mt-4">
        <div class="d-card mb-2">
            <h5 class="card-header">Enable Multi Currency</h5>
            <div class="d-card-body text-center">
                <label class="jdv-switch jdv-switch-success mb-0">
                    <input type="checkbox" onchange="updateSystem(this, 'multi_currency')" @if (sys_setting('multi_currency') == 1) checked @endif>
                    <span class="slider round"></span>
                </label>
            </div>
        </div>
    </div>
</div>
<!-- Add Currency Modal -->
<div class="modal fade" id="addCurrency" tabindex="-1" aria-labelledby="addCurrencyModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCurrencyModalLabel">@lang('Add Currency')</h5>
                <button type="button" class="btn close" data-dismiss="modal" aria-label="Close">X</button>
            </div>
            <div class="modal-body">
                <form action="{{route('admin.currency.store')}}" method="post">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">@lang('Name')</label>
                        <input type="text" class="form-control" required placeholder="Currency Name" name="name">
                    </div>
                    <div class="form-group">
                        <label class="form-label">@lang('Symbol')</label>
                        <input type="text" class="form-control" required placeholder="Currency Symbol" name="symbol">
                    </div>
                    <div class="form-group">
                        <label class="form-label">@lang('Code')</label>
                        <input type="text" class="form-control" required placeholder="Currency Code" name="code">
                    </div>
                    <div class="form-group">
                        <label class="form-label">@lang('Exchange Rate') [1 {{get_setting('currency_code')}} =]</label>
                        <input type="text" class="form-control" required placeholder="Exchange Rate" name="rate">
                    </div>
                    <button class="btn btn-primary mt-2 w-100" type="submit">@lang('Create')</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Currency Modal -->
<div class="modal fade" id="editCurrency" tabindex="-1" aria-labelledby="editCurrencyModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCurrencyModalLabel">@lang('Edit Currency')</h5>
                <button type="button" class="btn close" data-dismiss="modal" aria-label="Close">X</button>
            </div>
            <div class="modal-body">
                <form action="{{route('admin.currency.update')}}" method="post" id="editForm">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="form-group">
                        <label class="form-label">@lang('Name')</label>
                        <input type="text" class="form-control" required placeholder="Currency Name" name="name">
                    </div>
                    <div class="form-group">
                        <label class="form-label">@lang('Symbol')</label>
                        <input type="text" class="form-control" required placeholder="Currency Symbol" name="symbol">
                    </div>
                    <div class="form-group">
                        <label class="form-label">@lang('Code')</label>
                        <input type="text" class="form-control" required placeholder="Currency Code" name="code">
                    </div>
                    <div class="form-group">
                        <label class="form-label">@lang('Exchange Rate') </label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text text-white w-100">1 {{get_setting('currency_code')}}</div>
                            </div>
                            <input type="text" class="form-control" required placeholder="Exchange Rate" name="rate">
                            <div class="input-group-prepend">
                                <div class="input-group-text text-white w-100" id="cCode"></div>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary mt-2 w-100" type="submit">@lang('Update')</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
@section('styles')
@endsection

@push('scripts')
<script>
$(document).ready(function () {
    "use strict";
    // Add offcanvas contents
    $(document).on('click', '.editBtn', function() {
        var canvas = $('#editCurrency');
        $('#editForm').trigger("reset");
        var name = $(this).data('name');
        var code = $(this).data('code');
        var symbol = $(this).data('symbol');
        var rate = $(this).data('rate');
        var status = $(this).data('status');
        var id = $(this).data('id');
        canvas.find('#cCode').text(code);
        canvas.find('input[name=name]').val(name);
        canvas.find('input[name=code]').val(code);
        canvas.find('input[name=symbol]').val(symbol);
        canvas.find('input[name=rate]').val(rate);
        canvas.find('input[name=status]').val(status);
        canvas.find('input[name=id]').val(id);

    });
});
//Change status
function updateStatus(el){
    if($(el).is(':checked')){
        var status = 1;
    }
    else{
        var status = 0;
    }
    var id = $(el).val();
    $.post('{{ route('admin.currency.update_status') }}', {_token:'{{ csrf_token() }}', id, status}, function(data){
        // console.log(data);
        if(data.status == 1){
            Snackbar.show({
                text: '{{__('Currency Updated Successfully')}}',
                pos: 'top-right',
                backgroundColor: '#38c172'
            });
        }
        else{
            Snackbar.show({
                text: '{{__('Currency Not updated')}}',
                pos: 'top-right',
                backgroundColor: '#e3342f'
            });
        }
    });
}
</script>
@endpush


@push('scripts')
<script>
    function updateSystem(el, name){
        if($(el).is(':checked')){
            var value = 1;
        }
        else{
            var value = 0;
        }
        $.post('{{ route('admin.setting.sys_settings') }}', {_token:'{{ csrf_token() }}', name:name, value:value}, function(data){
            if(data == '1'){
                Snackbar.show({
                    text: '{{__('Settings Updated Successfully')}}',
                    pos: 'top-right',
                    backgroundColor: '#38c172'
                });
            }
            else{
                Snackbar.show({
                    text: '{{__('Something went wrong')}}',
                    pos: 'top-right',
                    backgroundColor: '#e3342f'
                });
            }
        });
    }
</script>
@endpush
