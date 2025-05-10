@extends('user3.layouts.master')
@section('title', "Bills Transactions")

@section('page-title')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0">@yield('title')</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Bills</a></li>
                    <li class="breadcrumb-item active">Transactions</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body table-responsive">
                <table class="table w-100 table-bordered table-hover" id="dataTable2">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Service</th>
                        <th>TRX Code</th>
                        <th>Amount</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Details</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($trx as $item)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td> <span class="badge bg-info"> {{$item->service}} </span></td>
                                <td>{{$item->code}}</td>
                                <td>{{format_price($item->amount)}}</td>
                                <td>{{show_datetime($item->created_at)}}</td>
                                <td>{!! get_trx_status($item->status) !!}</td>
                                <td>{{$item->message}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <span class="my-2">
                {{$trx->links()}}
            </span>
        </div><!-- .card-preview -->
    </div>
</div>
@endsection

@section('scripts')

@endsection
@section('styles')
<style>
    #div_account_name{
        display: none;
    }
    .form-group{
        margin-bottom: 15px;
    }
</style>
@endsection
