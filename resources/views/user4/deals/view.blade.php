@extends('user4.layouts.master')
@section('title', 'Buy Social Media Accounts')

@section('content')
    <div class="ow">
        <div class="col-md-12 card col-12 row fiti" style="  margin-left: 0;">
            <div class="col-md-6">
                <div class="cardy">
                    <div class="card-body pb-2">

                        <div id="my-gallery">
                            <a href="{{ my_asset($listing->preview) }}" data-pswp-width="auto" data-pswp-height="auto"
                                target="_blank">
                                <img class="b-image mb-2" src="{{ my_asset($listing->preview) }}" alt="" />
                            </a>
                        </div>

                        <span style="display:none;"><b>About</b>
                            <p>{!! nl2br($listing->about) !!}</p>
                        </span>

                        {{-- Image gallery --}}
                        <div class="portfolio-item row">
                            <div class="item selfie col-lg-3 col-md-4 col-6 col-sm">
                                <a href="{{ my_asset($listing->image1) }}" class="fancylight popup-btn" data-fancybox-group="light">
                                    <img class="img-fluid" src="{{ my_asset($listing->image1) }}" alt="">
                                </a>
                            </div>
                            <div class="item selfie col-lg-3 col-md-4 col-6 col-sm">
                                <a href="{{ my_asset($listing->image2) }}" class="fancylight popup-btn" data-fancybox-group="light">
                                    <img class="img-fluid" src="{{ my_asset($listing->image2) }}" alt="">
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-body">

                    <h4 class="primary" style="color:#fa7f41;">{{ $listing->name }}</h4><br>
                    <h6 class="r">Account Information</h6>
                    <div class=" pb-1">
                        <ul class="list-group acc-details" style="text-transform:capitalize;">

                            <li class="list-group-item text-dark"><span style="float:left;">Platform</span> <span
                                    style="float:right;">{{ $listing->account_type }}</span> </li>
                            <li class="list-group-item text-dark"><span style="float:left;">Followers Count</span> <span
                                    style="float:right;">{{ shortNumber($listing->followers) }}</span> </li>
                            <li class="list-group-item text-dark"><span style="float:left;">Follower Type</span> <span
                                    style="float:right;">{{ $listing->follower_type }}</span> </li>
                            <li class="list-group-item text-dark"><span style="float:left;">Account Age</span> <span
                                    style="float:right;">{{ $listing->age }}yrs</span> </li>
                            <li class="list-group-item text-dark"><span style="float:left;">Seller</span> <span
                                    style="float:right;">{{ $listing->user->username }}</span> </li>

                        </ul>

                        <br>


                        <div class=""><span style="float:left;">
                                <h5 class="primary" style="color:#fa7f41;">{{ format_price($listing->amount) }}</h5>
                            </span> <span style="float:right;">
                                @if ($listing->sold == 1)
                                    <a href="#" data-toggle="modal" class="btn btn-success">SOLD</a>
                                @else
                                    <a href="#" data-toggle="modal" data-target="#buyListing"
                                        class=" btn btn-primary"> <i class="fa fa-cart-plus"></i> Buy Now</a>
                                @endif
                            </span> </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 mt-5">
            <h5 class="fw-bold card-header mb-2">Similar Accounts</h5>
            <div class="row g-3">
                @forelse ($similar as $item)
                    <div class="col-md-4">
                        <div class="card" style="padding:10px;">
                            <div class="card-body pb-2">
                                <h5 class="my-0">{{ $item->name }}</h5>
                                <hr class="mt-3">
                                <div class=" justify-content-between my-2" style="text-transform:capitalize;">
                                    <span style="margin-right:10px;"> <i class="fa fa-tag"></i>
                                        {{ $item->account_type }}</span>
                                    <span style="margin-right:10px;"><i class="fa fa-user-group"></i>
                                        {{ shortNumber($item->followers) }}</span>
                                    <span style="margin-right:10px;"><i class="far fa-clock"></i>
                                        {{ $item->age }}yrs</span>
                                </div>
                                <p class="mt-3">{{ text_trim($item->about) }}</p>
                                <div class="justify-content-between mt-2">
                                    <h5>{{ format_price($item->amount) }}</h5>

                                </div>
                            </div>
                            <a href="{{ route('user.listings.view', $item->id) }}" class="w-100 btn btn-primary">View
                                Account</a>
                        </div>
                    </div>
                @empty
                    <div class="card">
                        <div class="card-body pb-2">
                            <p class="fw-bold my-0">No Listings found</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    <div class="modal fade" id="buyListing">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="display:none;">
                    <h4 class="modal-title">{{ $listing->name }}</h4>
                    <span type="button" class="text-white close" data-dismiss="modal">X</span>
                </div>
                <div class="modal-body">
                    <h5>You're about to buy this account for {{ format_price($listing->amount) }}.</h5>
                    <p> Select an option below to make payment.</p>
                    <p hidden class="fw-bold">Transaction steps when using our service:</p>
                    <ol hidden>
                        <li>The buyer pays for the account and payment is held on our system. </li>
                        <li>Upon approved payment, the account credentials are released to the buyer. </li>
                        <li>If you encounter any issues, Kindly create a <a href="{{ route('user.tickets') }}">support
                                ticket. </a> </li>
                    </ol>
                    <form action="{{ route('user.listings.buy') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="fw-bold">Payment Method:</label>
                            <select name="payment_method" id="" class="form-control">
                                <option value="wallet">Wallet Balance</option>
                                <option value="gateway">Monnify</option>
                            </select>
                        </div>
                        <input type="hidden" name="listing" value="{{ $listing->id }}">
                        <button type="submit" class="w-100 btn btn-success">Make Payment</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @if (1 == '4')
        <div class="modal fade" id="offerListing">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Make offer for {{ $listing->name }}</h5>
                        <span type="button" class="text-white close" data-dismiss="modal">X</span>
                    </div>
                    <div class="modal-body">

                        <p class="fw-bold">Transaction steps when using our service:</p>
                        <ol>
                            <li>The buyer pays for the account and payment is held on our system. </li>
                            <li>The seller transfers login details and the original email account to the buyer. </li>
                            <li>The buyer checks everything, changes the login details. </li>
                            <li>After the buyer and seller's confirmation, the system release the payment to the seller.
                            </li>
                            <li>If you encounter any issues, Kindly create a <a href="{{ route('user.tickets') }}">support
                                    ticket. </a> </li>
                        </ol>
                        <form action="{{ route('user.listings.offer') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="" class="form-label">Price</label>
                                <input type="text" disabled class="form-control"
                                    value="{{ format_price($listing->amount) }}">
                            </div>
                            <div class="form-group">
                                <label for="" class="form-label">Offer Amount</label>
                                <input type="number" name="amount" class="form-control" placeholder="Offer amount"
                                    required>
                            </div>
                            <input type="hidden" name="listing" value="{{ $listing->id }}">
                            <button type="submit" class="w-100 btn btn-success">MAKE OFFER</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
    {{-- Modals --}}
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
                        Swap social media accounts with us. </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/photoswipe@5.2.2/dist/photoswipe.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.css" />
    <style>

    .modal {
    top: 0;
}

        .modal-content {
            background-color: #fff;
        }

        .modal-header {
            background: #000000;
            border: none;
        }

        .b-image {
            min-height: 40px;
            max-height: 100%;
            width: auto;
            max-width: 100%;
            margin-bottom:20px !important;
            border: 1px solid #fa7f41;
        }

        .list-group-item {
            position: relative;
            display: block;
            padding: .75rem 1.25rem;
            background-color: #fff;
            border: 0;
            padding-left: 0;
            border-bottom: 1px solid rgba(0, 0, 0, .125);
        }


.fiti {

                padding:50px 0;
            }

        @media screen and (max-width: 600px) {

            .card .card-body {
                padding: 20px 10px 25px 10px;
            }

            .fiti {

                padding:10px 0;
            }
        }
    </style>
    <style>
        .portfolio-menu{
            text-align:center;
        }
        .portfolio-menu ul li{
            display:inline-block;
            margin:0;
            list-style:none;
            padding:10px 15px;
            cursor:pointer;
            -webkit-transition:all 05s ease;
            -moz-transition:all 05s ease;
            -ms-transition:all 05s ease;
            -o-transition:all 05s ease;
            transition:all .5s ease;
        }

        .portfolio-item{
            /*width:100%;*/
        }
        .portfolio-item .item{
            /*width:303px;*/
            float:left;
            margin-bottom:10px;
        }
        .img-fluid{
            height: 80px;
            width: auto;
            border: 2px solid #fa7f41;
        }
    </style>
@endsection
@push('scripts')
    <script type="module">
        import PhotoSwipeLightbox from 'https://unpkg.com/photoswipe/dist/photoswipe-lightbox.esm.js';

        const lightbox = new PhotoSwipeLightbox({
            gallery: '#my-gallery',
            children: 'a',
            pswpModule: () => import('https://unpkg.com/photoswipe'),
        });

        lightbox.init();
    </script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.isotope/3.0.6/isotope.pkgd.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.js"></script>
<script>
    $('.portfolio-menu ul li').click(function(){
        $('.portfolio-menu ul li').removeClass('active');
        $(this).addClass('active');
        var selector = $(this).attr('data-filter');
        $('.portfolio-item').isotope({
            filter:selector
        });
        return  false;
    });
    $(document).ready(function() {
        var popup_btn = $('.popup-btn');
        popup_btn.magnificPopup({
            type : 'image',
            gallery : {
                enabled : true
            }
        });
    });
</script>
@endpush
