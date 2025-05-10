@extends('admin.layouts.master')
@section('title', 'Payment Bonus')

@section('content')

<div class="d-card">
    <div class="card-header">
        <div class="d-flex align-items-center justify-content-between">
            <h5 class="mb-0">Payment Bonus</h5>
            <a href="#" data-toggle="modal" data-target="#CreateBonus" class="btn btn-primary btn-sm">Add Bonus</a>
        </div>
    </div>
    <div class="d-card-body">
        <div class="card-body table-responsive">
            <table class="table table-bordered">
                <thead class="white">
                    <tr>
                        <th>#</th>
                        <th>Method</th>
                        <th>Bonus Percentage (%)</th>
                        <th>Bonus From</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$item->method}}</td>
                        <td>{{$item->percentage}} </td>
                        <td>{{format_price($item->amount)}}</td>
                        <td>{!! get_status($item->status) !!}</td>
                        <td>
                            <div>
                                <a href="#" data-toggle="modal" data-target="#TrackEdit{{$item->id}}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                            </div>
                        </td>
                    </tr>
                    <div class="modal fade" id="TrackEdit{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <h6 class="modal-title" id="myModalLabel"> Edit {{$item->name}}</h6>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"></span></button>
                              </div>
                              <div class="modal-body">
                                <form action="{{route('admin.bonus.edit', $item->id)}}" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label class="form-label">Method</label>
                                        <select name="method" class="form-select form-control" id="">
                                            <optiondisabled>Select Payment Method</option>
                                            <option @if($item->method == 'paystack') selected @endif value="paystack">Paystack</option>
                                            <option @if($item->method == 'flutterwave') selected @endif value="flutterwave">Flutterwave</option>
                                            <option @if($item->method == 'paypal') selected @endif value="paypal">Paypal</option>
                                            <option @if($item->method == 'monnify') selected @endif value="monnify">Monnify</option>
                                            <option @if($item->method == 'coinbase') selected @endif value="coinbase">Coinbase Payment</option>
                                            <option @if($item->method == 'perfect') selected @endif value="perfect">Perfect Money</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Bonus Percentage (%)</label>
                                        <input type="number" value="{{$item->percentage}}" step="any" class="form-control" required name="percentage">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Bonus From ({{get_setting('currency')}})</label>
                                        <input type="number" step="any" value="{{$item->amount}}" class="form-control" required name="amount">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Status</label>
                                        <select name="status" class="form-control">
                                            <option value="1" @if($item->status == 1) selected @endif>Enabled</option>
                                            <option value="2" @if($item->status == 2) selected @endif>Disabled</option>
                                        </select>
                                    </div>
                                    <button class="btn btn-success mt-2 w-100" type="submit">Update Bonus</button>
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
</div>

<div class="modal fade" id="CreateBonus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
              <h6 class="modal-title" id="myModalLabel"> Add Deposit Bonus</h6>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
          </div>
          <div class="modal-body">
            <form action="{{route('admin.bonus.create')}}" method="post">
                @csrf
                <div class="form-group">
                    <label class="form-label">Method</label>
                    <select name="method" class="form-select form-control" id="">
                        <option disabled>Select Payment Method</option>
                        <option value="paystack">Paystack</option>
                        <option value="flutterwave">Flutterwave</option>
                        <option value="paypal">Paypal</option>
                        <option value="monnify">Monnify</option>
                        <option value="coinbase">Coinbase Payment</option>
                        <option value="perfect">Perfect Money</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Bonus Percentage (%)</label>
                    <input type="number" step="any" class="form-control" required name="percentage">
                </div>
                <div class="form-group">
                    <label class="form-label">Bonus From ({{get_setting('currency')}})</label>
                    <input type="number" step="any" class="form-control" required name="amount">
                </div>
                <button class="btn btn-success mt-2 w-100" type="submit">Create</button>
            </form>
          </div>
      </div>
    </div>
</div>
@endsection

@section('breadcrumb')

@endsection
