@extends('admin.layouts.master')
@section('title', 'Panel Status')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="d-card">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span class="fw-medium text-uppercase">Panel name:</span>
                    <span class="fw-medium">{{ ($panel['name']) }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="fw-medium text-uppercase">Status:</span>
                    <span class="fw-medium">  {!!(get_status($panel['status']))!!} </span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="fw-medium text-uppercase">Created at:</span>
                    <span class="fw-medium">{{ show_datetime1($panel['created_at']) }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="fw-medium text-uppercase">Payment Status:</span>
                    <span class="fw-medium">{!!(get_payout_status($panel['paid']))!!}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="fw-medium text-uppercase"> Payment Starts:</span>
                    <span class="fw-medium">@if($panel['start_date']) {{ show_datetime2($panel['start_date']) }} @else None @endif</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="fw-medium text-uppercase">Next Payment:</span>
                    <span class="fw-medium">@if($panel['end_date']) {{ show_datetime2($panel['end_date']) }} @else None @endif</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="d-card">
            @if($panel['status'] != 4 )
            <div class="countdown-section">
                <p class="fw-bold">Next Payment On</p>
                <div class="countdown">
                    <div class="time-section">
                        <span class="time" id="days">00</span>
                        <span class="label">Days</span>
                    </div>
                    <div class="time-section">
                        <span class="time" id="hours">00</span>
                        <span class="label">Hr</span>
                    </div>
                    <div class="time-section">
                        <span class="time" id="minutes">00</span>
                        <span class="label">Min</span>
                    </div>
                    <div class="time-section">
                        <span class="time" id="seconds">00</span>
                        <span class="label">Sec</span>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>


@endsection

@section('breadcrumb')

@endsection
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
    // const countdownDate = new Date("June 30, 2024 00:00:00").getTime();
    const countdownDate = new Date("{{$panel['end_date']}}").getTime();

    const countdown = setInterval(() => {
        const now = new Date().getTime();
        const distance = countdownDate - now;

        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        document.getElementById('days').innerText = days;
        document.getElementById('hours').innerText = hours;
        document.getElementById('minutes').innerText = minutes;
        document.getElementById('seconds').innerText = seconds;

        if (distance < 0) {
            clearInterval(countdown);
            document.querySelector('.countdown').innerHTML = "<div class='badge bg-warning p-3'>Panel Disabled! Please Renew </div>";
        }
    }, 1000);
});
</script>
@endpush
@section('styles')
<style>
    .countdown-section{
        background: rgba(255, 255, 255, 0.1);
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
        text-align: center;
        margin: 20px auto;
        width: auto;
    }
    .countdown-section p {
        font-size: 2em;
        margin-bottom: 20px;
        margin-top: 0;
    }
    .countdown {
        display: flex;
        justify-content: space-around;
        align-items: center;
    }

    .time-section {
        margin: 0 5px;
    }

    .time {
        display: block;
        font-size: 2.3em;
    }

    .label {
        font-size: 1em;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-top: 10px;
        color: #c07524;
    }
</style>
@endsection
