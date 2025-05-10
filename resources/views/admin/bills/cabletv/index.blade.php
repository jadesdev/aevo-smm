@extends('admin.layouts.master')
@section('title', 'Decoders')

@section('content')
<div class="d-card">
    <h5 class="card-header">Cable TV Subscription</h5>
    <div class="d-card-body table-responsive">
        <table class="table table-bordered table-hover" id="datatable">
            <thead class="white">
                <tr>
                <th>S/N</th>
                <th>Name</th>
                <th>Plans</th>
                <th>Status</th>
                <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($decoders as $key => $decoder)
                <tr>
                    <td>{{$key +1}}</td>
                    <td>{{$decoder->name}}</td>
                    <td> {{$decoder->plans->count()}}</td>
                    <td><span class="badge @if($decoder->status == 1)badge-success @else badge-danger @endif">@if($decoder->status == 1)active @else disabled @endif </span></td>
                    <td>
                        <div class="drop">
                            <a class="btn btn-sm btn-info " href="{{route('admin.bills.cabletv.plans', $decoder->id)}}" >Data Plans</a>
                            @if($decoder->status == 1)
                            <a class="btn btn-sm btn-warning" href="{{route('admin.bills.cabletv.status' ,[$decoder->id, 0])}}">Disable</a> @else
                            <a class="btn btn-sm btn-success" href="{{route('admin.bills.cabletv.status' ,[$decoder->id, 1])}}">Enable</a>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="hidden">
        <h5 class="card-header">Cable TV Discount</h5>
        <div class="card-body mt-1">
            <form action="{{route('admin.setting.store_settings')}}" class="row" method="post">
            @csrf
                <div class="col-md-6 form-group">
                <input type="hidden" name="types[]" value="cable_discount">
                    <label class="form-label">Cable Discount(%)</label>
                    <input class="form-control" name="cable_discount" value="{{sys_setting('cable_discount')}}" required placeholder="99">
                </div>
                <div class="col-12 form-group">
                    <button class="btn btn-success w-100" type="submit">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
@endsection
@section('styles')
<style>
    .img-table{ height:50px ;}
    .card-header{border-bottom:1px solid #949d94 }
</style>
@endsection
