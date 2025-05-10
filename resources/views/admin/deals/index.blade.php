@extends('admin.layouts.master')
@section('title', $title)

@section('content')
<div class="orders-btn py-3">
    <ul class="nav nav-pills app-ord-nav">
        <li class="mr-2">
            <a class="@if($type == "all") active @endif " href="{{route('admin.listing.index')}}">All Listings</a>
        </li>
        <li class="mr-2">
            <a class="@if($type == "pending") active @endif" href="{{route('admin.listing.pending')}}">Pending Approval</a>
        </li>
        <li class="mr-2">
            <a class="@if($type == "sold") active @endif" href="{{route('admin.listing.sold')}}">Sold Listings</a>
        </li>
        <li class="pull-right search mr-2">
            <form action="" method="get" id="history-search">
                <div class="app-ord-search">
                    <input type="text" name="search"  placeholder="Search" class="app-ord-input" />
                    <button type="submit" class="app-ord-submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </li>
    </ul>
</div>

<div class="d-card">
    <div class="card-header">
        <div class="d-flex align-items-center justify-content-between">
            <h5 class="mb-0">{{$title}}</h5>
        </div>
    </div>
    <div class="d-card-body table-responsive">
        <table class="table app-mtable">
            <thead>
                <tr class="thead-tr">
                    <th>ID</th>
                    <th>User</th>
                    <th>Name</th>
                    <th>Link</th>
                    <th>Price</th>
                    <th>Published</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($listings as $item)
                <tr class="app-block">
                    <td class="app-col" data-title="ID">{{$item->id}}</td>
                    <td class="app-col" data-title="User">{{$item->user->username ?? "N/A"}}</td>
                    <td class="app-col" data-title="Name"> <a href="{{route('user.listings.view', $item->id)}}">{{$item->name}}</a></td>
                    <td class="app-col" data-title="Link"><a target="_blank" href="{{$item->link}}">{{text_trim($item->link, 50)}}</a></td>
                    <td class="app-col" data-title="Amount">{{format_price($item->amount)}}</td>
                    <td class="app-col" data-title="Published">{!!publish_status($item->status)!!} </td>
                    <td class="app-col" data-title="Status">{!!list_status($item->sold)!!} </td>
                    <td class="app-col" data-title="Actions">
                        <a class="btn btn-light btn-sm" type="button" href="{{route('admin.listing.details', $item->id)}}" >
                            <i class="fa fa-ellipsis-v"></i> Details
                        </a>
                        <a class="btn btn-light btn-sm" type="button" href="{{route('admin.listing.edit', $item->id)}}" >
                            <i class="fa fa-edit"></i> Edit
                        </a>
                        @if($item->status == 2)
                        <a class="btn btn-success btn-sm" type="button" href="{{route('admin.listing.approve', $item->id)}}" >
                            <i class="fa fa-check"></i> Approve
                        </a>
                        @endif
                    </td>
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
                    Manage all Listings.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
