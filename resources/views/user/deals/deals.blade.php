@extends('user.layouts.master')
@section('title', 'My Listings')

@section('content')
<div class="row">
    <div class="col-lg-12 col-12 mb-5 mb-lg-0">
        <div class="orders-btn py-3">
            <ul class="nav nav-pills app-ord-nav">
                <li class="mr-2">
                    <a class="active" href="{{route('user.listings.deals')}}"><i class="fas fa-filter mr-1"></i>My Listings</a>
                </li>
                <li class="mr-2">
                    <a class="" href="{{route('user.listings.my_account')}}"><i class="fas fa-file-import mr-1"></i>Bought Account</a>
                </li>
                <li class="mr-2">
                    <a class="" href="{{route('user.listings.wallet')}}"><i class="fas fa-wallet mr-1"></i>Wallet</a>
                </li>
                <li class="pull-right search mr-2">
                    <form action="" method="get" id="history-search">
                        <div class="app-ord-search">
                            <input type="text" name="search" value="{{@request()->search}}" placeholder="Search" class="app-ord-input" />
                            <button type="submit" class="app-ord-submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </li>
            </ul>
        </div>

        <div class="d-card" >
            <div class="d-card-body table-responsive">
                <table class="table app-mtable">
                    <thead>
                        <tr class="thead-tr">
                            <th>ID</th>
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
                            <td class="app-col" data-title="Name"> <a href="{{route('user.listings.view', $item->id)}}">{{$item->name}}</a></td>
                            <td class="app-col" data-title="Link"><a target="_blank" href="{{$item->link}}">{{text_trim($item->link, 50)}}</a></td>
                            <td class="app-col" data-title="Amount">{{format_price($item->amount)}}</td>
                            <td class="app-col" data-title="Published">{!!publish_status($item->status)!!} </td>
                            <td class="app-col" data-title="Status">{!!list_status($item->sold)!!} </td>
                            <td class="app-col" data-title="Actions">
                                <a class="btn btn-light btn-sm" type="button" href="{{route('user.listings.details', $item->id)}}" >
                                    <i class="fa fa-ellipsis-v"></i> Details
                                </a>
                                @if($item->sold != 1)
                                <a class="btn btn-light btn-sm" type="button" href="{{route('user.listings.edit', $item->id)}}" >
                                    <i class="fa fa-edit"></i> Edit
                                </a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
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
                    Buy your social media accounts with us. <a href="{{route('user.listings.add')}}">Start Selling. </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
