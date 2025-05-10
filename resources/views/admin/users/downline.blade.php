@extends('admin.layouts.master')
@section('title', 'Users')

@section('content')
<div class="d-card">
    <div class="card-header d-flex justify-content-between">
        <h5></h5>
        <div class="pull-right search mr-2">
            <form action="" method="get" id="history-search">
                <div class="app-ord-search">
                    <input type="text" name="search" value="{{$search}}" placeholder="Search Users" class="app-ord-input" />
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
                <th>ID</th>
                <th class="nowrap">Info</th>
                <th class="nowrap">Balance</th>
                <th class="nowrap">Downlines</th>
                <th class="nowrap">Joined</th>
                <th class="nowrap">Status</th>
                <th >Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $key => $item)
            <tr class="app-block">
                <td class="app-col" data-title="ID">{{$item->id}}</td>
                <td class="app-col" data-title="Info">
                    <div class="">
                       <p>{{$item->name()}}</p>
                       <p class="my-1">{{$item->phone}}</p>
                        {{($item->email)}}
                    </div>
                </td>
                <td class="app-col" data-title="Balance">{!! format_price($item->balance) !!}</td>
                <td class="app-col" data-title="Downlines">
                    {{$item->referrals()->count()}}
                </td>

                <td class="app-col" data-title="Joined">{{show_datetime1($item->created_at)}}</td>
                <td class="app-col" data-title="Status">
                    @if($item->status == 1)
                        <span class="badge bg-success">Active</span>
                    @elseif ($item->status == 2)
                        <span class="badge bg-warning">Unverified</span>
                    @elseif ($item->status == 3)
                        <span class="badge bg-danger">Blocked</span>
                    @elseif ($item->status == 4)
                        <span class="badge bg-info">Blocked</span>
                    @endif
                </td>
                <td class="app-col" data-title="Action">
                    <a href="{{route('admin.users.viewdown', $item->id)}}" class="btn btn-sm btn-outline-primary" title="User Details">
                        <i class="fa fa-eye"></i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
   </div>
   {{$users->links()}}
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
                    Manage User accounts.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
