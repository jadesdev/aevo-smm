@extends('admin.layouts.master')
@section('title', 'Data Plans')

@section('content')
<div class="d-card">
    <h5 class="card-header">All Networks</h5>
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
                @foreach ($networks as $key => $network)
                <tr>
                    <td>{{$key +1}}</td>
                    <td>{{$network->name}}</td>
                    <td> {{$network->datasub->count()}}</td>
                    <td><span class="badge @if($network->data == 1)bg-success @else bg-danger @endif">@if($network->data == 1)active @else disabled @endif </span></td>
                    <td>
                        <div class="">
                            <a class="btn btn-sm btn-secondary" href="{{route('admin.bills.data.plans', $network->id)}}" >Data Plans</a>
                            @if($network->data == 1)
                            <a class="btn btn-warning btn-sm" href="{{route('admin.bills.data.status' ,[$network->id, 0])}}">Disable</a> @else
                            <a class="btn btn-info btn-sm" href="{{route('admin.bills.data.status' ,[$network->id, 1])}}">Enable</a>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection

@section('styles')
<style>
    .img-table{ height:50px ;}
    .card-header{border-bottom:1px solid #949d94 }
    body.light .card-header{color: #fefefe; border:1px solid #949d94 }

</style>
@endsection
