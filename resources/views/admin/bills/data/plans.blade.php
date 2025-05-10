@extends('admin.layouts.master')
@section('title', 'Data Plans')

@section('content')
<div class="d-card">
    <div class="card-header">
        <div class="d-flex align-items-center justify-content-between">
        <h5>All {{$network->name}} Plans</h5>
        <a class="btn btn-primary btn-sm" href="#" data-toggle="modal" data-target="#createPlan"><i class="fas fa-plus"></i> New Plan</a>
        </div>
    </div>
    <div class="d-card-body table-responsive">
        <table class="table table-bordered table-hover" id="datatable">
            <thead class="white">
                <tr>
                <th>S/N</th>
                <th>Name</th>
                <th>Network</th>
                <th>Type</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dataplans as $key => $plan)
                <tr>
                    <td>{{$key +1}}</td>
                    <td>{{$plan->name}}</td>
                    <td>{{$plan->network->name}}</td>
                    <td>{{$plan->service}}</td>
                    <td> {{format_price($plan->price)}}</td>
                    <td><span class="badge @if($plan->status == 1)bg-success @else bg-danger @endif">@if($plan->status == 1)active @else disabled @endif </span></td>
                    <td>
                        <div class="">
                            <a class="btn btn-info btn-sm" data-toggle="modal" data-target="#editPlan-{{$plan->id}}"  href="#" title="@lang('Edit Plan')" > <i class="fa fa-edit"></i></a>
                            @if($plan->status == 1)
                            <a class="btn btn-sm btn-warning" href="{{route('admin.bills.dataplan.status' ,[$plan->id, 0])}}">Disable</a> @else
                            <a class="btn btn-success btn-sm" href="{{route('admin.bills.dataplan.status' ,[$plan->id, 1])}}">Enable</a>
                            @endif
                            <a class="btn btn-sm btn-danger" href="{{route('admin.bills.dataplan.delete' ,[$plan->id])}}" title="Delete"><i class="fa fa-trash"></i></a>
                        </div>
                    </td>
                </tr>
                <div class="modal fade" id="editPlan-{{$plan->id}}" tabindex="-1"  aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title fw-bold">Edit Data Plan</h5>
                        </div>
                        <div class="modal-body">
                            <form action="{{route('admin.bills.dataplan.edit', $plan->id)}}"enctype="multipart/form-data" method="post">
                                @csrf
                                <div class="row">
                                    <input type="hidden" name="network_id" value="{{$network->id}}">
                                    <div class="form-group col-sm-12">
                                        <label class="form-label">Name</label>
                                        <input type="text" class="form-control" name="name" value="{{$plan->name}}" placeholder="Plan Name" required>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label class="form-label">Network</label>
                                        <input type="text" readonly class="form-control" value="{{$network->name}}">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label class="form-label">Data Type</label>
                                        <select name="service" class="form-control" required>
                                            <option value="SME" {{$plan->service == 'SME' ? "selected" : ""}}>SME</option>
                                            <option value="CG"  {{$plan->service == 'CG' ? "selected" : ""}}>Corporate Gifting</option>
                                            <option value="GIFTING" {{$plan->service == 'GIFTING' ? "selected" : ""}}>Gifting</option>
                                            {{-- <option value="SME2" {{$plan->service == 'SME2' ? "selected" : ""}}>SME2</option> --}}
                                        </select>
                                        {{-- <input type="text" class="form-control" name="service" value="{{$plan->service}}" placeholder="Data Type" required> --}}
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label class="form-label">Plan Code</label>
                                        <input type="text" class="form-control" name="code" value="{{$plan->code}}" placeholder="Plan Code" required>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label class="form-label">Price</label>
                                        <input type="number" class="form-control" name="price" value="{{$plan->price}}" placeholder="Plan Price" required>
                                    </div>
                                </div>
                                <div class="form-group col-12 mb-0">
                                    <button class="btn btn-success w-100" type="submit">Edit Plan</button>
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
            <form action="{{route('admin.bills.dataplan.create')}}" enctype="multipart/form-data" method="post" class="row">
                @csrf
                <input type="hidden" name="network_id" value="{{$network->id}}">
                <div class="form-group col-sm-12">
                    <label class="form-label">Name</label>
                    <input type="text" class="form-control" name="name" placeholder="Plan Name" required>
                </div>
                <div class="form-group col-sm-6">
                    <label class="form-label">Network</label>
                    <input type="text" readonly class="form-control" value="{{$network->name}}">
                </div>
                <div class="form-group col-sm-6">
                    <label class="form-label">Data Type</label>
                    <select name="service" class="form-control" required>
                        <option value="SME">SME</option>
                        <option value="CG">Corporate Gifting</option>
                        <option value="GIFTING">Gifting</option>
                        {{-- <option value="SME2">SME2</option> --}}
                    </select>
                    {{-- <input type="text" class="form-control" name="service" placeholder="Data Type" required> --}}
                </div>
                <div class="form-group col-sm-6">
                    <label class="form-label">Plan Code</label>
                    <input type="number" class="form-control" name="code" placeholder="Plan Code" required>
                </div>
                <div class="form-group col-sm-6">
                    <label class="form-label">Price</label>
                    <input type="number" class="form-control" name="price" placeholder="Plan Price" required>
                </div>
                <div class="form-group col-12 mb-0">
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
    .card-header{border-bottom:1px solid #949d94 }
</style>
@endsection
