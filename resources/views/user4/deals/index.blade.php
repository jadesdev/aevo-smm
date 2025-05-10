@extends('user4.layouts.master')
@section('title', 'Buy Cheap Social Media Accounts')

@section('content')

<div class="card mb-3">
    <div class="card-body border-0 pb-0 pt-3">
        <form action="" method="get">
        <div class="row justify-content-end">
            <div class="col-md-5 col-sm-6">
                <div class="form-group">
                    <select class="form-control form-select" name="category"  onchange="window.location.href = this.options[this.selectedIndex].getAttribute('data-link')" >
                        <option value="" data-link="?category=" selected="">@lang('Select Category')</option>
                        <option value="facebook" data-link="?category=facebook" {{("facebook" == request()->input('category')) ? 'selected' : ''}}>Facebook</option>
                        <option value="instagram" data-link="?category=instagram" {{("instagram" == request()->input('category')) ? 'selected' : ''}}>Instagram</option>
                        <option value="twitter" data-link="?category=twitter" {{("twitter" == request()->input('category')) ? 'selected' : ''}}>Twitter Accounts</option>
                        <option value="youtube" data-link="?category=youtube" {{("youtube" == request()->input('category')) ? 'selected' : ''}}>Youtube Channels</option>
                        <option value="tiktok" data-link="?category=tiktok" {{("tiktok" == request()->input('category')) ? 'selected' : ''}}>Tiktok</option>
                        <option value="telegram" data-link="?category=telegram" {{("telegram" == request()->input('category')) ? 'selected' : ''}}>Telegram</option>
                        <option value="snapchat" data-link="?category=snapchat" {{("snapchat" == request()->input('category')) ? 'selected' : ''}}>Snapchat</option>
                        <option value="pinterest" data-link="?category=pinterest" {{("pinterest" == request()->input('category')) ? 'selected' : ''}}>Pinterest</option>
                        <option value="others" data-link="?category=others" {{("others" == request()->input('category')) ? 'selected' : ''}}>Other Accounts</option>
                    </select>
                </div>
            </div>
            <div class="col-md-5 col-sm-6">
                <div class="form-group">
                    <input type="text" name="search" id="searchName" value="{{@request()->search}}" class="form-control" placeholder="@lang('Search for Listings')">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <button type="submit" id="searchBtn" class="btn w-100 btn-primary">
                        <i class="fas fa-search"></i> @lang('Search')
                    </button>
                </div>
            </div>
        </div>
        </form>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 col-12 mb-5 mb-lg-0">
        <div class="row g-3">
            @forelse ($listings as $item)
            <div class="col-sm-6 col-lg-4">
                <div class="product-card">
                    @if($item->preview)
                    <img class="product-image" src="{{ my_asset($item->preview) }}" alt="{{ $item->name }}">
                    @endif
                    <div class="product-details">
                        <div class="product-title">{{$item->name}}</div>
                        <div class="row justify-content-between my-2 p-2 td">
                            <small class="text-uppercase"><i class="fa fa-tag"></i> {{$item->account_type}}</small>
                            <span class=""><i class="fa fa-user-group"></i> {{shortNumber($item->followers)}}</span>
                            <span><i class="fa fa-clock"></i> {{$item->age}} yrs</span>
                        </div>
                        <p>{{text_trim($item->about, 100)}}.</p>
                        <div class="product-price"><i class="fa fa-shopping-cart"></i> {{format_price($item->amount)}}</div>
                        <a href="{{route('user.listings.view', $item->id)}}" class="buy-now-btn w-100 btn btn-primary">View Account</a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center">
                        <p>No Listings found.</p>
                    </div>
                </div>
            </div>
            @endforelse
        </div>

        <span>{{$listings->links()}}</span>
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
                    Swap social media accounts with us. </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('styles')
<style>
    .product-card {
        border: 1px solid #ddd;
        border-radius: 8px;
        overflow: hidden;
        margin-bottom: 20px;
        background:#fff;
        padding: 20px;
    }

    .product-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    .product-details {
        padding: 15px;
        background: none;
        font-size:14px;
    }

    .product-title {
        font-size: 18px;
        font-weight:600 ;
        margin-bottom: 10px;

    }

    .product-description {
        font-size: 13px;
        color: #1f1b1b;
        margin-bottom: 15px;
    }

    .buy-now-btn {
        display: block;
        width: 100%;
        padding: 10px;
        background-color: #3498db;
        color: #fff;
        text-align: center;
        text-decoration: none;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .buy-now-btn:hover {
        background-color: #2980b9;
    }
    .product-price {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    body.dark .product-card {
        border: 1px solid #555;
        background-color: #000000;
    }

    body.dark .product-image {
        filter: brightness(70%);
    }

    body.dark .product-details {
        padding: 15px;
    }

    body.dark .product-title {
        color: #fff;
    }

    body.dark .td, body.dark .product-description {
        color: #d4d1d1;
    }

    body.dark .buy-now-btn:hover {
        background-color: #154360;
    }

    body.dark .product-price {
        color: #fff;
    }
</style>

@endsection
