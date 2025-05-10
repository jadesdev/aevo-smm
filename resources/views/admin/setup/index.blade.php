@extends('admin.layouts.master')
@section('title', 'General Settings')

@section('content')
<div class="d-card">
    <div class="card-header h4">Website Information </div>
    <div class="d-card-body">
        <form action="{{route('admin.setting.update')}}" method="post" class="row">
            @csrf
            <div class="col-lg-6">
                <div class="form-group row">
                    <label class="col-sm-3 form-label">@lang('Website Name')</label>
                    <div class="col-sm-9">
                        <input type="text" name="title" class="form-control" value="{{ get_setting('title') }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 form-label">@lang('Website Email')</label>
                    <div class="col-sm-9">
                        <input type="text" name="email" class="form-control" value="{{ get_setting('email') }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 form-label">@lang('Homepage Text')</label>
                    <div class="col-sm-9">
                        <input type="text" name="about" class="form-control" value="{{ get_setting('about') }}">
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group row">
                    <label class="col-sm-3 form-label">@lang('Website Phone')</label>
                    <div class="col-sm-9">
                        <input type="tel" name="phone" class="form-control" value="{{ get_setting('phone') }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 form-label">@lang('Website About')</label>
                    <div class="col-sm-9">
                        <textarea name="description" style="height: 100px;" rows="3" class="form-control">{{ get_setting('description') }}</textarea>
                    </div>
                </div>
            </div>
            <button class="btn-success btn w-100" type="submit">Save Settings</button>
        </form>
    </div>
</div>
<div class="d-card">
    <div class="card-header h4">Logo/Image Settings</div>
    <div class="d-card-body">
        <form class="row" action="{{route('admin.setting.update')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group col-lg-6">
                <label class="form-label">@lang('Site Logo')</label>
                <div class="col-sm-12 row">
                    <input type="file" class="form-control" style="padding: 5px 20px;" name="logo" accept="image/*"/>
                    <img class="primage mt-2" src="{{ my_asset(get_setting('logo'))}}" alt="Site Logo" >
                </div>
            </div>
            <div class="form-group col-lg-6">
                <label class="form-label">@lang('Favicon')</label>
                <div class="col-sm-12">
                    <input type="file"  style="padding: 5px 20px;" class="form-control" name="favicon" accept="image/*"/>
                    <img class="primage mt-2" src="{{ my_asset(get_setting('favicon'))}}" alt="Favicon" >
                </div>
            </div>
            <div class="w-100">
                <button class="btn btn-success btn-block" type="submit">@lang('Update Setting')</button>
            </div>
        </form>
    </div>
</div>
<div class="d-card">
    <div class="card-header h4">Currency Settings</div>
    <div class="d-card-body">
        <form class="row" action="{{route('admin.setting.update')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group col-sm-6 ">
                <label class="form-label">Currency Symbol</label>
                <input type="text" class="form-control" name="currency" value="{{get_setting('currency')}}" required placeholder="Currency Symbol"/>
            </div>
            <div class="form-group col-sm-6">
                <label class="form-label">Currency Code</label>
                <input type="text" class="form-control" name="currency_code" value="{{get_setting('currency_code')}}" required placeholder="Currency Code"/>
            </div>
            <div class="w-100">
                <button class="btn btn-success btn-block" type="submit">@lang('Update Setting')</button>
            </div>
        </form>
    </div>
</div>




<div class="row">
    
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
        

    </div>



<div class="d-card">
    <div class="card-header h4">Terms and Conditions</div>
    <div class="d-card-body">
        <form action="{{route('admin.setting.update')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="form-label">Page Title</label>
                <input type="text" class="form-control" name="page_title" value="{{get_setting('page_title')}}" required placeholder="Page Title"/>
            </div>
            <div class="form-group">
                <label class="form-label">Page Body</label>
                <textarea class="form-control text-editor" name="page_body" rows="5" required placeholder="Page Body">{{get_setting('page_body')}}</textarea>
            </div>
            <div class="w-100">
                <button class="btn btn-success btn-block" type="submit">@lang('Update Page')</button>
            </div>
        </form>
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

@section('styles')
<style>
    .primage {
        max-height: 50px !important;
        max-width: 150px !important;
        margin: 0;
    }
    
    .btn-block{ width: 100% !important; }
    .d-card{margin-bottom: 15px;}
</style>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script>
    $(document).ready(function() {
        $('.text-editor').summernote({
            tabsize: 2,
            height: 300
        });
    });
</script>
@endpush
