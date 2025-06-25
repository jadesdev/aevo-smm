<?php

namespace App\Http\Middleware;

use App\Models\Currency;
use Closure;
use Illuminate\Http\Request;
use Session;
use Symfony\Component\HttpFoundation\Response;

class CurrencyCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $currency = Currency::where('code', get_setting('currency_code'))->first();
        if (! $currency) {
            $currency = Currency::first();
        }
        if (Session::has('currency')) {
            $code = Session::get('currency');
        } else {
            $code = $currency->code;
        }
        $request->session()->put('currency', $code);

        return $next($request);
    }
}
