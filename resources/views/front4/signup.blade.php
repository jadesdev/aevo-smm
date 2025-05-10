@extends('front4.layouts.master')

@section('title', "Registration")

@section('content')
{{-- Login Page --}}
<div class="banner__section container  ">
    <div class="row justify-content-center px-5">
        <div class="card col-xxl-6 col-xl-6 col-lg-7 col-md-8 col-sm-12">


            <div class="card-body">

                <div class="pb-2 mt-1 mb-3">
                <h3>Sign Up</h3>
                <small>Please enter your information correctly.</small>
                <small>
                    @include('alerts.alerts')
                </small>
            </div>


                <form method="post" action="">
                    @csrf
                    <div class="form-group mb-2">
                        <label for="" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required placeholder="Username" value="{{ old('username') }}">
                    </div>
                    <div class="form-group mb-2">
                        <label for="" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="fname" name="fname" placeholder="Enter first name" value="{{ old('fname') }}">
                    </div>

                    <div class="form-group mb-2">
                        <label for="" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="lname" name="lname" placeholder="Enter last name" value="{{ old('lname') }}">
                    </div>

                    <div class="form-group mb-2">
                        <label for="" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter valid email address" value="{{ old('email') }}">
                    </div>

                    <div class="form-group mb-2">
                        <label for="" class="form-label">Mobile Number</label>
                        <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter valid phone number" value="{{ old('phone') }}">
                    </div>

                    <div class="form-group mb-2">
                        <label for="" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
                    </div>

                    <div class="form-group mb-2">
                        <label for="" class="form-label">Referral Code</label>
                        <input type="text" class="form-control" id="referral" value="{{ old('referral', $refer) }}" name="referral" placeholder="Referral Code (Optional)">
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12 mb-2 mb-md-0">
                            <button type="submit" class="btn btn-primary btn-lg w-100">Sign Up</button>
                        </div>
                    </div>
                    <div class="w-100 mt-2 text-center">
                        <small>Already have an account? <a href="{{route('login')}}">Log In</a></small>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .form-label{
        font-weight: bold;
    }
</style>
@endsection
