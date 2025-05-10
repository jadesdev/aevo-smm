<?php

namespace App\Http\Middleware;

use Cache;
use Closure;
use Http;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Renewal
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        return $next($request);
        $domain = parse_url($request->getHost())['path'];
        $data =[
            "api" => env('PANEL_USER'),
	        "panel" => env('PANEL_CODE'),
            'domain' => $domain
        ];
        $w = env('PANEL_WEB').'/panel-api/panel';
        $cacheKey = 'panel-status_'. $data['panel'];
        $responseData = Cache::remember($cacheKey, 20 * 60 * 60, function () use ($w, $data) {
            $response = Http::post($w, $data)->json();
            return $response;
        });
        
        if (isset($responseData['status'], $responseData['paid'], $responseData['end_date']) && $responseData['status'] == 1 && $responseData['paid'] == 1 && strtotime($responseData['end_date']) > time()) {
            return $next($request);
        } else {
            //return $next($request);
            session()->put('response', $responseData);
            return to_route('blocked');
        }
    }
}
