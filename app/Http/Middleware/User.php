<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class User
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->status != 1) {

            $redirect_to = '';
            if (auth()->user()->user_role == 'admin' || auth()->user()->user_role == 'staff') {
                $redirect_to = 'admin.login';
            } else {
                $redirect_to = 'login';
            }

            auth()->logout();

            $message = 'Your account has been deleted or suspended. Please contact Admin';

            // Create custom message later
            return redirect()->route($redirect_to)->withEmodal($message)->withErrors($message);

        }
        if (Auth::check()) {
            if (auth()->user()->user_role == 'admin' || Auth::user()->user_role == 'user') {
                return $next($request);

            } elseif (auth()->user()->user_role == 'staff') {
                return redirect()->route('admin.index');
            } else {
                return redirect()->route('index');
            }
        } else {
            session(['link' => url()->current()]);

            return redirect()->route('login')->withError('Login to continue');

            return redirect()->route('index');
        }
    }
}
