@extends('user.layouts.master')
@section('title', 'Profile Setting')

@section('content')
<div class="row">
    <div class="col-lg-12">
       <section class="order-side">
            <div class="row">
                <div class="col-lg-6 col-12 mb-5 mb-lg-0">
                    <div class="d-card dc-blue">
                        <h5 class="fw-bold card-header">Update Profile</h5>
                        <div class="d-card-body" id="dc-body">
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
                    <!-- d-card end -->
                </div>
                <div class="col-lg-6 col-12 mb-5 mb-lg-0">
                    @if(Auth::user()->kyc_status != 1)
                    <div class="d-card mb-3" style="display:none;">
                        <h5 class="card-header">Verify KYC</h5>
                        <div class="d-card-body">
                            <h6 class="fw-bold">Why is KYC Verification Important?</h6>
                            <p> Verification is required for all customers to comply with KYC regulations, ensuring adherence to CBN policies, preventing fraudulent transactions, and maintaining effective services. <br>
                                Your information is used for verification purposes only and is not shared. </p>
                            <form method="POST" action="{{route('user.verify-kyc')}}">
                                @csrf
                                <div class="form-group d-none">
                                    <label for="language" class="form-label">Verification Method</label>
                                    <select name="verify_method" class="form-select form-control" id="verifyMethod">
                                        <option value="null" >Select Method</option>
                                        <option value="bvn" selected>BVN</option>
                                        {{-- <option value="nin">NIN</option> --}}
                                    </select>
                                </div>
                                {{-- <div class="form-group" id="ninDiv">
                                    <label for="" class="form-label">Enter NIN</label>
                                    <input type="text" class="form-control" name="nin" placeholder="Enter your NIN">
                                </div> --}}
                                <div class="form-group mb-2">
                                    <label for="" class="form-label">Select Bank</label>
                                    <select name="bankCode" class="form-select form-control" required >
                                      <option value="" >Select Bank</option>
                                      @foreach ($verifybanks as $item)
                                        <option value="{{$item['code']}}">{{$item['name']}}</option>
                                      @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="" class="form-label">Account Number <span class="text-warning">(Note: The account name must match with name in BVN).</span></label>
                                    <input class="form-control" type="number" name="accountNumber" value="{{old('accountNumber')}}" placeholder="Account Number" required >
                                </div>
                                <div class="form-group" id="bvnDiv">
                                    <label for="" class="form-label">Enter BVN</label>
                                    <input type="text" class="form-control" value="" name="bvn" placeholder="Enter your BVN">
                                </div>
                                <button class="btn btn-primary w-100" type="submit">Verify</button>
                            </form>
                        </div>
                    </div>
                    @endif

                    <div class="d-card dc-orange mt">
                        <div class="d-card-body">
                            <form>
                                <div class="form-group mb-4">
                                    <label for="language" class="control-label">API Key</label>
                                    <input class="form-control" type="text" value="{{Auth::user()->api_token}}" readonly />
                                </div>
                                <a href="{{route('user.apikey')}}" class="btn btn-secondary btn-lg btn-block">Generate New Key</a>
                            </form>
                        </div>
                    </div>
                    <!-- d-card end -->
                    <div class="d-card mt-4">
                        <h5 class="fw-bold card-header">Change Password</h5>
                        <div class="d-card-body" id="dc-body">
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
                    
                    {{-- Delete account --}}
                    <div class="d-card dc-orange mt-3">
                        <h5 class="card-header">Delete Account</h5>
                        <div class="d-card-body">
                            <p>This action cannot be undone. Are you sure you want to proceed?</p>
                            <a href="#" data-toggle="modal" data-target="#accDelModal" class="btn btn-danger btn-block" style="padding: .6rem 0 !important;">Delete Account</a>

                            {{-- modal --}}
                            <div class="modal fade" id="accDelModal">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="d-card mb-3">
                                            <h5 class="modal-header">Delete Account Data</h5>
                                            <div class="modal-body">
                                                <p>All your data, including your account information, orders, transactions, and any other associated records, will be permanently deleted. This action cannot be undone. Are you sure you want to proceed?</p>
                                                <form action="{{route('user.delete-account')}}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="user_id" value="{{Auth::id()}}">
                                                    <div class="modal-footer">
                                                        <button class="btn btn-danger " type="submit">Yes</button>
                                                        <button class="btn btn-dark" type="button" data-dismiss="modal">No</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
       </section>
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
