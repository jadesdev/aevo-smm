<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;


    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\View\View
     */
    public function showLinkRequestForm()
    {
        if(sys_setting('homepage_theme') == "theme1") {
            return view('auth.passwords.email');
        }elseif(sys_setting('homepage_theme') == "theme2") {
            return view('front2.auth.password');
        }elseif(sys_setting('homepage_theme') == "theme3") {
            return view('front3.auth.password');
        }elseif(sys_setting('homepage_theme') == "theme4") {
            return view('front4.auth.password');
        }else{
            return view('auth.passwords.email');
        }
    }
}
