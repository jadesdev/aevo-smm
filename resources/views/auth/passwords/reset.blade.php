@extends('front.layouts.master')
@section('title', 'Reset Password')
@section('content')
<div class="container" style="position: relative;">

    <div class="main-top-real-content">
        <div class="row align-items-center">
            <div class="col-lg-6 align-self-center">
                <div class="head-text">
                    <h1>{{get_setting('title')}}</h1>
                    <p>{{get_setting('description')}}.</p>
                </div>
                <div class="head-links row mt-5">
                    <div class="col-auto mb-4 mb-md-0">
                        <a href="{{route('services')}}" class="btn btn-primary btn-lg">Price List</a>
                    </div>
                    <div class="col-auto">
                        <a href="{{route('faq')}}" class="btn btn-outline btn-lg">How It Works?</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-5 offset-lg-1">

                <div class="login-card">
                    <div class="lc-body">
                        <div class="lc-title">
                            <h4>Reset My Password</h4>
                            <small>Please enter your email address.</small>
                            <form method="POST" action="{{ route('password.update') }}">
                                @csrf
                                <input type="hidden" name="token" value="{{ $token }}">

                                <div class="login-form mt-3 py-3">

                                    <div class="fg fg-light mb-4">
                                        <div class="fg-icon"><i class="far fa-envelope"></i></div>
                                        <input type="email" class="fg-control" id="username" name="email" placeholder="Your Email Address">
                                    </div>
                                    <div class="fg fg-light mb-4">
                                        <div class="fg-icon"><i class="fa fa-unlock"></i></div>
                                        <input id="password" type="password" placeholder="Enter New Password" class="fg-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                    </div>
                                    <div class="fg fg-light mb-4">
                                        <div class="fg-icon"><i class="fa fa-lock"></i></div>
                                        <input id="password-confirm" type="password" placeholder="Confirm Password" class="fg-control" name="password_confirmation" required autocomplete="new-password">
                                    </div>

                                    <div class="row mt-4">
                                        <div class="col-md-12 mb-5 mb-md-0">
                                            <button type="submit" class="btn btn-primary btn-lg btn-block">Reset My Password</button>
                                        </div>
                                    </div>

                                </div>

                            </form>
                        </div>
                    </div>
                </div>


            </div>
        </div>

        <div class="col-lg-12 align-self-center">

        </div>

    </div>
</div>

{{--
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Reset Password') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> --}}
@endsection
