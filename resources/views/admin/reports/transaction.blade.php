@extends('admin.layouts.master')
@section('title', 'Transactions')

@section('content')
<div class="d-card">
    <div class="card-header d-flex justify-content-between">
        <h5></h5>
        <div class="pull-right search mr-2">
            <form action="" method="get" id="history-search">
                <div class="app-ord-search">
                    <input type="text" name="search" value="{{$search}}" placeholder="Search Transactions" class="app-ord-input" />
                    <button type="submit" class="app-ord-submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
   <div class="d-card-body table-responsive">
    <table class="table app-mtable" id="datatable">
        <thead class="white">
            <tr class="thead-tr">
                <th>#</th>
                <th class="nowrap">Type</th>
                <th class="nowrap">Service</th>
                <th class="nowrap">User</th>
                <th class="nowrap">TRX Code</th>
                <th class="nowrap">Amount</th>
                <th class="nowrap">Status</th>
                <th >Message</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $key => $item)
            <tr class="app-block">
                <td class="app-col" data-title="#">{{$key + 1}}</td>
                <td class="app-col" data-title="Type">{!! get_trx_type($item->type) !!}</td>
                <td class="app-col" data-title="Service">
                    <span class="order-status os-processing">{{$item->service}}</span>
                </td>
                <td class="app-col" data-title="User">
                    <a href="{{route('admin.users.detail', $item->user->id)}}">{{$item->user->username}}</a>
                </td>
                <td class="app-col" data-title="TRX Code">
                    <div class="">
                       <p>{{$item->code}}</p>
                        {{show_datetime($item->created_at)}}
                    </div>
                </td>
                <td class="app-col" data-title="Amount">{{format_price($item->amount)}}</td>
                <td class="app-col" data-title="Status">
                    @if($item->status == 1)
                        <span class="badge bg-success">successful</span>
                    @elseif ($item->status == 2)
                        <span class="badge bg-warning">pending</span>
                    @elseif ($item->status == 3)
                        <span class="badge bg-danger">cancelled</span>
                    @elseif ($item->status == 4)
                        <span class="badge bg-info">reversed</span>
                    @endif
                </td>
                <td class="app-col" data-title="Message">{{$item->message}}</td>
            </tr>

        @endforeach
        </tbody>
    </table>
   </div>
   <div class="my-2" >
       {{$transactions->links()}}
   </div>
</div>
@endsection

@section('breadcrumb')
<div class="d-card dc-dash">
    <div class="row">
        <div class="col-lg-7 col-md-9 col-12">
            <div class="py-3 px-5">
                <div class="dch-title">
                   @yield('title')
                </div>
                <div class="dch-text">
                    Manage Transactions.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
