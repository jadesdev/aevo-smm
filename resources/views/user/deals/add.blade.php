@extends('user.layouts.master')
@section('title', 'Start Selling')

@section('content')
<div class="row">
    <div class="col-lg-12 col-12 mb-5 mb-lg-0">
        <div class="d-card">
            @include('alerts.alert')
            <div class="d-card-body" id="dc-body">
                <form action="" method="post" class="row" enctype="multipart/form-data">
                    @csrf
                    <h4 class="fw-bold col-12">Account Information</h4><br><br>
                    <div class="form-group col-md-6">
                        <label class="form-label">Title</label>
                        <input class="form-control" required type="text" name="name" value="{{old('name')}}" maxlength="50" placeholder="Listing title" />
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label">Platform</label>
                        <select name="account_type" class="form-control square" required>
                            <option value="select">Select One</option>
                            <option value="instagram">Instagram Page</option>
                            <option value="facebook">Facebook Accounts</option>
                            <option value="twitter">Twitter Accounts</option>
                            <option value="youtube">Youtube Channels</option>
                            <option value="tiktok">Tiktok</option>
                            <option value="telegram">Telegram</option>
                            <option value="snapchat">Snapchat</option>
                            <option value="pinterest">Pinterest</option>
                            <option value="others">Others</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label">Account Link</label>
                        <input class="form-control" required type="url" name="link" value="{{old('link')}}" placeholder="https://" id="" />
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label">Total Followers</label>
                        <input class="form-control" required type="number" name="followers" value="{{old('followers')}}" placeholder="How many followers do you have?" id="" />
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label">Followings</label>
                        <input class="form-control" required type="text" name="followings" value="{{old('followings')}}" placeholder="How many accounts do you follow?" />
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label">Account Age</label>
                        <input class="form-control" required type="number" name="age" value="{{old('age')}}" placeholder="E.g 3" />
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label">Follower Type</label>
                        <select name="follower_type" class="form-control square" required>
                            <option value="m">Select One</option>
                            <option value="mixed">Mixed Followers</option>
                            <option value="nigerian">Nigerian Followers</option>
                            <option value="foreign">Foreign Followers</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label">Enter Price ({{get_setting('currency')}}) [{{sys_setting('seller_rate')}}% fee]</label>
                        <input class="form-control" required type="number" name="price" value="{{old('price')}}" placeholder="E.g 25000" id="" />
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label">Description</label>
                        <textarea name="about" class="form-control" id="about" rows="5" required placeholder="About the account">{{old('about')}}</textarea>
                    </div>
                    <span class="hr"></span><br />
                    <h4 style="margin-top: 35px;" class="fw-bold col-12 card-title m-t-1">Account Credentials</h4>
                    <p style="margin-bottom: 15px;" class="col-12">Your account details are safe, only released to the the buyer after payment is confirmed.</p><br><br>
                    <span class="hr"></span>
                    <div class="form-group col-md-6">
                        <label class="form-label">Username</label>
                        <input class="form-control" required type="text" name="username" value="{{old('username')}}" placeholder="Account's username" />
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label">Email Address</label>
                        <input class="form-control" required type="text" name="email" value="{{old('email')}}" placeholder="Email address linked to the account" />
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label">Password</label>
                        <input class="form-control" required type="text" name="password" value="{{old('password')}}" placeholder="Account Password" />
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label">Phone Number</label>
                        <input class="form-control" required type="text" name="mobile" value="{{old('mobile')}}" placeholder="Phone Number" />
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label">Preview Image</label>
                        <input type="file" name="preview" id="preview" class="form-control" required accept="image/*" onchange="preview_picture(event)">
                        <img id="pimage" class="d-none b-image mb-2"/>
                    </div>
                    
                    <div class="form-group col-md-6">
                        <label class="form-label">Profile Screenshot</label>
                        <input type="file" name="image1" id="image1" class="form-control" required accept="image/*">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label">Followers Statistics Screenshot</label>
                        <input type="file" name="image2" id="image2" required class="form-control" accept="image/*">
                    </div>
                    <div class="form-group col-md-6" style="display:none;">
                        <label class="form-label">Other Information</label>
                        <textarea name="other_info" class="form-control" id="other_info" rows="5" >{{old('other_info')}}</textarea>
                    </div>
                    
<br><br>
                    <button class="btn btn-primary w-100" type="submit">Sell Account</button>
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
                    Start Selling your social media accounts. [{{sys_setting('seller_rate')}}% fee applies.] <a href="{{route('user.listings.index')}}">View all Listings. </a>
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
</style>
@endsection

@push('scripts')
<script>
    function preview_picture(event)
    {
        document.getElementById('pimage').classList.remove('d-none');
        var reader = new FileReader();
        reader.onload = function()
        {
            var output = document.getElementById('pimage');
            output.src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endpush
