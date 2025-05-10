@extends('admin.layouts.master')
@section('title', 'Custom CSS & JS')

@section('content')
<div class="d-card">
    <h4 class="fw-bold card-header">@yield('title')</h4>
    <div class="d-card-body">
        <form action="{{route('admin.setting.update')}}"  method="post">
            @csrf
            <div class="form-group">
                <label for="" class="form-label">Custom CSS</label>
                <textarea class="form-control" name="custom_css" placeholder="<style> ... </style>" rows="10">{{get_setting('custom_css')}}</textarea>
            </div>
            <div class="form-group mt-2">
                <label for="" class="form-label">Custom Javascripts</label>
                <textarea class="form-control" name="custom_js" placeholder="<script> ... </script>" rows="10">{{get_setting('custom_js')}}</textarea>
            </div>
            <div class="form-group text-end">
                <button type="submit" class="btn btn-primary w-100">Save</button>
            </div>
        </form>
    </div>
</div>
@endsection

