@extends('user.layouts.master')
@section('title', 'Purchased Account')

@section('content')
<div class="row">
    <div class="col-lg-12 col-12 mb-5 mb-lg-0">
        <div class="d-card">
            <div class="d-card-body pb-2">
                <div class="mt-3 table-responsive">
                    
                    
                    <table class="table table-" style="display:none;">
                        <thead>
                            <tr>
                                <th style="display:none;">Payment Status</th>
                                <th>Buyer Confirmation</th>
                                <th style="display:none;">Seller Confirmation</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="display:none;">
                                    @if ($trx->status == 1)
                                        <button class="btn btn-success btn-sm"><i class="fa fa-check-circle"></i> PAID</button>
                                    @else
                                    <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#paymentModal">PAY</a>
                                    @endif
                                </td>
                                <td>
                                    @if ($trx->buyer_confirm == 1)
                                        <button class="btn btn-success"><i class="fa fa-check-circle"></i> CONFIRMED</button>
                                    @else
                                        <a href="#" data-toggle="modal" data-target="#buyerConfirm" class="btn btn-info ">CONFIRM LOGIN</a>
                                    @endif
                                </td>
                                <td style="display:none;">
                                    @if ($trx->seller_confirm == 1)
                                        <button class="btn btn-success btn-sm"><i class="fa fa-check-circle"></i> CONFIRMED</button>
                                    @else
                                        <button class="btn btn-warning btn-sm">PENDING</button>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <h6 class="fw-bold" style="display:none;">Details</h6>
                        <ul class="list-group acc-details" style="display:none;">
                            <li class="list-group-item d-flex justify-content-between">
                                <span class="text-muted">Seller</span>
                                <h6 class="text-primary">{{$listing->user->username ?? ""}}</h6>
                            </li>

                            <li class="list-group-item d-flex justify-content-between">
                                <span class="text-muted">Title</span>
                                <p style="text-align:right;">{{$listing->name}} </p>
                            </li>

                            <li class="list-group-item d-flex justify-content-between">
                                <span class="text-muted">Category</span>
                                <p style="text-align:right;">{{$listing->account_type}}</p>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span class="text-muted">Link</span>
                                <p style="text-align:right;" class="text-primary"> <a href="{{$listing->link}}" target="__blank">Click Here</a> </p>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span class="text-muted">Price</span>
                                <p style="text-align:right;">{{format_price($listing->amount)}} </p>
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
                        <ul class="list-group acc-details"  style="display:none;">
                            <li class="list-group-item d-flex justify-content-between">
                                <span class="text-muted">Followers/subscribers</span>
                                <h6 class="text">{{$listing->followers ?? ""}}</h6>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span class="text-muted">Followings</span>
                                <h6 class="text">{{$listing->followings ?? ""}}</h6>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span class="text-muted">Age</span>
                                <h6 class="text">{{$listing->age ?? ""}}</h6>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span class="text-muted">Followers Type</span>
                                <h6 class="text">{{$listing->follower_type ?? ""}}</h6>
                            </li>
                        </ul>
                        @if($trx->status == 1)
                        <h4 class="fw-bold my-2">Account Credentials</h4>
                        <ul class="list-group acc-details">
                            <li class="list-group-item d-flex justify-content-between">
                                <span class="text-muted">Username</span>
                                <p style="text-align:right;" class="text-primary">{{$listing->username ?? ""}}</p>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span class="text-muted">Email</span>
                                <p style="text-align:right;" class="text-primary">{{$listing->email ?? ""}}</p>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span class="text-muted">Password</span>
                                <p style="text-align:right;" class="text-primary">{{$listing->password ?? ""}}</p>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span class="text-muted">Mobile</span>
                                <p style="text-align:right;" class="text-primary">{{$listing->mobile ?? ""}}</p>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span class="text-muted">Other Info</span>
                                <p style="text-align:right;" class="text-primary">{{$listing->other_info ?? ""}}</p>
                            </li>
                        </ul>
                        @endif

                        {{-- Image --}}
                        <h6 class="fw-bold mt-3"hidden>Preview Image</h6>
                        <img id="pimage" class="b-image mb-2" src="{{my_asset($listing->preview)}}"/ hidden>
                        
                        
                        <br>
                        
                        <h5 class="fw-bold">Actions</h5>
                    <p>Click here once you've confirmed and logged into the account</p>
                    
                    @if ($trx->buyer_confirm == 1)
                                        <button class="btn btn-success"><i class="fa fa-check-circle"></i> CONFIRMED</button>
                                    @else
                                        <a href="#" data-toggle="modal" data-target="#buyerConfirm" class="btn btn-info ">CONFIRM LOGIN</a>
                                    @endif
                    
<br><br>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-card mt-2">
            <div class="card-header"><br>
                <h5 class="fw-bold">Chat with Seller</h5>
            </div>
            <div class="d-card-body">
                <div class="chatArea">
                    @forelse ($listing->comments as $item)
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
                                <p class="text-white">No messages yet</p>
                            </div>
                        </div>
                    @endforelse
                </div>

                <div class="col-md-12">
                    <form action="{{route('user.listings.offer.b.comment', $trx->id)}}" method="POST">
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

<div class="modal fade" id="buyerConfirm">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Buyer Confirmation</h3>
                <span type="button" class="text-white close" data-dismiss="modal">X</span>
            </div>
            <div class="modal-body">
                
                <ol>
                    <li>Click the button below once you've logged in and have full access to the account. </li>
                    <li>If you encounter any issues, Kindly create a <a href="{{route('user.tickets')}}">support ticket. </a> </li>
                </ol>
                <form action="{{route('user.listings.offer.b.confirm', $trx->id)}}" method="post">
                    @csrf
                    <input type="hidden" name="offer" value="{{$trx->id}}">
                    <button type="submit" class="w-100 btn btn-success" >CONFIRM DEAL</button>
                </form>
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
    .acc-details >.list-group-item{
        background: none;
    }
    .b-image{
        min-height: 250px;
        max-height:100%;
        width: auto;
        max-width: 100%;
        border: 3px solid #d5662f;
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
