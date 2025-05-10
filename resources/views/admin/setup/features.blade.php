@extends('admin.layouts.master')
@section('title', 'Features Activation')

@section('content')
<div class="row">
    <div class="col-lg-6">
        <div class="d-card">
            <div class="card-header">
                <h3 class="mb-0 h6 ">Maintenance Mode</h3>
            </div>
            <div class="d-card-body">
                <label class="jdv-switch jdv-switch-success mb-0">
                    <input type="checkbox" onchange="updateSystem(this, 'is_maintenance')" @if(sys_setting('is_maintenance') == 1) checked @endif >
                    <span class="slider round"></span>
                </label>
            </div>
        </div>
    </div>
    
    <div class="col-lg-6">
        <div class="d-card">
            <div class="card-header">
                <h3 class="mb-0 h6">Email Verification</h3>
            </div>
            <div class="d-card-body">
                <label class="jdv-switch jdv-switch-success mb-0">
                    <input type="checkbox" onchange="updateSystem(this, 'verify_email')" @if(sys_setting('verify_email') == 1) checked @endif >
                    <span class="slider round"></span>
                </label>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="d-card">
            <div class="card-header">
                <h3 class="mb-0 h6 ">Force Https</h3>
            </div>
            <div class="d-card-body ">
                <label class="jdv-switch jdv-switch-success mb-0">
                    <input type="checkbox" onchange="updateSystem(this, 'is_https')" @if(sys_setting('is_https') == 1) checked @endif >
                    <span class="slider round"></span>
                </label>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="d-card">
            
            <div class="d-card-body">
                <form action="{{route('admin.setting.store_settings')}}" method="post">
                    @csrf
                    <div class="form-group">
                        <input type="hidden" name="types[]" value="homepage_theme">
                        <label class="form-label">Select Homepage Theme</label>
                        <select name="homepage_theme" required class="form-control">
                            <option value="" disabled>Select Theme</option>
                            <option value="theme1" @if (sys_setting('homepage_theme') == "theme1") selected @endif>Theme 1</option>
                         
                            <option value="theme4" @if (sys_setting('homepage_theme') == "theme4" )selected @endif>Theme 2</option>
                        </select>
                    </div>

                    <button type="submit" class="btn  btn-primary w-100">Save</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-4" style="display:none;">
        <div class="d-card">
            <div class="card-header">
                <h3 class="mb-0 h6 ">Listing Rate</h3>
            </div>
            <div class="d-card-body">
                <form action="{{route('admin.setting.store_settings')}}" method="post">
                    @csrf
                    <div class="form-group">
                        <input type="hidden" name="types[]" value="seller_rate">
                        <label class="form-label">Seller Rate</label>
                        <input type="text" name="seller_rate" value="{{sys_setting('seller_rate')}}" class="form-control" required>
                    </div>

                    <button type="submit" class="brn btn-md w-100 btn-success">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('breadcrumb')
<div class="d-card dc-dash">
    <div class="row">
        <div class="col-lg-6 col-md-8 col-12">
            <div class="py-3 px-5">
                <div class="dch-title">
                   @yield('title')
                </div>
                <div class="dch-text">
                   Activate and modify features
                </div>
            </div>
        </div>
    </div>
</div>
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
    .d-card{
        margin-bottom: 10px;
    }
    .card-header{
    font-size: 15px;
    padding: 15px 20px 0px 20px !important;
    margin-bottom: 0;
    background-color: transparent;
    border: 0; }




</style>
@endsection
