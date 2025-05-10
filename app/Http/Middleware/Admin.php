<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->user_role == "admin") {
           return $next($request);
        }
        else{
            if(auth()->check() && (Auth::user()->user_role == 'user' || Auth::user()->user_role == 'staff')) {
                return redirect()->route('user.index');
            }
            session(['link' => url()->current()]);
            return redirect()->route('admin.login');
        }
    }
}
