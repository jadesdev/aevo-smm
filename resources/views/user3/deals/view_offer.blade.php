@extends('user3.layouts.master')
@section('title', 'View Offer')

@section('content')
<div class="row">
    <div class="col-lg-12 col-12 mb-5 mb-lg-0">
        <div class="card">
            <div class="card-body pb-2">
                <p class="fw-bold">{{$listing->name}}</p>

                <table class="table app-mtable">
                    <thead>
                        <tr class="thead-tr">
                            <th>Price</th>
                            <th>Offer</th>
                            <th>Followers</th>
                            <th>Age</th>
                            <th>Status</th>
                            <th>Seller</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr class="app-block">
                            <td class="app-col" data-title="Price" class="w-100"> {{format_price($listing->amount)}}</td>
                            <td class="app-col" data-title="Offer">{{format_price($offer->amount)}}</td>
                            <td class="app-col" data-title="Followers"> {{($listing->followers)}}</td>
                            <td class="app-col" data-title="Age"> {{($listing->age)}}</td>
                            <td class="app-col" data-title="Status">{!!listoffer_status($offer->status)!!} </td>
                            <td class="app-col" data-title="Seller"> {{($listing->user->username ?? "")}}</td>
                        </tr>
                    </tbody>
                </table>

                <b>Description</b>
                <p>{!! nl2br($listing->about) !!}</p>

                <div class="mt-3">
                    <h5 class="fw-bold">Actions</h5>

                    <table class="table table-">
                        <thead>
                            <tr>
                                <th>Payment Status</th>
                                <th>Buyer Confirmation</th>
                                <th>Seller Confirmation</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    @if ($trx->status == 1)
                                        <button class="btn btn-success">PAID</button>
                                    @else
                                    <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#paymentModal">Make Payment</a>
                                    @endif
                                </td>
                                <td>
                                    @if ($trx->buyer_confirm == 1)
                                        <button class="btn btn-success">CONFIRMED</button>
                                    @else
                                        <a href="#" data-toggle="modal" data-target="#buyerConfirm" class="btn btn-info">Confirm Logins</a>
                                    @endif
                                </td>
                                <td>
                                    @if ($trx->seller_confirm == 1)
                                        <button class="btn btn-success">CONFIRMED</button>
                                    @else
                                        <button class="btn btn-warning">PENDING</button>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    {{-- Action buttons --}}
                    <div class="col-12"></div>

                    {{-- Message area --}}
                    <div class="col-12">
                        <div class="warning-msg">
                            <h6 class="fw-bold">Instructions</h6>
                            <ul>
                                <li>The buyer and seller discuss and buyer makes a suitable offer.</li>
                                <li>The buyer pays for the account and payment is held on our system. </li>
                                <li>The seller transfers login details and the original email account to the buyer. </li>
                                <li>The buyer checks everything, changes the login details. </li>
                                <li>After the buyer and seller's confirmation, the system release the payment to the seller. </li>
                                <li>If you encounter any issues, Kindly create a <a href="{{route('user.tickets')}}">support ticket. </a> </li>
                            </ul>
                            <hr>
                        </div>
                        <div class="chatArea">
                            @forelse ($offer->comments as $item)
                                @if($item->type == 0)
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
                                        <h5>Send a message to the seller</h5>
                                    </div>
                                </div>
                            @endforelse
                        </div>

                        <div class="col-md-12">
                            <form action="{{route('user.listings.offer.b.comment', $offer->id)}}" method="POST">
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
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="paymentModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Make Payment for {{$listing->name}}</h5>
                <span type="button" class="text-white close" data-dismiss="modal">X</span>
            </div>
            <div class="modal-body">
                <p class="fw-bold">Transaction steps when using our service:</p>
                <ol>
                    <li>You will be redirected to a payment page to pay for the account. </li>
                    <li>Once the payment is confirmed, The seller transfers login details and the original email account to the you. </li>
                    <li>After which you can change the details. </li>
                    <li>If you encounter any issues, Kindly create a <a href="{{route('user.tickets')}}">support ticket. </a> </li>
                </ol>
                <form action="{{route('user.listings.offer.payment', $offer->id)}}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="" class="form-label">Amount</label>
                        <input type="text" disabled class="form-control" value="{{format_price($offer->amount)}}">
                    </div>
                    <input type="hidden" name="offer" value="{{$offer->id}}">
                    <button type="submit" class="w-100 btn btn-success" >MAKE PAYMENT</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="buyerConfirm">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Buyer Confirmation for {{$listing->name}}</h5>
                <span type="button" class="text-white close" data-dismiss="modal">X</span>
            </div>
            <div class="modal-body">
                <p class="fw-bold">Buyer Confirmation:</p>
                <ol>
                    <li>Once you have full access to the account, you can confirm the deal below </li>
                    <li>If you encounter any issues, Kindly create a <a href="{{route('user.tickets')}}">support ticket. </a> </li>
                </ol>
                <form action="{{route('user.listings.offer.b.confirm', $offer->id)}}" method="post">
                    @csrf
                    <input type="hidden" name="offer" value="{{$offer->id}}">
                    <button type="submit" class="w-100 btn btn-success" >CONFIRM DEAL</button>
                </form>
            </div>
        </div>
    </div>
</div>
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
        inactivityTimeout = setTimeout(refreshPage, 30000);
    }
    document.addEventListener('mousemove', resetInactivityTimer);
    document.addEventListener('keydown', resetInactivityTimer);

    resetInactivityTimer();

</script>
@endpush
