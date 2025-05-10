@extends('front2.layouts.master')

@section('title', "Registration")

@section('content')

<section class="sign-up-form">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="form-container">
                    <h2>Sign Up</h2>

                    <form class="actionFormWithoutToast" action="{{route('signup')}}" data-redirect="{{route('user.dashboard')}}" method="POST" id="signUpForm" data-focus="false">
                        @csrf
                        <div class="form-group">
                            <input type="email" class="form-control-input" name="email" placeholder="Enter a valid Email Address" required />

                           
                            <div class="help-block with-errors"></div>
                        </div>
<div class="row">
                        <div class="form-group col-6">
                            <input type="text" class="form-control-input" name="fname" placeholder="First Name" required />
                            
                            <div class="help-block with-errors"></div>
                        </div>

                        <div class="form-group col-6">
                            <input type="text" class="form-control-input" name="lname" placeholder="Last Name" required />
                           
                            <div class="help-block with-errors"></div>
                        </div>
                        
                        </div>
                        
                        
                        
                        <div class="form-group">
                            <input type="text" class="form-control-input" name="username" placeholder="Username" required />
                            
                            <div class="help-block with-errors"></div>
                        </div>

                        <div class="form-group">
                            <input type="text" class="form-control-input" name="phone" placeholder="Enter a valid Phone Number" required />
                           
                        </div>

                        <div class="form-group">
                            <input type="password" class="form-control-input" name="password" placeholder="Password" required />
                            
                            <div class="help-block with-errors"></div>
                        </div>

                        <div class="form-group">
                            <input type="password" class="form-control-input" name="re_password" placeholder="Confirm Password" required />
                           
                            <div class="help-block with-errors"></div>
                        </div>

                        <div class="form-group">
                            <input type="text" class="form-control-input" id="referral" value="{{ old('referral', $refer) }}" name="referral" placeholder="Referral Code (Optional)" />
                        </div>

                        <div class="form-group mt-20">
                            <div id="alert-message" style="30px" class="alert-message-reponse"></div>
                        </div>

                        <div class="form-group">
                           
                                
                               <small class=""> By clicking the “Sign Up” button, you agree to Instaking's <a href="{{route('terms')}}">Terms & Policy</a></small>
                        </div>

                        <div class="form-group">
                            <button class="btn-solid-lg page-scroll btn-submit" style="margin: 0; width: 100%;" type="submit">Sign Up</button>
                        </div>
                    </form>
                    <p class="text-center text-muted">Do you have an account? <a style="font-weight: 900; margin-left: 5px;" href="{{route('index')}}">Sign In</a></p>
                </div>
            </div>
        </div>
    </div>
</section>


@endsection
