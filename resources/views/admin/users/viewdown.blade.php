@extends('admin.layouts.master')
@section('title', $user->username .'Referrals')

@section('content')
<div class="d-card">
    <h5 class="card-header">{{$user->username}} Referrals</h5>
    <div class="d-card-body table-responsive">
        <table class="table table-bordered" id="datatable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Phone </th>
                    <th>Date Joined</th>
                    <th>Balance</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($referrals as $key => $item)
                <tr>
                    <td>{{$key +1}}</td>
                    <td>{{$item->username}}</td>
                    <td>{{$item->email}}</td>
                    <td>{{$item->phone}}</td>
                    <td>{{ date('F d, Y H:m:s', strtotime($item->created_at))}}</td>
                    <td>{{format_price($item->balance)}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
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
                    Manage User accounts.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
