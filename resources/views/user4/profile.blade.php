@extends('user4.layouts.master')
@section('title', 'Profile Setting')

@section('content')
<div class="row">
    <div class="col-lg-12">
       <section class="order-side">
            <div class="row">
                <div class="col-lg-6 col-12 mb-5 mb-lg-0">
                    <div class="card dc-blue">
                        <h5 class="fw-bold card-header">Update Profile</h5>
                        <div class="card-body" id="dc-body">
                            <form action="{{route('user.profile')}}" class="sub-form" method="post">
                                @csrf
                                <div class="form-group mb-4">
                                    <label class="control-label">Full Name</label>
                                    <div class="input-group">
                                        <input class="form-control mr-3" placeholder="First Name" type="text" value="{{Auth::user()->fname}}" name="fname" required />
                                        <input class="form-control" type="text" value="{{Auth::user()->lname}}" placeholder="Last Name" required name="lname"/>
                                    </div>
                                </div>
                                <div class="form-group mb-4">
                                    <label class="control-label">Username</label>
                                    <div class="input-group">
                                        <input class="form-control" name="username" type="text" value="{{Auth::user()->username}}" required />
                                    </div>
                                </div>
                                <div class="form-group mb-4">
                                    <label class="control-label">Email Address</label>
                                    <div class="input-group">
                                        <input class="form-control" type="text" value="{{Auth::user()->email}}" readonly />
                                    </div>
                                </div>
                                <div class="form-group mb-4">
                                    <label class="form-label" for="phone">Phone Numer</label>
                                    <input class="form-control" required name="phone" type="tel" value="{{Auth::user()->phone}}" placeholder="Phone Number">
                                </div>
                                <div class="form-group mb-4">
                                    <label class="form-label" for="address">Address</label>
                                    <input class="form-control" name="address" type="text" value="{{Auth::user()->address}}" placeholder="Address">
                                </div>

                                <button class="btn btn-primary btn-lg btn-block btn-sub">Update</button>
                            </form>
                        </div>
                    </div>
                    <!-- card end -->
                </div>
                <div class="col-lg-6 col-12 mb-5 mb-lg-0">

                    <div class="card dc-orange mt">
                        <div class="card-body">
                            <form>
                                <div class="form-group mb-4">
                                    <label for="language" class="control-label">API Key</label>
                                    <input class="form-control" type="text" value="{{Auth::user()->api_token}}" readonly />
                                </div>
                                <a href="{{route('user.apikey')}}" class="btn btn-secondary btn-lg btn-block">Generate New Key</a>
                            </form>
                        </div>
                    </div>
                    <!-- card end -->
                    <div class="card mt-4">
                        <h5 class="fw-bold card-header">Change Password</h5>
                        <div class="card-body" id="dc-body">
                            <form method="post" action="{{route('user.password')}}" class="sub-form">
                                @csrf
                                <div class="form-group mb-4">
                                    <label class="control-label">Current Password</label>
                                    <div class="input-group">
                                        <input class="form-control" type="password" name="old_password" required />
                                    </div>
                                </div>
                                <div class="form-group mb-4">
                                    <label class="control-label">New Password</label>
                                    <div class="input-group">
                                        <input class="form-control" type="password" name="password" required />
                                    </div>
                                </div>
                                <button class="btn btn-primary btn-lg btn-block">Change Password</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
       </section>
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
                    Update your Account
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    document.getElementById('verifyMethod').addEventListener('change', function() {
        // Get the selected option value
        var selectedMethod = this.value;
        // Hide both divs initially
        document.getElementById('ninDiv').style.display = 'none';
        document.getElementById('bvnDiv').style.display = 'none';

        // Show the selected div
        if (selectedMethod === 'nin') {
            document.getElementById('ninDiv').style.display = 'block';
        } else if (selectedMethod === 'bvn') {
            document.getElementById('bvnDiv').style.display = 'block';
        }
    });
</script>
@endpush
