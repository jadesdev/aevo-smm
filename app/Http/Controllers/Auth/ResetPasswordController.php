<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    public function showResetForm(Request $request)
    {
        $token = $request->route()->parameter('token');

        if(sys_setting('homepage_theme') == "theme1") {
            return view('auth.passwords.reset')->with(
                ['token' => $token, 'email' => $request->email]
            );
        }elseif(sys_setting('homepage_theme') == "theme2") {
            return view('front2.auth.reset')->with(
                ['token' => $token, 'email' => $request->email]
            );
        }else{
            return view('auth.passwords.reset')->with(
                ['token' => $token, 'email' => $request->email]
            );
        }

        return view('auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }
}
