@extends('front2.layouts.master')
@section('title', "Reset Password")

@section('content')
<section class="sign-up-form">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
                @endif
              <h2>Forgot Password</h2>
              <p class="text-white">Enter your correct email address to receive password reset instructions.</p>
              <div class="form-container">
                  <form class="actionFormWithoutToast" action="{{ route('password.email') }}" method="POST" id="signUpForm" data-focus="false">
                    @csrf
                    <div class="form-group">
                      <input type="email" class="form-control-input" placeholder="Email Address" name="email" required>
                      
                    </div>

                    <div class="form-group mt-20">
                        <div id="alert-message" class="alert-message-reponse"></div>
                    </div>



                    <div class="form-group">
                        <button type="submit" class="btn-solid-lg page-scroll btn-submit">Submit</button>
                    </div>

                  </form>
              </div>
            </div>
        </div>
    </div>
</section>
@endsection
