@extends('admin.layouts.master')
@section('title', 'CableTV Plans')

@section('content')
<div class="d-card">
    <div class="card-header">
        <div class="d-flex align-items-center justify-content-between">
        <h5>All {{$decoder->name}} Plans</h5>
        <a class="btn btn-primary btn-sm" href="#" data-toggle="modal" data-target="#createPlan"><i class="fas fa-plus"></i> New Plan</a>
        </div>
    </div>
    <div class="d-card-body table-responsive">
        <table class="table table-bordered table-hover" id="datatable">
            <thead class="white">
                <tr>
                <th>S/N</th>
                <th>Name</th>
                {{-- <th>Decoder</th> --}}
                <th>Amount</th>
                <th>Status</th>
                <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($plans as $key => $plan)
                <tr>
                    <td>{{$key +1}}</td>
                    <td>{{$plan->name}}</td>
                    {{-- <td>{{$plan->decoder->name}}</td> --}}
                    <td> {{format_price($plan->price)}}</td>
                    <td><span class="badge @if($plan->status == 1)bg-success @else bg-danger @endif">@if($plan->status == 1)active @else disabled @endif </span></td>
                    <td>
                        <div class="dropdown">
                            <a class="btn btn-info btn-sm" data-toggle="modal" data-target="#editPlan-{{$plan->id}}"  href="#" title="@lang('Edit Plan')"><i class="fa fa-edit"></i></a>
                            @if($plan->status == 1)
                            <a class="btn btn-sm btn-warning" href="{{route('admin.bills.cableplan.status' ,[$plan->id, 0])}}">Disable</a> @else
                            <a class="btn btn-success btn-sm" href="{{route('admin.bills.cableplan.status' ,[$plan->id, 1])}}">Enable</a>
                            @endif
                            <a class="btn btn-danger btn-sm" href="{{route('admin.bills.cableplan.delete' ,[$plan->id])}}" title="Delete"><i class="fa fa-trash"></i></a>
                        </div>
                    </td>
                </tr>
                <div class="modal fade" id="editPlan-{{$plan->id}}" tabindex="-1"  aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title fw-bold">Edit Plan</h5>
                        </div>
                        <div class="modal-body">
                            <form action="{{route('admin.bills.cabletv.edit', $plan->id)}}"enctype="multipart/form-data" method="post">
                                @csrf
                                <input type="hidden" name="decoder_id" value="{{$decoder->id}}">
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label class="form-label">Decoder</label>
                                        <input type="text" readonly class="form-control" value="{{$decoder->name}}">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label class="form-label">Name</label>
                                        <input type="text" class="form-control" name="name" value="{{$plan->name}}" placeholder="Plan Name" required>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label class="form-label">Plan Code</label>
                                        <input type="text" class="form-control" name="code" value="{{$plan->code}}" placeholder="Plan Code" required>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label class="form-label">Price</label>
                                        <input type="number" class="form-control" name="price" value="{{$plan->price}}" placeholder="Plan Price" required>
                                    </div>
                                    <div class="form-group col-12 mb-0">
                                        <button class=" w-100 btn btn-success" type="submit">Edit Plan</button>
                                    </div>
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
<div class="modal fade" id="createPlan" tabindex="-1"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title fw-bold">Create Data Plan</h5>
        </div>
        <div class="modal-body">
            <form action="{{route('admin.bills.cabletv.create')}}" class="row" enctype="multipart/form-data" method="post">
                @csrf
                <input type="hidden" name="decoder_id" value="{{$decoder->id}}">
                <div class="form-group col-sm-6">
                    <label class="form-label">Decoder</label>
                    <input type="text" readonly class="form-control" value="{{$decoder->name}}">
                </div>
                <div class="form-group col-sm-6">
                    <label class="form-label">Name</label>
                    <input type="text" class="form-control" name="name" placeholder="Plan Name" required>
                </div>
                <div class="form-group col-sm-6">
                    <label class="form-label">Plan Code</label>
                    <input type="text" class="form-control" name="code" placeholder="Plan Code" required>
                </div>
                <div class="form-group col-sm-6">
                    <label class="form-label">Price</label>
                    <input type="number" class="form-control" name="price" placeholder="Plan Price" required>
                </div>
                <div class="form-group col-12 mb-0 text-end">
                    <button class="btn-success btn w-100" type="submit">Create Plan</button>
                </div>
            </form>
        </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@endsection
@section('styles')
<style>
    .img-table{ height:40px ;}
    .card-header{ border-bottom:1px solid #949d94 }
</style>
@endsection
