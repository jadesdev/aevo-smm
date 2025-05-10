@extends('front4.layouts.master')

@section('title', 'Login')

@section('content')
    {{-- Login Page --}}
<section class="accordion__section pt-130 px-5" id="faq">
    <div class="container">
        <div class="row justify-content-center">
            <div class="card col-md-6">

                <div class="card-body">

                    <div class="pb-2 mt-1 mb-3">
                        <h3>Sign In</h3>
                        <small>Welcome back to {{ get_setting('title') }}.</small>
                        <small>
                            @include('alerts.alerts')
                        </small>
                    </div>


                    <form method="post" action="{{ route('signin') }}">
                        @csrf

                        <div class="form-group mb-2">
                            <label for="" class="form-label">Email or Username</label>
                            <input type="text" class="form-control" id="username" name="username"
                                placeholder="Email or Username" required value="{{ old('username') }}">
                        </div>
                        <div class="form-group mb-2">
                            <label for="" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Password" required>
                        </div>

                        <div class="row mt-2">
                            <div class="col-6">
                                <div class="fcheck ms-1 ">
                                    <input type="checkbox" name="remember" value="1" id="remember">
                                    <label for="remember">Remember Me</label>
                                </div>
                            </div>
                            <div class="col-6 text-end">
                                <a href="{{ route('password.request') }}" class="frgpass">Forgot Password?</a>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-12 mb-2 mb-md-0">
                                <button type="submit" class="btn btn-primary btn-lg w-100 btn-block">Sign In</button>
                            </div>
                        </div>
                        <div class="w-100 mt-3 text-center">
                            <small>Don't have an account? <a href="{{ route('signup') }}">Sign Up</a></small>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('styles')
    <style>
        .form-label {
            font-weight: bold;
        }
    </style>
@endsection
