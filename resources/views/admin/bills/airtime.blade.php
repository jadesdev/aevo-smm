@extends('admin.layouts.master')
@section('title', 'Airtime')

@section('content')
<div class="d-card">
    <h5 class="card-header">All Networks</h5>
    <div class="d-card-body table-responsive">
        <table class="table table-bordered table-hover" id="datatable">
            <thead class="white">
                <tr>
                <th>S/N</th>
                <th>Name</th>
                <th>Discount</th>
                <th>Status</th>
                <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($networks as $key => $network)
                <tr>
                    <td>{{$key +1}}</td>
                    <td>{{$network->name}}</td>
                    <td>{{($network->discount)}}%</td>
                    <td><span class="badge @if($network->airtime == 1)bg-success @else bg-danger @endif">@if($network->airtime == 1)active @else disabled @endif </span></td>
                    <td>
                        <div class="dropdown">
                            <a class="btn btn-info btn-sm" data-toggle="modal" data-target="#edit_modal-{{$network->id}}"  href="#" title="@lang('Edit')"> <i class="fa fa-edit"></i></a>
                            @if($network->airtime == 1)
                            <a class="btn btn-danger btn-sm" href="{{route('admin.bills.airtime.status' ,[$network->id, 0])}}">Disable</a> @else
                            <a class="btn btn-success btn-sm" href="{{route('admin.bills.airtime.status' ,[$network->id, 1])}}">Enable</a>
                            @endif


                        </div>
                    </td>
                </tr>
                {{-- edit modals --}}
                <div class="modal fade" id="edit_modal-{{$network->id}}" tabindex="-1"  aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title fw-bold">Edit Network</h5>
                        </div>
                        <div class="modal-body">
                            <form action="{{route('admin.bills.airtime.update',$network->id)}}" enctype="multipart/form-data" method="post">
                                @csrf
                                <div class="form-group" hidden>
                                    <label class="form-label">Minimum Account</label>
                                    <input type="number" class="form-control" name="minimum" placeholder="minimum airtime" value="{{$network->minimum}}" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">API Code</label>
                                    <input type="text" class="form-control" value="{{$network->code}}" name="code" placeholder="Plan Code" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Airtime Discount</label>
                                    <input type="text" class="form-control" value="{{$network->discount}}" name="discount" placeholder="discount" required>
                                </div>
                                <div class="form-group">
                                    <button class="btn-success w-100 btn" type="submit">Update</button>
                                </div>
                            </form>
                        </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection

@section('breadcrumb')
<!-- start page title -->
<!-- end page title -->
@endsection

@section('scripts')
@endsection
@section('styles')
<style>
    .img-table{ height:50px ;}
    .card-header{background-color: #fefefe; border-bottom:1px solid #949d94 }
</style>
@endsection
