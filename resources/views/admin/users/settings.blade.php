@extends('admin.layouts.master')
@section('title', 'User Settings')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="d-card">
            <div class="card-header">
                <h5>Welcome Bonus</h5>
            </div>
            <div class="d-card-body">
                <label class="jdv-switch jdv-switch-success mb-0">
                    <span class="mr-3">Activation </span>
                    <input type="checkbox" onchange="updateSystem(this, 'is_welcome_bonus')" @if(sys_setting('is_welcome_bonus') == 1) checked @endif >
                    <span class="slider round"></span>
                </label>
                <form action="{{route('admin.setting.store_settings')}}" method="post">
                    @csrf
                    <div class="form-group">
                        <input type="hidden" name="types[]" value="welcome_bonus">
                        <label class="form-label">Welcome Bonus</label>
                        <input name="welcome_bonus" type="number" required class="form-control" placeholder="welcoome bonus"  value="{{ sys_setting('welcome_bonus') }}" />
                    </div>

                    <button type="submit" class="brn btn-md w-100 btn-success">Save</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="d-card">
            <div class="card-header">
                <h5>Welcome Message</h5>
            </div>
            <div class="d-card-body">
                <label class="jdv-switch jdv-switch-success mb-0">
                    <span class="mr-3">Activation </span>
                    <input type="checkbox" onchange="updateSystem(this, 'is_welcome_message')" @if(sys_setting('is_welcome_message') == 1) checked @endif >
                    <span class="slider round"></span>
                </label>
                <form action="{{route('admin.setting.store_settings')}}" method="post">
                    @csrf
                    <div class="form-group">
                        <input type="hidden" name="types[]" value="welcome_message">
                        <label class="form-label">Welcome Message</label>
                        <textarea name="welcome_message" id="welcomeMessage" class="form-control" cols="5" rows="5">{{ sys_setting('welcome_message') }}</textarea>
                    </div>

                    <button type="submit" class="brn btn-md w-100 btn-primary">Save</button>
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
                    Manage User accounts.
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
    .card-header{border-bottom:1px solid #949d94 }
</style>
@endsection
