@extends('admin.layouts.master')
@section('title', 'Email Settings')

@section('content')

<div class="row">
        <div class="col-md-6">
            <div class="d-card">
                <h5 class="card-header">Referral Settings</h5>
                <div class="d-card-body">
                    <form action="{{ route('admin.setting.store_settings') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="">Referral Commission</label>
                            <input type="hidden" name="types[]" value="referral_commission">
                            <div class="input-group">
                                <input type="text" class="form-control" name="referral_commission" placeholder="Referral Commission" value="{{ sys_setting('referral_commission') }}" required>
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-info text-white">%</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Minimum Withdrawal</label>
                            <input type="hidden" name="types[]" value="min_withdraw">
                            <div class="input-group">
                                <input type="text" class="form-control" name="min_withdraw" placeholder="Minimum Withdrawal" value="{{ sys_setting('min_withdraw') }}" required>
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-info text-white">{{get_setting('currency')}}</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-0">
                            <button class="btn btn-success w-100" type="submit">Update Settings</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="d-card">
                <h5 class="card-header">Referral Bonus</h5>
                <div class="d-card-body text-center">
                    <label class="jdv-switch jdv-switch-success mb-0">
                        <input type="checkbox" onchange="updateSystem(this, 'is_affiliate')"
                            @if (sys_setting('is_affiliate') == 1) checked @endif>
                        <span class="slider round"></span>
                    </label>
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
