@extends('user.layouts.master')
@section('title', 'Edit Product')

@section('content')
<div class="row">
    <div class="col-lg-12 col-12 mb-5 mb-lg-0">
        <div class="d-card">
            @include('alerts.alert')
            <div class="d-card-body" id="dc-body">
                <form action="" method="post" class="row" enctype="multipart/form-data">
                    @csrf
                    <h6 class="fw-bold col-12">Information</h6>
                    <div class="form-group col-md-6">
                        <label class="form-label">Account Name</label>
                        <input class="form-control" required type="text" name="name" value="{{$listing->name}}" maxlength="50" placeholder="Account Name" />
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label">Account Link</label>
                        <input class="form-control" required type="url" name="link" value="{{$listing->link}}" placeholder="https://" id="" />
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label">Followers / Subscribers</label>
                        <input class="form-control" required type="number" name="followers" value="{{$listing->followers}}" placeholder="Followers or Subscriber Count" id="" />
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label">Followings</label>
                        <input class="form-control" required type="text" name="followings" value="{{$listing->followings}}" placeholder="Following" />
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label">Account Age</label>
                        <input class="form-control" required type="text" name="age" value="{{$listing->age}}" placeholder="3 Years" />
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label">Enter Price ({{get_setting('currency')}}) [{{sys_setting('seller_rate')}}% fee]</label>
                        <input class="form-control" required type="number" name="price" value="{{$listing->amount}}" placeholder="Enter Price {{get_setting('currency')}}" id="" />
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label">Follower Type</label>
                        <select name="follower_type" class="form-control square" required>
                            <option value="mixed" @if($listing->follower_type == "mixed") selected @endif  >Mixed Followers</option>
                            <option value="nigerian" @if($listing->follower_type == "nigerian") selected @endif >Nigerian Followers</option>
                            <option value="foreign" @if($listing->follower_type == "foreign") selected @endif >Foreign Followers</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label">Description</label>
                        <textarea name="about" class="form-control" id="about" rows="5" required placeholder="write anything about the account">{{$listing->about}}</textarea>
                    </div>
                    <span class="hr"></span>
                    <h6 class="fw-bold col-12">Account Credentials</h6>
                    <div class="form-group col-md-6">
                        <label class="form-label">Username</label>
                        <input class="form-control" required type="text" name="username" value="{{$listing->username}}" placeholder="Account Username" />
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label">Email</label>
                        <input class="form-control" required type="text" name="email" value="{{$listing->email}}" placeholder="Account Email" />
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label">Password</label>
                        <input class="form-control" required type="text" name="password" value="{{$listing->password}}" placeholder="Account Password" />
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label">Mobile Number</label>
                        <input class="form-control" required type="text" name="mobile" value="{{$listing->mobile}}" placeholder="Mobile Number" />
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label">Other Images 1</label>
                        <input type="file" name="image1" id="image1" class="form-control" accept="image/*"  onchange="preview_picture1(event)">
                        <img id="pimage1" class="bimage" src="{{my_asset($listing->image1)}}"/>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label">Other Images 2</label>
                        <input type="file" name="image2" id="image2" class="form-control" accept="image/*" onchange="preview_picture2(event)">
                        <img id="pimage2" class="bimage" src="{{my_asset($listing->image2)}}"/>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label">Other Information</label>
                        <textarea name="other_info" class="form-control" id="other_info" rows="5" >{{$listing->other_info}}</textarea>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label">Preview Image</label>
                        <input type="file" name="preview" id="preview" class="form-control" accept="image/*" onchange="preview_picture(event)">
                        <img id="pimage" class="b-image mb-2" src="{{my_asset($listing->preview)}}"/>
                    </div>

                    <button class="btn btn-primary w-100" type="submit">Update Listing</button>
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
                    Start Selling your social media accounts. {{sys_setting('seller_rate')}}% fee applies. <a href="{{route('user.listings.index')}}">View all Listings. </a>
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
    .bimage{
        max-width: 50%;
        /* min-height: 250px; */
        max-height:50%;
        width: auto;
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
    function preview_picture1(event)
    {
        document.getElementById('pimage1').classList.remove('d-none');
        var reader = new FileReader();
        reader.onload = function()
        {
            var output = document.getElementById('pimage1');
            output.src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }
    function preview_picture2(event)
    {
        document.getElementById('pimage2').classList.remove('d-none');
        var reader = new FileReader();
        reader.onload = function()
        {
            var output = document.getElementById('pimage2');
            output.src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endpush
