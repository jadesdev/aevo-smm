@extends('user.layouts.master')
@section('title', 'Received Offers')

@section('content')
<div class="row">
    <div class="col-lg-12 col-12 mb-5 mb-lg-0">
        <div class="d-card">
            <div class="d-card-body pb-2">
                <p class="fw-bold my-0">{{$listing->name}}</p>
                <div class="row justify-content-between mt-2 mx-auto">
                    <span class="">Followers</span>
                    <span class="fw-bold text-center">Price</span>
                    <span class="fw-bold">Age</span>
                </div>
                <div class="row justify-content-between my-2 mx-auto">
                    <span class="">{{shortNumber($listing->followers)}}</span>
                    <span class="text-center">{{format_price($listing->amount)}}</span>
                    <span>{{$listing->age}}</span>
                </div>
                <hr class="">
                <b>Description</b>
                <p>{!! nl2br($listing->about) !!}</p>

            </div>
        </div>
        <div class="d-card">
            <div class="d-card-body pb-2 table-responsive">
                <table class="table app-mtables">
                    <thead>
                        <tr class="thead-tr">
                            <th>ID</th>
                            <th>User</th>
                            <th>Price</th>
                            <th>Offer</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($offers as $item)
                        <tr class="app-block">
                            <td class="app-col" data-title="ID">{{$item->id}}</td>
                            <td class="app-col" data-title="User"> {{$item->user->username ?? ""}}</td>
                            <td class="app-col" data-title="Price"> {{format_price($item->listing->amount)}}</td>
                            <td class="app-col" data-title="Offer">{{format_price($item->amount)}}</td>
                            <td class="app-col" data-title="Status">{!!listoffer_status($item->status)!!} </td>
                            <td class="app-col" data-title="Actions">
                                <div class="actions">
                                    @if($item->status == "accepted")
                                    <a class="btn btn-light btn-sm" title="View offer" type="button" href="{{route('user.listings.offers.view', $item->id)}}">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    @endif
                                    @if($item->status == "pending")
                                    <a class="btn btn-danger btn-sm" type="reject Offer" type="button" href="{{route('user.listings.offer.reject', $item->id)}}">
                                        <i class="fa fa-cancel"></i>
                                    </a>
                                    <a class="btn btn-success btn-sm" title="Accept Offer" type="button" href="{{route('user.listings.offer.accept', $item->id)}}">
                                        <i class="fa fa-check"></i>
                                    </a>
                                    @endif
                                </div>

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

@section('styles')
<style>
    textarea.commentBox,textarea.commentBox:focus {
        overflow-y: auto;
    }

    .chatArea {
        padding: 20px;
        background: transparent;

        max-height: calc(90vh - 250px);
        min-height: 2   00px;
        overflow-y: scroll;
    }
    .chatArea .msg {
        background: #0f327e;
        margin-bottom: 0;
        padding: 10px 15px;
        font-size: 15px;
        display: inline-block;
    }
    .chatArea .sent{
        border-radius: 15px 15px 0 15px;
        background: #206bc4 !important;
        color: #fff;
        text-align: right;
    }
    .chatArea .received{
        border-radius: 15px 15px 15px 0;
    }
    .chatArea .msg p{
        color: #fff;
        font-size: 0.9rem;
        margin-bottom: 0;
    }
    .msg-date{
        text-align: right !important;
        font-size: 12px;
        margin-bottom: 0
    }
    .msg-date1{
        text-align: left !important;
        font-size: 12px;
        margin-bottom: 0
    }

    .msg .row {
        margin-right: -5px;
        margin-left: -5px;
    }

    .msg .row [class*="col"] {
        padding-right: 5px;
        padding-left: 5px;
    }

    .msg img {
        height: 50px;
        width: 50px;
        border-radius: 50%;
        background-size: cover;
    }
</style>
@endsection
