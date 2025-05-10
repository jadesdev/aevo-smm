@extends('admin.layouts.master')
@section('title') @lang('Point System') @stop
@section('content')
<div class="d-card">
    {{-- <h5 class="card-header fw-bold">@lang('Point System') </h5> --}}

    <div class="d-card-body row">
        <div class="col-md-4 col-lg-3">
            <div class="d-card mb-2">
                <h5 class="card-header">Point System</h5>
                <div class="d-card-body text-center">
                    <label class="jdv-switch jdv-switch-success mb-0">
                        <input type="checkbox" onchange="updateSystem(this, 'point_system')" @if (sys_setting('point_system') == 1) checked @endif>
                        <span class="slider round"></span>
                    </label>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-lg-3">
            <div class="d-card mb-2">
                <h5 class="card-header">Point Withdraw</h5>
                <div class="d-card-body text-center">
                    <label class="jdv-switch jdv-switch-success mb-0">
                        <input type="checkbox" onchange="updateSystem(this, 'point_withdraw')" @if (sys_setting('point_withdraw') == 1) checked @endif>
                        <span class="slider round"></span>
                    </label>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-lg-3">
            <div class="d-card mb-2">
                <div class="card-header">
                    <h3 class="mb-0 h6 ">Point Rate</h3>
                </div>
                <div class="d-card-body">
                    <form action="{{route('admin.setting.store_settings')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <input type="hidden" name="types[]" value="point_value">
                            <label class="form-label">{{get_setting('currency_code')}} to 1 {{sys_setting('point_code')}} <small>(how much give 1 point)</small> </label>
                            <input type="text" name="point_value" value="{{sys_setting('point_value')}}" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <input type="hidden" name="types[]" value="point_rate">
                            <label class="form-label">Point Conversion Rate</label>
                            <input type="text" name="point_rate" value="{{sys_setting('point_rate')}}" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="types[]" value="point_code">
                            <label class="form-label">Point Code</label>
                            <input type="text" name="point_code" value="{{sys_setting('point_code')}}" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="types[]" value="point_minimum">
                            <label class="form-label">Minimum Point Withdraw</label>
                            <input type="text" name="point_minimum" value="{{sys_setting('point_minimum')}}" class="form-control" required>
                        </div>

                        <button type="submit" class="brn btn-md w-100 btn-success">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('styles')
@endsection

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
