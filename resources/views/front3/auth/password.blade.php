@extends('front3.layouts.master')
@section('title', "Reset Password")

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="card col-md-6">
            
            <div class="card-body">
                
                <div class="pb-2">
                <h5>Forgot Password?</h5>
                <small>Enter your correct email address to receive password reset instructions.</small>
                <small>
                    @include('alerts.alerts')
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                </small>
            </div>
                
                <form method="post" action="{{ route('password.email') }}">
                    @csrf

                    <div class="form-group mb-2">
                        <label for="" class="form-label">Email Address</label>
                      <input type="email" class="form-control" name="email" required>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12 mb-5 mb-md-0">
                            <button type="submit" class="btn btn-primary btn-lg w-100 btn-block">Reset Pasword</button>
                        </div>
                    </div>
                    <div class="w-100 mt-3 text-center">
                        Already have an account? <a href="{{route('login')}}">Sign In</a>
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

