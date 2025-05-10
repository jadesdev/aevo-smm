@extends('front2.layouts.master')
@section('title', "Reset Password")

@section('content')
<section class="sign-up-form">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                @include('alerts.alert')
              <h1>Reset My Password</h1>
              <p class="text-white">Enter your correct email address.</p>
              <div class="form-container">
                  <form class="actionFormWithoutToast" action="{{ route('password.update') }}" method="POST" id="signUpForm" data-focus="false">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="form-group">
                      <input type="email" class="form-control-input" name="email" required>
                      <label class="label-control" for="semail">E-mail Address</label>
                    </div>

                    <div class="form-group">
                        <input id="password" type="password" placeholder="Enter New Password" class="form-control-input @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                        <label class="label-control" for="semail">Password</label>
                    </div>
                    <div class="form-group">
                        <input id="password-confirm" type="password" placeholder="Confirm Password" class="form-control-input" name="password_confirmation" required autocomplete="new-password">
                        <label class="label-control" for="semail">Confirm Password</label>
                    </div>

                    <div class="form-group mt-20">
                        <div id="alert-message" class="alert-message-reponse"></div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="form-control-submit-button btn-submit">Reset Password</button>
                    </div>

                  </form>
              </div>
            </div>
        </div>
    </div>
</section>
@endsection
