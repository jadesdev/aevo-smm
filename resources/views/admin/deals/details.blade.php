@extends('admin.layouts.master')
@section('title', $title)

@section('content')
<div class="d-card">
    <div class="card-header">
        <div class="d-flex align-items-center justify-content-between">
            <h5 class="mb-0">{{$title}}</h5>
        </div>
    </div>
    <div class="d-card-body table-responsive">
        <div class="row">
            <div class="col-md-6">
                <h6 class="fw-bold">Details</h6>
                <ul class="list-group acc-details">
                    <li class="list-group-item d-flex justify-content-between">
                        <span class="text-muted">Seller</span>
                        <h6 class="text-primary">{{$listing->user->username ?? ""}}</h6>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span class="text-muted">Buyer</span>
                        <h6 class="text-primary">{{$trx->buyer->username ?? "Not Sold"}}</h6>
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
                        <h6> <a href="{{$listing->link}}" target="__blank">{{$listing->link}}</a> </h6>
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

                <div class="mt-3">
                    <span class="text-muted">Description</span>
                    <p>{{$listing->about}}</p>
                </div>
            </div>

            <div class="col-md-6">
                <h6 class="fw-bold">Account Information</h6>
                <ul class="list-group acc-details">
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
                <h6 class="fw-bold my-2">Account Credentials</h6>
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
                <h6 class="fw-bold mt-3">Preview Image</h6>
                <img id="pimage" class="b-image mb-2" src="{{my_asset($listing->preview)}}"/>

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
                    Manage all Listings.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('styles')
<style>
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
