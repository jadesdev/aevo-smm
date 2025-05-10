@extends('user4.layouts.master')
@section('title', 'Support Tickets')
@section('breadcrumb')
<div class="card dc-dash">
    <div class="row">
        <div class="col-lg-6 col-md-8 col-12">
            <div class="py-3 px-5">
                <div class="dch-title">
                   @yield('title')
                </div>
                <div class="dch-text">
                    Contact Support for all Enquires and Questions
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12 col-12 mb-5 mb-lg-0">
        <div class="card">
            <div class="card-header">
                <div class="dch-body">
                    <i class="icon far fa-comment-dots me-3"></i>
                    <span class="ml-3">{{$ticket->subject}}</span>
                </div>
            </div>

            <div class="card-body" id="dc-body">
                <form action="{{ route('user.ticket.comment', $ticket->id) }}" method="POST">
                    @csrf

                    @forelse($ticket->comments as $comment)
                        @if($comment->type == 0)
                        <div class="row ticket-message-block ticket-message-right">
                            <div class="col-md-1"></div>
                            <div class="col-md-11" style="margin-bottom: 10px;">
                                <div class="ticket-message">
                                    <div class="message">
                                        {!! nl2br(e($comment->comment)) !!}
                                    </div>
                                </div>
                                <div class="info text-right mt-2" style="font-size: 13px;">
                                    <strong>{{$ticket->user->username}}</strong>
                                    <small class="text-muted">{{($comment->created_at)}}</small>
                                </div>
                            </div>
                            <div class="col-md-1"></div>
                        </div>
                        @else
                        <div class="row ticket-message-block ticket-message-left">
                            <div class="col-md-11" style="margin-bottom: 10px;">
                                <div class="ticket-message">
                                    <div class="message">
                                        {!! nl2br(($comment->comment)) !!}
                                    </div>
                                </div>
                                <div class="info mt-2" style="font-size: 13px;">
                                    <strong>Support Team <img src="{{static_asset('img/verified.png')}}" width="20" /></strong>
                                    <small class="text-muted">{{$comment->created_at}}</small>
                                </div>
                            </div>
                            <div class="col-md-1"></div>
                        </div>
                        @endif

                    @empty
                        <div class="row">
                            <div class="col-md-12 ticket-message-block ">
                                <h5>No ticket message</h5>

                            </div>
                        </div>
                    @endforelse

                    <div class="form-group message mt-5">
                        <label for="message" class="control-label">Your Message</label>
                        <textarea class="form-control" rows="7" id="message" name="comment" style="height: 150px !important;"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg btn-block">Reply</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('styles')
<style>
    .ticket-message-right .ticket-message {
        font-size: 13px;
        background: #151428;
        -webkit-border-radius: 10px;
        -moz-border-radius: 10px;
        border-radius: 10px;
        padding: 15px;
    }

    .ticket-message-left .ticket-message {
        font-size: 13px;
        background: #fa7f41;
        -webkit-border-radius: 10px;
        -moz-border-radius: 10px;
        border-radius: 10px;
        padding: 15px;
    }

</style>
@endsection
