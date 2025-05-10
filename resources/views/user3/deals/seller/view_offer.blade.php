@extends('user3.layouts.master')
@section('title', 'Offer Details')

@section('content')
<div class="row">
    <div class="col-lg-12 col-12 mb-5 mb-lg-0">
        <div class="card">
            <div class="card-body pb-2">
                @if($listing->sold == 1)
                <div class="my-3 table-responsive">
                    <h5 class="fw-bold">Actions</h5>
                    <table class="table table-">
                        <thead>
                            <tr>
                                <th  style="display:none;">Payment Status</th>
                                <th>Buyer Confirmation</th>
                                <th>Seller Confirmation</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="display:none;">
                                    @if ($trx->status == 1)
                                        <button class="btn btn-success btn-sm"><i class="fa fa-check-circle"></i> PAID</button>
                                    @else
                                    <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#paymentModal">MAKE PAYMENT</a>
                                    @endif
                                </td>
                                <td>
                                    @if ($trx->buyer_confirm == 1)
                                        <button class="btn btn-success btn-sm"><i class="fa fa-check-circle"></i> CONFIRMED</button>
                                    @else
                                        <button class="btn btn-warning btn-sm">PENDING</button>
                                        {{-- <a href="#" data-toggle="modal" data-target="#buyerConfirm" class="btn btn-info btn-sm">CONFIRM LOGIN</a> --}}
                                    @endif
                                </td>
                                <td>
                                    @if ($trx->seller_confirm == 1)
                                        <button class="btn btn-success btn-sm"><i class="fa fa-check-circle"></i> CONFIRMED</button>
                                    @else
                                    <a href="#" data-toggle="modal" data-target="#sellerConfirm" class="btn btn-info btn-sm">COMPLETE DEAL</a>

                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                @endif
                <div class="row">
                    <div class="col-md-6" style="display:none;">
                        <h6 class="fw-bold" style="display:none;">Details</h6>
                        <ul class="list-group acc-details" style="display:none;">
                            <li class="list-group-item d-flex justify-content-between">
                                <span class="text-muted">Seller</span>
                                <h6 class="text-primar">{{$listing->user->username ?? ""}}</h6>
                            </li>

                            <li class="list-group-item d-flex justify-content-between">
                                <span class="text-muted">Title</span>
                                <h6>{{$listing->name}} </h6>
                            </li>

                            <li class="list-group-item d-flex justify-content-between">
                                <span class="text-muted">Category</span>
                                <h6>{{$listing->account_type}}</h6>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span class="text-muted">Link</span>
                                <h6> <a href="{{$listing->link}}" target="__blank">Click Here</a> </h6>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span class="text-muted">Price</span>
                                <h6>{{format_price($listing->amount)}} </h6>
                            </li>

                            <li class="list-group-item d-flex justify-content-between">
                                <span class="text-muted">Status</span>
                                <span> {!! list_status($listing->sold)!!} </span>
                            </li>
                        </ul>

                        <div class="mt-3" style="display:none;">
                            <span class="text-muted">Description</span>
                            <p>{{$listing->about}}</p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h6 class="fw-bold" style="display:none;">Account Information</h6>
                        <ul class="list-group acc-details" style="display:none;">
                            <li class="list-group-item d-flex justify-content-between">
                                <span class="text-muted">Followers/subscribers</span>
                                <h6 class="">{{$listing->followers ?? ""}}</h6>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span class="text-muted">Followings</span>
                                <h6 class="">{{$listing->followings ?? ""}}</h6>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span class="text-muted">Age</span>
                                <h6 class="">{{$listing->age ?? ""}}</h6>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span class="text-muted">Followers Type</span>
                                <h6 class="text">{{$listing->follower_type ?? ""}}</h6>
                            </li>
                        </ul>
                        <h4 class="fw-bold my-2">Account Credentials</h4>
                        <ul class="list-group acc-details">
                            <li class="list-group-item d-flex justify-content-between">
                                <span class="text-muted">Username</span>
                                <h6 class="text-primary">{{$listing->username ?? ""}}</h6>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span class="text-muted">Email</span>
                                <h6 class="text-primary">{{$listing->email ?? ""}}</h6>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span class="text-muted">Password</span>
                                <h6 class="text-primary">{{$listing->password ?? ""}}</h6>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span class="text-muted">Mobile</span>
                                <h6 class="text-primary">{{$listing->mobile ?? ""}}</h6>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span class="text-muted">Other Info</span>
                                <h6 class="text-primary">{{$listing->other_info ?? ""}}</h6>
                            </li>
                        </ul>

                        {{-- Image --}}
                        {{-- <h6 class="fw-bold mt-3">Preview Image</h6>
                        <img id="pimage" class="b-image mb-2" src="{{my_asset($listing->preview)}}"/> --}}
<br> <br>
                    </div>
                </div>

            </div>
        </div>

        @if($listing->sold == 1)
        <div class="card mt-3">
            <div class="card-header"><br>
                <h5 class="fw-bold">Chat with Buyer</h5>
            </div>
            <div class="card-body">
                <div class="chatArea">
                    @forelse ($listing->comments as $item)
                        @if($item->type == 1)
                        {{-- seller --}}
                        <div class="row justify-content-start text-left mb-3">
                            <div class="col-sm-10 msg received">
                                <div class="">
                                    <p>{!! nl2br($item->message ) !!}</p>
                                </div>
                            </div>
                            <small class="col-12 msg-date1" >{{$item->created_at->diffForHumans()}}</small>
                        </div>
                        @else
                        <div class="row justify-content-end text-right mb-3">
                            <div class="col-sm-10 msg sent">
                                <div class="">
                                    <p>{!! nl2br($item->message ) !!}</p>
                                </div>
                            </div>
                            <small class="col-12 msg-date" >{{$item->created_at->diffForHumans()}}</small>
                        </div>
                        @endif
                    @empty
                        <div class="row">
                            <div class="col-md-12 card msg">
                                <h5>No messages yet</h5>
                            </div>
                        </div>
                    @endforelse
                </div>
                <div class="col-md-12">
                    <form action="{{route('user.listings.offer.s.comment', $trx->id)}}" method="POST">
                        @csrf
                        <div class="form-row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <textarea name="comment" class="form-control commentBox" rows="5" placeholder="@lang('Your message')">{{ old('comment') }}</textarea>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">@lang('Send Message')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@if($listing->sold == 1)
<div class="modal fade" id="sellerConfirm">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Seller Confirmation</h3>
                <span type="button" class="text-white close" data-dismiss="modal">X</span>
            </div>
            <div class="modal-body">

                <ol>
                                       <li>Your earnings will be transfered to your Deal Earnings wallet, you can withdraw to bank account or to your main balance.</li>
                    <li>If you encounter any issues, Kindly create a <a href="{{route('user.tickets')}}">support ticket. </a> </li>
                </ol>
                <form action="{{route('user.listings.offer.s.confirm', $trx->id)}}" method="post">
                    @csrf
                    <input type="hidden" name="offer" value="{{$trx->id}}">
                    <button type="submit" class="w-100 btn btn-success" >CONFIRM DEAL</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@section('breadcrumb')
<div class="card dc-dash">
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
    .b-image{
        min-height: 250px;
        max-height:100%;
        width: auto;
        max-width: 100%;
        border: 3px solid #d5662f;
    }
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

@push('scripts')
<script>
    let inactivityTimeout;

    function refreshPage() {
        location.reload(true);
    }

    function resetInactivityTimer() {
        clearTimeout(inactivityTimeout);
        inactivityTimeout = setTimeout(refreshPage, 200000);
    }
    document.addEventListener('mousemove', resetInactivityTimer);
    document.addEventListener('keydown', resetInactivityTimer);

    resetInactivityTimer();
</script>
@endpush
