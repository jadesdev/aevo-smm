@extends('admin.layouts.master')
@section('title', 'API Settings')

@section('content')
<h5 class="card-header text-center mb-2">API Settings</h5>
<div class="row mb-3">
    <div class="col-md-6">
        <div class="d-card">
            <h6 class="card-header">GLADTIDINGS API</h6>
            <div class="d-card-body">
                <form action="{{route('admin.setting.env_key')}}" method="post">
                    @csrf
                    <div class="form-group">
                        <input type="hidden" name="types[]" value="GLADTIDING_API">
                        <label class="form-label">API Key</label>
                        <input type="text" class="form-control" name="GLADTIDING_API" value="{{ env('GLADTIDING_API') }}" placeholder="GLADTIDING API Key">
                    </div>
                    <div class="form-group">
                        <button class="btn btn-success w-100" type="submit">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<h5 class="text-center card-header mb-2 fw-bold ">Services Activation</h5>
<div class="row g-3">
    <div class="col-sm-6 col-md-3">
        <div class="d-card">
            <div class="card-header">
                <h3 class="mb-0 h6 text-center">Data</h3>
            </div>
            <div class="d-card-body text-center">
                <label class="jdv-switch jdv-switch-success mb-0">
                    <input type="checkbox" onchange="updateSystem(this, 'is_data')" @if(sys_setting('is_data') == 1) checked @endif >
                    <span class="slider round"></span>
                </label>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="d-card">
            <div class="card-header">
                <h3 class="mb-0 h6 text-center">Airtime</h3>
            </div>
            <div class="d-card-body text-center">
                <label class="jdv-switch jdv-switch-success mb-0">
                    <input type="checkbox" onchange="updateSystem(this, 'is_airtime')" @if(sys_setting('is_airtime') == 1) checked @endif >
                    <span class="slider round"></span>
                </label>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-md-3">
        <div class="d-card">
            <div class="card-header">
                <h3 class="mb-0 h6 text-center">Cable TV</h3>
            </div>
            <div class="d-card-body text-center">
                <label class="jdv-switch jdv-switch-success mb-0">
                    <input type="checkbox" onchange="updateSystem(this, 'is_cable')" @if(sys_setting('is_cable') == 1) checked @endif >
                    <span class="slider round"></span>
                </label>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-md-3">
        <div class="d-card">
            <div class="card-header">
                <h3 class="mb-0 h6 text-center">Electricity</h3>
            </div>
            <div class="d-card-body text-center">
                <label class="jdv-switch jdv-switch-success mb-0">
                    <input type="checkbox" onchange="updateSystem(this, 'is_power')" @if(sys_setting('is_power') == 1) checked @endif >
                    <span class="slider round"></span>
                </label>
            </div>
        </div>
    </div>
</div>
@endsection

@section('breadcrumb')

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
@section('styles')
<style>
    .card-header{border-bottom:1px solid #949d94 }
    body.light .card-header{color: #fefefe; border:1px solid #949d94 }
    .g-3{row-gap: 1rem;}
</style>
@endsection
