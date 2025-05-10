@extends('user.layouts.master')
@section('title', 'Bought Accounts')

@section('content')
<div class="row">
    <div class="col-lg-12 col-12 mb-5 mb-lg-0">
        <div class="orders-btn py-3">
            <ul class="nav nav-pills app-ord-nav">
                <li class="mr-2">
                    <a class="" href="{{route('user.listings.deals')}}"><i class="fas fa-filter mr-1"></i>My Listings</a>
                </li>
                <li class="mr-2">
                    <a class="active" href="{{route('user.listings.my_account')}}"><i class="fas fa-file-import mr-1"></i>Bought Accounts</a>
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
                            <th>Category</th>
                            <th>Name</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($listings as $item)
                        <tr class="app-block">
                            <td class="app-col" data-title="Category">{{$item->listing->account_type}}</td>
                            <td class="app-col" data-title="Name"> <a href="{{route('user.listings.view', $item->listing->id)}}">{{$item->listing->name}}</a></td>
                            <td class="app-col" data-title="Amount"> {{format_price($item->listing->amount)}}</td>
                            <td class="app-col" data-title="Date">{{show_datetime1($item->date)}}</td>
                            <td class="app-col" data-title="Actions">
                                <a class="btn btn-light btn-sm" type="button" href="{{route('user.listings.account.view', $item->id)}}">
                                    <i class="fa fa-eye"></i> Details
                                </a>
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
