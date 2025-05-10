@extends('front2.layouts.master')
@section('title', "Verify Account")

@section('content1')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Verify Your Email Address') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('content')
<section class="sign-up-form">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                @if (session('resent'))
                <div class="alert alert-success" role="alert">
                    {{ __('A fresh verification link has been sent to your email address.') }}
                </div>
                @endif
              <h2>{{ __('Verify Your Email Address') }} </h2>
              <p class="text-white">Verify your email before you access our website.</p>
              <div class="form-container">
                  {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }},
                    <form class="actionFormWithoutToast " method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        
                        <div class="form-group">
                            <button type="submit" class="btn-solid-lg page-scroll btn-submit">Resend Verificaion Link</button>
                        </div>
                    </form>
              </div>
            </div>
        </div>
    </div>
</section>
@endsection
