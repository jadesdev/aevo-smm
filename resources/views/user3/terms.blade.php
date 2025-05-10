@extends('user3.layouts.master')
@section('title', get_setting('page_title'))

@section('content')
<div class="row">
    <div class="col-lg-12 col-12 mb-5 mb-lg-0">
        <div class="card">
            <div class="card-body" id="dc-body">

                <h2 class="mb-5">{{get_setting('page_title')}}</h2>
                <div class="read-text">
                    {!! (get_Setting('page_body')) !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('breadcrumb')
<div class="card dc-dash">
    <div class="row">
        <div class="col-lg-7 col-md-9 col-12">
            <div class="py-3 px-5">
                <div class="dch-title">
                   @yield('title')
                </div>
                <div class="dch-text">
                    {{-- s --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('styles')
    <style>
        .container,
        {
            padding: 8% 0 0;    }


    </style>
@endsection
