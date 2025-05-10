@extends('front4.layouts.master')
@section('title', "Reset Password")

@section('content')

<div class="container">
    <div class="row justify-content-center px-5">
        <div class="card col-md-6">

            <div class="card-body">

                 <div class="pb-2">
                <h3>Reset Password</h3>
                <small>Create a secured password for your account.</small>
                <small>
                    @include('alerts.alerts')
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                </small>
            </div>


                <form method="post" action="{{ route('password.update') }}" >
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="form-group mb-2">
                        <label for="" class="form-label">Email Address</label>
                      <input type="email" class="form-control" placeholder="Email Address" name="email" required>
                    </div>

                    <div class="form-group mb-2">
                        <label class="form-control" for="semail">Password</label>
                        <input id="password" type="password" placeholder="Enter New Password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                    </div>
                    <div class="form-group mb-2">
                        <label class="form-control" for="semail">Confirm Password</label>
                        <input id="password-confirm" type="password" placeholder="Confirm Password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12 mb-5 mb-md-0">
                            <button type="submit" class="btn btn-primary btn-lg w-100 btn-block">Reset Pasword</button>
                        </div>
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

