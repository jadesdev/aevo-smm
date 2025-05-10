@extends('admin.layouts.master')
@section('title') {{$title}} @stop
@section('content')
<div class="d-card">
    <div class="card-header">
        <div class="d-flex align-items-center justify-content-between">
            <h5 class="mb-0">{{$title}} </h5>
        </div>
    </div>
    <div class="d-card-body table-responsive">
        <table class="table align-items-center table-bordered table-hover" id="datatable">
            <thead class="white">
            <tr>
                <th scope="col">Ticket</th>
                <th scope="col">Subject</th>
                <th scope="col">User</th>
                <th scope="col">Status</th>
                <th>Date</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody class="">
            @forelse($tickets as $ticket)
                <tr>
                    <td>{{ $ticket->ticket }}</td>
                    <td><a href="{{route('admin.support.reply', $ticket->ticket)}}">{{$ticket->subject}}</a></td>
                    <td>{{ $ticket->user->username }}</td>
                    <td>

                        @if($ticket->status == 3)
                            <span class="badge bg-danger">Closed</span>
                        @else

                            @php
                                $reply = \App\Models\TicketComment::orderBy('id', 'DESC')->where('ticket_id', $ticket->id)->first();
                            @endphp
                            @if ($reply->type == 0)
                                <span class="badge bg-primary">@lang('customer reply')</span>
                            @else
                                <span class="badge bg-info">@lang('admin reply')</span>
                            @endif
                            <span class="badge bg-success">Open</span>
                        @endif
                    </td>
                    <th>{{show_datetime($ticket->updated_at)}}</th>
                    <td>
                        <a href="{{ route('admin.support.reply', [slug($ticket->ticket)]) }}" class="btn btn-success btn-sm"><i class="fa fa-reply"></i></a>
                        <a href="{{ route('admin.support.delete', $ticket->id) }}" class="btn btn-rounded btn-danger"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="text-muted text-center" colspan="100%">No Support Tickets</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('styles')
<style>
    .btn.btn-success {
        padding: 5px 10px!important;
        font-size: 12px!important;
        height: auto!important;
        border-radius: 5px!important;
    }
</style>
@endsection
