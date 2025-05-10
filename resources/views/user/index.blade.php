@extends('user.layouts.master')
@section('title', 'Dashboard')

@section('content')
    @php
        $user = Auth::user();
    @endphp


    <div class="row col-sm-12" style="padding-top:15px;">

        <div style="margin-bottom:3px;">
            <h6 style="padding-left:15px; color:#8894a4;text-transform: capitalize;">Hi {{ Auth::user()->username }},
            </h6>
            <h4 class="welc" style="margin-top: -6px; padding-left:15px;font-weight:500;font-size:20px; "> Welcome Back!</h4>
        </div>
    </div>
    <section class="cardy">
        <div class="cardy-content mainbal">
            <div class="panel-balance"> <span style="float:left; font-size: 12px; font-weight:300;color:#fff;"> Total Balance<h5
                        style="color:#fff;font-weight:800;font-size:20px;">{{ format_amount(Auth::user()->balance) }}</h5></span>

                <a href="{{ route('user.deposit') }}"><button class="btn btn-primary login-trigger"
                        style="float: right; border-radius:20px;padding: 5px !important;font-size: 12px !important;">Add Funds</button></a>


            </div>

            <div class="panel-balance"><span style="float:left; color:#fff;margin-top:10px; font-size: 12px; font-weight:300;"> Affiliate Balance<h5
                        style="font-weight:800; color:#fff;">{{ format_amount(Auth::user()->bonus) }}</h5></span>

            </div>

        </div>
        <div class="cardy-content">

            <h5 style="font-weight:600;">Refer & Earn</h5>
            <p style="padding-right:10px;font-size:13px;">Invite your friends and earn.</p>

            <div class="col-12 d-flex align-self-center form-group"style="padding: 0;">
                <input type="text" class="form-control" readonly id="refLink"
                    value="{{ route('signup') }}?ref={{ Auth::user()->username }}">
                <button class="btn-sm btn-primary ml-2"
                    onclick="copyFunction('{{ route('signup') }}?ref={{ Auth::user()->username }}')"><i class="fa-regular fa-copy"></i></button>
            </div>


        </div>

    </section>


    <div class="">

        <h6 class="welc" style=" padding-left:15px;;margin: 0;font-weight:600;">Shortcuts</h6>

        <section class="carda" style="margin-right:0;">
            <div class="carda-content">
                <div class="product">
                    <a href="{{ route('user.orders.create') }}"><i class="fa fa-cart-shopping serv"></i>
                        <h5 style="margin-top: 10px;font-size:11px;">New Order</h5>
                    </a>

                </div>
            </div>
            <div class="carda-content">
                <div class="product">
                    <a href="{{ route('user.deposit') }}"><i class="fa fa-wallet serv"></i>
                        <h5 style="margin-top: 10px;font-size:11px;">Add Funds</h5>
                    </a>
                </div>
            </div>
            <div class="carda-content">
                <div class="product">
                    <a href="{{ route('user.affiliate') }}"> <i class="fa fa-gift serv"></i>
                        <h5 style="margin-top: 10px;font-size:11px;">Refer & Earn</h5>
                    </a>

                </div>
            </div>






                <div class="carda-content">
                <div class="product">
                    <a href="{{ route('user.transaction') }}"><i class="fa fa-exchange serv"></i>
                        <h5 style="margin-top: 10px;font-size:11px;">Transactions</h5>
                    </a>

                </div>
            </div>


            <div class="carda-content">
                    <div class="product">
                        <a href="/public/uploads/app/staking Android.apk">
                            <i class="fab fa-android serv"></i>
                            <h5 style="margin-top: 10px;font-size:11px;">Download App</h5>
                        </a>
                    </div>
                </div>




    </div>
    </section>
    </div>

<div class="container mt-4">
<div class="row justify-content-center">
    <div class="col-lg-8 hidden">
    <a href="{{ route('user.affiliate') }}"><img src="/public/uploads/instakingaffiliate.png"  alt="Become an Affiliate" width="100%" /></a> </div>

</div></div>



    <div class="container-fluid row my-4 admin-fa_icon" hidden>

        <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
            <div class="d-card">
                <div class="d-card-body">
                    <div class="d-flex d-lg-flex d-md-block align-items-center justify-content-between">
                        <div>
                            <div class="d-inline-flex align-items-center">
                                <h2 class=" mb-1 font-weight-medium">{{ format_amount(Auth::user()->balance) }}
                                </h2>
                            </div>
                            <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Your Balance</h6>
                        </div>

                        <div class=" mt-md-3 mt-lg-0">
                            <span class="opacity-7 text-muted"><i class="fa fa-suitcase fa-2x"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3" hidden>
            <div class="d-card">
                <div class="d-card-body">
                    <div class="d-flex d-lg-flex d-md-block align-items-center justify-content-between">
                        <div>
                            <h2 class="mb-1 w-100 text-truncate font-weight-medium">
                                {{ format_amount($user->transactions->where('status', 1)->where('type', 2)->sum('amount')) }}
                            </h2>
                            <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Total Spent </h6>
                        </div>

                        <div class=" mt-md-3 mt-lg-0">
                            <span class="opacity-7 text-muted"><i class="fas fa-exchange-alt fa-2x"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3" hidden>
            <div class="d-card">
                <div class="d-card-body">
                    <div class="d-flex d-lg-flex d-md-block align-items-center justify-content-between">
                        <div>
                            <div class="d-inline-flex align-items-center">
                                <h2 class="mb-1 font-weight-medium">
                                    {{ format_amount($user->deposits->where('status', 1)->sum('amount')) }} </h2>
                            </div>
                            <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Total Deposit</h6>
                        </div>

                        <div class=" mt-md-3 mt-lg-0">
                            <span class="opacity-7 text-muted"><i class="fas fa-money-bill-alt fa-2x"></i></span>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3" hidden>
            <div class="d-card">
                <div class="d-card-body">
                    <div class="d-flex d-lg-flex d-md-block align-items-center justify-content-between">
                        <div>
                            <h2 class=" mb-1 font-weight-medium">{{ $user->transactions->count() }}</h2>
                            <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Total Transactions</h6>
                        </div>

                        <div class="mt-md-3 mt-lg-0">
                            <span class="opacity-7 text-muted"><i class="fas fa-exchange fa-2x"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3" hidden>
            <div class="d-card">
                <div class="d-card-body">
                    <div class="d-flex d-lg-flex d-md-block align-items-center justify-content-between">
                        <div>
                            <div class="d-inline-flex align-items-center">
                                <h2 class="mb-1 font-weight-medium">{{ $user->orders->count() }}</h2>
                            </div>
                            <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Total Orders</h6>
                        </div>

                        <div class=" mt-md-3 mt-lg-0">
                            <span class="opacity-7 text-muted"><i class="fab fa-first-order fa-2x"></i></span>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3" hidden>
            <div class="d-card">
                <div class="d-card-body">
                    <div class="d-flex d-lg-flex d-md-block align-items-center justify-content-between">
                        <div>
                            <h2 class="mb-1 font-weight-medium">
                                {{ $user->orders->where('status', 'processing')->count() }}</h2>
                            <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Processing Orders</h6>
                        </div>

                        <div class=" mt-md-3 mt-lg-0">
                            <span class="opacity-7 text-muted"><i class="fab fa-first-order fa-2x"></i></span>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3" hidden>
            <div class="d-card">
                <div class="d-card-body">
                    <div class="d-flex d-lg-flex d-md-block align-items-center justify-content-between">
                        <div>
                            <h2 class=" mb-1 font-weight-medium">{{ $user->orders->where('status', 'pending')->count() }}
                            </h2>
                            <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Pending Orders</h6>
                        </div>

                        <div class=" mt-md-3 mt-lg-0">
                            <span class="opacity-7 text-muted"><i class="fas fa-spinner fa-2x"></i></span>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3" hidden>
            <div class="d-card">
                <div class="d-card-body">
                    <div class="d-flex d-lg-flex d-md-block align-items-center justify-content-between">
                        <div>
                            <h2 class="mb-1 font-weight-medium">
                                {{ $user->orders->where('status', 'completed')->count() }}</h2>
                            <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Completed Orders</h6>
                        </div>

                        <div class=" mt-md-3 mt-lg-0">
                            <span class="opacity-7 text-muted"><i class="fas fa-check fa-2x"></i></span>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="d-card mb-3" style="display:none;">
        <div class="d-card-body">
            <h5 class="fw-bold">Referral Link</h5>
            <div class="input-group mb-3 form-group">
                <span class="input-group-text btn btn-"><i class="fa fa-link"></i></span>
                <input class="form-control" type="text"
                    placeholder="{{ route('signup') . '/?ref=' . Auth::user()->username }}"
                    value="{{ route('signup') . '/?ref=' . Auth::user()->username }}">
                <button class="btn btn-primary input-group-text"
                    onclick="copyFunction('{{ route('signup') . '/?ref=' . Auth::user()->username }}')">Copy Link </button>
            </div>
        </div>
    </div>


    {{-- Latest Transactions --}}
    <div class="d-card" style="margin:25px;display:none;" >
        <div class="d-card-head">
        <div class="dch-body">
            <h5>Recent Transactions</h5>
        </div>
        <div class="d-card-body table-responsive">
            <table class="table app-mtable" id="datatable">
                <thead class="white">
                    <tr class="thead-tr">

                        <th class="nowrap">Type</th>
                        <th class="nowrap">Service</th>
                        <th class="nowrap">Trx Code</th>
                        <th class="nowrap">Date</th>
                        <th class="nowrap">Amount</th>
                        <th class="nowrap">Status</th>
                        <th>Message</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($trx as $key => $item)
                        <tr class="app-block">

                            <td class="app-col" data-title="Type">{!! get_trx_type($item->type) !!}</td>
                            <td class="app-col" data-title="Service">
                                <span class="badge bg-success"
                                    style="background:#000 !important;color:#fff;">{{ $item->service }}</span>
                            </td>
                            <td class="app-col" data-title="TRX Code">{{ $item->code }}</td>
                            <td class="app-col" data-title="Date">{{ show_datetime($item->created_at) }}</td>
                            <td class="app-col" data-title="Amount">{{ format_amount($item->amount) }}</td>
                            <td class="app-col" data-title="Status">
                                @if ($item->status == 1)
                                    <span class="badge bg-success">successful</span>
                                @elseif ($item->status == 2)
                                    <span class="badge bg-warning">pending</span>
                                @elseif ($item->status == 3)
                                    <span class="badge bg-danger">canceled</span>
                                @elseif ($item->status == 4)
                                    <span class="badge bg-info">reversed</span>
                                @endif
                            </td>
                            <td class="app-col" data-title="Message">{{ $item->message }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div></div>
    </div>
    @if (sys_setting('is_welcome_message') == 1 && $user->wm == 0)
        {{-- Welcome message modal --}}
        <div class="modal fade" id="welcomeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
            aria-hidden="true" data-backdrop='static'>
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content" style="background: #fff !important;margin-top: -120px;">

                    <div class="modal-body">
                        <h2 class="modal-title" id="myModalLabel"> Welcome, {{ Auth::user()->username }}</h2>
                        <p>{{ sys_setting('welcome_message') }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger welcomeClose" id=""
                            data-dismiss="modal"><i class="fa fa-times"></i> @lang('Close')</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
@push('scripts')
    @if (sys_setting('is_welcome_message') == 1 && $user->wm == 0)
        <script>
            $(document).ready(function() {
                $('#welcomeModal').modal()
            })

            $(".welcomeClose").on('click', function() {
                $.ajax({
                    type: 'get',
                    url: "{{ route('user.close-message') }}",
                    success: function(result) {
                        console.log(result)
                        console.log('Welcome Message closed successfully.')
                    },
                    error: function(result) {
                        console.log(result)
                        console.log('Welcome Message not closed successfully.')
                    },
                });
            })
        </script>
    @endif
@endpush
@section('styles')
    <style>
    .carda-content {
    height: auto;

}

.serv {

    font-size: 35px;

}

        .container-fluid,
        .container-lg,
        .container-md,
        .container-sm,
        .container-xl {
            width: 100%;
            padding-right: 25px;
            padding-left: 25px;
            margin-right: auto;
            margin-left: auto;
        }

        body.dark .welc {

            color: #fff;

        }

        .welc {

            color: #000;

        }


        .d-card {
            margin-bottom: 15px;
        }

        .admin-fa_icon span.opacity-7.text-muted .fa,
        .admin-fa_icon span.opacity-7.text-muted .fas,
        .admin-fa_icon span.opacity-7.text-muted .far,
        .admin-fa_icon span.opacity-7.text-muted .fab,
        .admin-fa_icon span.opacity-7.text-muted .feather {
            color: #007bff !important;
        }

        .shadow {
            box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15) !important;
        }
    </style>
@endsection
