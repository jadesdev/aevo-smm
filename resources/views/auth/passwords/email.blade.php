@extends('front.layouts.master')

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
                        @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                        @endif
                        <div class="lc-title">
                            <h4>Reset My Password</h4>
                            <small>Please enter your email address.</small>
                            <form method="POST" action="{{ route('password.email') }}">
                                @csrf
                                <div class="login-form mt-3 py-3">

                                    <div class="fg fg-light mb-4">
                                        <div class="fg-icon"><i class="far fa-envelope"></i></div>
                                        <input type="email" class="fg-control" id="username" name="email" required placeholder="Your Email Address">
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-md-12 mb-5 mb-md-0">
                                            <button type="submit" class="btn btn-primary btn-lg btn-block">Reset Password</button>
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

@endsection
