@extends('admin.layouts.master')
@section('title', 'Manage Betsite')

@section('content')
<div class="d-card">
    <div class="card-header">
        <div class="d-flex align-items-center justify-content-between">
        <h5>Bet Companies</h5>
        <a class="btn btn-primary btn-sm" href="#" data-toggle="modal" data-target="#createCompany"><i class="fas fa-plus"></i> Add</a>
        </div>
    </div>
    <div class="d-card-body table-responsive">
        <table class="table table-bordered table-hover" id="datatable">
            <thead class="white">
                <tr>
                <th>S/N</th>
                <th>Name</th>
                {{-- <th>Charges</th> --}}
                <th>Minimum</th>
                <th>Status</th>
                <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($plans as $key => $item)
                <tr>
                    <td>{{$key +1}}</td>
                    <td>{{$item->name}}</td>
                    {{-- <td> {{format_price($item->fee)}}</td> --}}
                    <td> {{format_price($item->minimum)}}</td>
                    <td><span class="badge @if($item->status == 1)bg-success @else bg-danger @endif">@if($item->status == 1)active @else disabled @endif </span></td>
                    <td>
                        <div class="drop">
                            <a class="btn btn-info btn-sm" data-toggle="modal" data-target="#editPlan-{{$item->id}}"  href="#" >@lang('Edit')</a>
                            @if($item->status == 1)
                            <a class="btn btn-warning btn-sm" href="{{route('admin.bills.bet.status' ,[$item->id, 0])}}">Disable</a> @else
                            <a class="btn btn-success btn-sm" href="{{route('admin.bills.bet.status' ,[$item->id, 1])}}">Enable</a>
                            @endif
                            <a class="btn btn-danger btn-sm" href="{{route('admin.bills.bet.delete' ,[$item->id])}}" title="Delete"><i class="fa fa-trash"></i></a>
                        </div>
                    </td>
                </tr>
                <div class="modal fade" id="editPlan-{{$item->id}}" tabindex="-1"  aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title fw-bold">Edit Bet Plan</h5>
                        </div>
                        <div class="modal-body">
                            <form action="{{route('admin.bills.bet.edit', $item->id)}}" enctype="multipart/form-data" method="post">
                                @csrf
                                <div class="form-group">
                                    <label class="form-label">Company Name</label>
                                    <input type="text" class="form-control" name="name" value="{{$item->name}}" placeholder="Plan Name" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Plan Code</label>
                                    <input type="text" class="form-control" name="code" value="{{$item->code}}" placeholder="Plan Code" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Minimum Price</label>
                                    <input type="number" class="form-control" name="minimum" value="{{$item->minimum}}" placeholder="Minimum Price" required>
                                </div>
                                <div class="form-group" hidden>
                                    <label class="form-label">Charges/Fee</label>
                                    <input type="number" class="form-control" name="fee" value="{{$item->fee}}" placeholder="Plan Charges" required>
                                </div>
                                <div class="form-group text-end">
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
<div class="modal fade" id="createCompany" tabindex="-1"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title fw-bold">Add Bet Company</h5>
        </div>
        <div class="modal-body">
            <form action="{{route('admin.bills.bet.create')}}" enctype="multipart/form-data" method="post">
                @csrf
                <div class="form-group">
                    <label class="form-label">Name</label>
                    <input type="text" class="form-control" name="name" placeholder="Plan Name" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Plan Code</label>
                    <input type="text" class="form-control" name="code" placeholder="Plan Code" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Minimum</label>
                    <input type="number" class="form-control" name="minimum" placeholder="Minimum Price" required>
                </div>
                <div class="form-group" hidden>
                    <label class="form-label">Charges/Fee</label>
                    <input type="number" class="form-control" name="fee" placeholder="Plan Charges" value="10" required>
                </div>
                <div class="form-group text-end">
                    <button class="btn-success btn w-100" type="submit">Create Plan</button>
                </div>
            </form>
        </div>
        </div>
    </div>
</div>
@endsection

@section('breadcrumb')
@endsection

@section('scripts')
@endsection
@section('styles')
<style>
    .img-table{ height:40px ;}
    .card-header{background-color: #fefefe; border-bottom:1px solid #949d94 }
    body.light .card-header{color: #fefefe; border:1px solid #949d94 }
</style>
@endsection
