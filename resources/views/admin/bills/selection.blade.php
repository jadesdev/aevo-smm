@extends('admin.layouts.master')
@section('title', 'API Selection')

@section('content')

<div class="card">
    <h5 class="card-header text-center mb-2">AIRTIME API</h5>
    <div class="card-body">
        <form action="{{route('admin.setting.api_settings')}}" class="row" method="post">
            @csrf
            <div class="col-md-3 form-group">
                <input type="hidden" name="types[]" value="mtn_airtime">
                <label class="form-label">MTN Airtime</label>
                <select class="form-select" name="mtn_airtime" required>
                    <option @if(api_setting('mtn_airtime') == "legit")selected @endif value="legit">Legit Data</option>
                    <option @if(api_setting('mtn_airtime') == "glad")selected @endif value="glad">Glad Tidings</option>
                    <option @if(api_setting('mtn_airtime') == "n3tdata")selected @endif value="n3tdata">N3tdata</option>
                    <option @if(api_setting('mtn_airtime') == "maska")selected @endif value="maska">Maskawasub</option>
                </select>
            </div>
            <div class="col-md-3 form-group">
                <input type="hidden" name="types[]" value="glo_airtime">
                <label class="form-label">GLO Airtime</label>
                <select class="form-select" name="glo_airtime" required>
                    <option @if(api_setting('glo_airtime') == "legit")selected @endif value="legit">Legit Data</option>
                    <option @if(api_setting('glo_airtime') == "glad")selected @endif value="glad">Glad Tidings</option>
                    <option @if(api_setting('glo_airtime') == "n3tdata")selected @endif value="n3tdata">N3tdata</option>
                    <option @if(api_setting('glo_airtime') == "maska")selected @endif value="maska">Maskawasub</option>
                </select>
            </div>
            <div class="col-md-3 form-group">
                <input type="hidden" name="types[]" value="airtel_airtime">
                <label class="form-label">Airtel Airtime</label>
                <select class="form-select" name="airtel_airtime" required>
                    <option @if(api_setting('airtel_airtime') == "legit")selected @endif value="legit">Legit Data</option>
                    <option @if(api_setting('airtel_airtime') == "glad")selected @endif value="glad">Glad Tidings</option>
                    <option @if(api_setting('airtel_airtime') == "n3tdata")selected @endif value="n3tdata">N3tdata</option>
                    <option @if(api_setting('airtel_airtime') == "maska")selected @endif value="maska">Maskawasub</option>
                </select>
            </div>
            <div class="col-md-3 form-group">
                <input type="hidden" name="types[]" value="mob_airtime">
                <label class="form-label">9Mobile Airtime</label>
                <select class="form-select" name="mob_airtime" required>
                    <option @if(api_setting('mob_airtime') == "legit")selected @endif value="legit">Legit Data</option>
                    <option @if(api_setting('mob_airtime') == "glad")selected @endif value="glad">Glad Tidings</option>
                    <option @if(api_setting('mob_airtime') == "n3tdata")selected @endif value="n3tdata">N3tdata</option>
                    <option @if(api_setting('mob_airtime') == "maska")selected @endif value="maska">Maskawasub</option>
                </select>
            </div>
            <button class="w-100 btn btn-success" type="submit">Save Settings</button>
        </form>
    </div>
</div>
<div class="card">
    <h5 class="card-header text-center mb-2">DATA API</h5>
    <div class="card-body">
        <form action="{{route('admin.setting.api_settings')}}" class="row" method="post">
            @csrf
            <div class="col-md-3 form-group">
                <input type="hidden" name="types[]" value="mtn_data">
                <label class="form-label">MTN Data</label>
                <select class="form-select" name="mtn_data" required>
                    <option @if(api_setting('mtn_data') == "legit")selected @endif value="legit">Legit Data</option>
                    <option @if(api_setting('mtn_data') == "glad")selected @endif value="glad">Glad Tidings</option>
                    <option @if(api_setting('mtn_data') == "n3tdata")selected @endif value="n3tdata">N3tdata</option>
                    <option @if(api_setting('mtn_data') == "maska")selected @endif value="maska">Maskawasub</option>
                </select>
            </div>
            <div class="col-md-3 form-group">
                <input type="hidden" name="types[]" value="glo_data">
                <label class="form-label">GLO Data</label>
                <select class="form-select" name="glo_data" required>
                    <option @if(api_setting('glo_data') == "legit")selected @endif value="legit">Legit Data</option>
                    <option @if(api_setting('glo_data') == "glad")selected @endif value="glad">Glad Tidings</option>
                    <option @if(api_setting('glo_data') == "n3tdata")selected @endif value="n3tdata">N3tdata</option>
                    <option @if(api_setting('glo_data') == "maska")selected @endif value="maska">Maskawasub</option>
                </select>
            </div>
            <div class="col-md-3 form-group">
                <input type="hidden" name="types[]" value="airtel_data">
                <label class="form-label">Airtel Data</label>
                <select class="form-select" name="airtel_data" required>
                    <option @if(api_setting('airtel_data') == "legit")selected @endif value="legit">Legit Data</option>
                    <option @if(api_setting('airtel_data') == "glad")selected @endif value="glad">Glad Tidings</option>
                    <option @if(api_setting('airtel_data') == "n3tdata")selected @endif value="n3tdata">N3tdata</option>
                    <option @if(api_setting('airtel_data') == "maska")selected @endif value="maska">Maskawasub</option>
                </select>
            </div>
            <div class="col-md-3 form-group">
                <input type="hidden" name="types[]" value="mob_data">
                <label class="form-label">9Mobile Data</label>
                <select class="form-select" name="mob_data" required>
                    <option @if(api_setting('mob_data') == "legit")selected @endif value="legit">Legit Data</option>
                    <option @if(api_setting('mob_data') == "glad")selected @endif value="glad">Glad Tidings</option>
                    <option @if(api_setting('mob_data') == "n3tdata")selected @endif value="n3tdata">N3tdata</option>
                    <option @if(api_setting('mob_data') == "maska")selected @endif value="maska">Maskawasub</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success w-100">Save Settings</button>
        </form>
    </div>
</div>
<div class="card">
    <h5 class="card-header text-center mb-2">DATACARD API</h5>
    <div class="card-body">
        <form action="{{route('admin.setting.api_settings')}}" class="row" method="post">
            @csrf
            <div class="col-md-3 form-group">
                <input type="hidden" name="types[]" value="mtn_datacard">
                <label class="form-label">MTN Datacard</label>
                <select class="form-select" name="mtn_datacard" required>
                    <option @if(api_setting('mtn_datacard') == "legit")selected @endif value="legit">Legit Data</option>
                    <option @if(api_setting('mtn_datacard') == "glad")selected @endif value="glad">Glad Tidings</option>
                    <option @if(api_setting('mtn_datacard') == "n3tdata")selected @endif value="n3tdata">N3tdata</option>
                    <option @if(api_setting('mtn_datacard') == "maska")selected @endif value="maska">Maskawasub</option>
                </select>
            </div>
            <div class="col-md-3 form-group">
                <input type="hidden" name="types[]" value="glo_datacard">
                <label class="form-label">GLO Datacard</label>
                <select class="form-select" name="glo_datacard" required>
                    <option @if(api_setting('glo_datacard') == "legit")selected @endif value="legit">Legit Data</option>
                    <option @if(api_setting('glo_datacard') == "glad")selected @endif value="glad">Glad Tidings</option>
                    <option @if(api_setting('glo_datacard') == "n3tdata")selected @endif value="n3tdata">N3tdata</option>
                    <option @if(api_setting('glo_datacard') == "maska")selected @endif value="maska">Maskawasub</option>
                </select>
            </div>
            <div class="col-md-3 form-group">
                <input type="hidden" name="types[]" value="airtel_datacard">
                <label class="form-label">Airtel Datacard</label>
                <select class="form-select" name="airtel_datacard" required>
                    <option @if(api_setting('airtel_datacard') == "legit")selected @endif value="legit">Legit Data</option>
                    <option @if(api_setting('airtel_datacard') == "glad")selected @endif value="glad">Glad Tidings</option>
                    <option @if(api_setting('airtel_datacard') == "n3tdata")selected @endif value="n3tdata">N3tdata</option>
                    <option @if(api_setting('airtel_datacard') == "maska")selected @endif value="maska">Maskawasub</option>
                </select>
            </div>
            <div class="col-md-3 form-group">
                <input type="hidden" name="types[]" value="mob_datacard">
                <label class="form-label">9Mobile Datacard</label>
                <select class="form-select" name="mob_datacard" required>
                    <option @if(api_setting('mob_datacard') == "legit")selected @endif value="legit">Legit Data</option>
                    <option @if(api_setting('mob_datacard') == "glad")selected @endif value="glad">Glad Tidings</option>
                    <option @if(api_setting('mob_datacard') == "n3tdata")selected @endif value="n3tdata">N3tdata</option>
                    <option @if(api_setting('mob_datacard') == "maska")selected @endif value="maska">Maskawasub</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success w-100">Save Settings</button>
        </form>
    </div>
</div>
<div class="card">
    <h5 class="card-header text-center mb-2">AIRTIMEPIN API</h5>
    <div class="card-body">
        <form action="{{route('admin.setting.api_settings')}}" class="row" method="post">
            @csrf
            <div class="col-md-3 form-group">
                <input type="hidden" name="types[]" value="mtn_airtimepin">
                <label class="form-label">MTN Airtimepin</label>
                <select class="form-select" name="mtn_airtimepin" required>
                    <option @if(api_setting('mtn_airtimepin') == "legit")selected @endif value="legit">Legit Data</option>
                    <option @if(api_setting('mtn_airtimepin') == "glad")selected @endif value="glad">Glad Tidings</option>
                    <option @if(api_setting('mtn_airtimepin') == "n3tdata")selected @endif value="n3tdata">N3tdata</option>
                    <option @if(api_setting('mtn_airtimepin') == "maska")selected @endif value="maska">Maskawasub</option>
                </select>
            </div>
            <div class="col-md-3 form-group">
                <input type="hidden" name="types[]" value="glo_airtimepin">
                <label class="form-label">GLO Airtimepin</label>
                <select class="form-select" name="glo_airtimepin" required>
                    <option @if(api_setting('glo_airtimepin') == "legit")selected @endif value="legit">Legit Data</option>
                    <option @if(api_setting('glo_airtimepin') == "glad")selected @endif value="glad">Glad Tidings</option>
                    <option @if(api_setting('glo_airtimepin') == "n3tdata")selected @endif value="n3tdata">N3tdata</option>
                    <option @if(api_setting('glo_airtimepin') == "maska")selected @endif value="maska">Maskawasub</option>
                </select>
            </div>
            <div class="col-md-3 form-group">
                <input type="hidden" name="types[]" value="airtel_airtimepin">
                <label class="form-label">Airtel Airtimepin</label>
                <select class="form-select" name="airtel_airtimepin" required>
                    <option @if(api_setting('airtel_airtimepin') == "legit")selected @endif value="legit">Legit Data</option>
                    <option @if(api_setting('airtel_airtimepin') == "glad")selected @endif value="glad">Glad Tidings</option>
                    <option @if(api_setting('airtel_airtimepin') == "n3tdata")selected @endif value="n3tdata">N3tdata</option>
                    <option @if(api_setting('airtel_airtimepin') == "maska")selected @endif value="maska">Maskawasub</option>
                </select>
            </div>
            <div class="col-md-3 form-group">
                <input type="hidden" name="types[]" value="mob_airtimepin">
                <label class="form-label">9Mobile Airtimepin</label>
                <select class="form-select" name="mob_airtimepin" required>
                    <option @if(api_setting('mob_airtimepin') == "legit")selected @endif value="legit">Legit Data</option>
                    <option @if(api_setting('mob_airtimepin') == "glad")selected @endif value="glad">Glad Tidings</option>
                    <option @if(api_setting('mob_airtimepin') == "n3tdata")selected @endif value="n3tdata">N3tdata</option>
                    <option @if(api_setting('mob_airtimepin') == "maska")selected @endif value="maska">Maskawasub</option>
                </select>
            </div>
            <button class="w-100 btn btn-success" type="submit">Save Settings</button>
        </form>
    </div>
</div>

<div class="card">
    <h6 class="card-header">API Selection</h6>
    <div class="card-body">
        <form action="{{route('admin.setting.api_settings')}}" class="row" method="post">
            @csrf
            <div class="col-md-4 form-group">
               <input type="hidden" name="types[]" value="cable_api">
                <label class="form-label">Cable API</label>
                <select class="form-select" name="cable_api" required>
                    <option @if(api_setting('cable_api') == "glad")selected @endif value="glad">Glad Tidings</option>
                    <option @if(api_setting('cable_api') == "n3tdata")selected @endif value="n3tdata">N3tdata</option>
                    <option @if(api_setting('cable_api') == "maska")selected @endif value="maska">Maskawasub</option>
                    <option @if(api_setting('cable_api') == "legit")selected @endif value="legit">Legit Data</option>
                </select>
            </div>
            <div class="col-md-4 form-group">
               <input type="hidden" name="types[]" value="power_api">
                <label class="form-label">Electricity API</label>
                <select class="form-select" name="power_api" required>
                    <option @if(api_setting('power_api') == "glad")selected @endif value="glad">Glad Tidings</option>
                    <option @if(api_setting('power_api') == "n3tdata")selected @endif value="n3tdata">N3tdata</option>
                    <option @if(api_setting('power_api') == "maska")selected @endif value="maska">Maskawasub</option>
                    <option @if(api_setting('power_api') == "legit")selected @endif value="legit">Legit Data</option>
                </select>
            </div>
            <div class="col-md-4 form-group">
               <input type="hidden" name="types[]" value="exam_api">
                <label class="form-label">Exam API</label>
                <select class="form-select" name="exam_api" required>
                    <option @if(api_setting('exam_api') == "glad")selected @endif value="glad">Glad Tidings</option>
                    <option @if(api_setting('exam_api') == "n3tdata")selected @endif value="n3tdata">N3tdata</option>
                    <option @if(api_setting('exam_api') == "legit")selected @endif value="legit">Legit Data</option>
                    <option @if(api_setting('exam_api') == "maska")selected @endif value="maska">Maskawasub</option>
                </select>
            </div>
            <div class="col-md-4 form-group">
               <input type="hidden" name="types[]" value="bulksms">
                <label class="form-label">BulkSMS API</label>
                <select class="form-select" name="bulksms" required>
                    <option @if(api_setting('bulksms') == "legit")selected @endif value="legit">Legit Data</option>
                    <option @if(api_setting('bulksms') == "n3tdata")selected @endif value="n3tdata">N3tdata</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary w-100">Save Settings</button>

        </form>
    </div>
</div>
@endsection

@section('breadcrumb')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">@yield('title')</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>
                    <li class="breadcrumb-item active">@yield('title')</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->
@endsection

@section('scripts')
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
@endsection
@section('styles')
<style>
    .card-header{background-color: #fefefe; border-bottom:1px solid #949d94 }
</style>
@endsection
