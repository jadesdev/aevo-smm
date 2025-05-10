<?php

namespace App\Http\Controllers;

use App\Models\User;
use Cache;
use Http;
use Illuminate\Http\Request;

class ResellController extends Controller
{
    // admin login page
    public function adminLogin(Request $request)
    {
        if (! $request->panel) {
            return response()->json(['status' => 'error', 'message' => 'The panel code is required'], 401);
        }
        if (! $request->api) {
            return response()->json(['status' => 'error', 'message' => 'The api key field is required'], 401);
        }
        if ($request->api != env('PANEL_USER') || $request->panel != env('PANEL_CODE')) {
            return response()->json(['status' => 'error', 'message' => 'Invalid credentials provided'], 401);
        }
        $admin = User::whereUserRole('admin')->first();
        // send encrypted data back to login
        if ($admin) {
            $token = $admin->email.':'.now()->addMinutes(5);
            $res = [
                'status' => 'success',
                'message' => 'Authentication created successfully',
                // 'token' => encrypt($token),
                'url' => route('admin.panel.login', encrypt($token)),
            ];

            return response()->json($res);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Admin Not found'], 401);
        }
    }

    // panel stats
    public function panelStats(Request $request)
    {
        if (! $request->panel) {
            return response()->json(['status' => 'error', 'message' => 'The panel code is required'], 401);
        }
        if (! $request->api) {
            return response()->json(['status' => 'error', 'message' => 'The api key field is required'], 401);
        }
        if ($request->api != env('PANEL_USER') || $request->panel != env('PANEL_CODE')) {
            return response()->json(['status' => 'error', 'message' => 'Invalid credentials provided'], 401);
        }

        $users = \App\Models\User::count();
        $orders = \App\Models\Order::get(['status', 'amount']);
        $transactions = \App\Models\Transaction::get(['status', 'amount', 'type']);
        $deposits = \App\Models\Deposit::get(['status', 'amount']);
        // return stats
        $res = [
            'status' => 'success',
            'message' => 'Stats fetched successfully',
            'users' => $users,
            'total_orders' => $orders->count(),
            'pending_orders' => $orders->where('status', 'pending')->count(),
            'completed_orders' => $orders->where('status', 'completed')->count(),
            'deposits' => format_price($deposits->where('status', 1)->sum('amount')),
        ];

        return response()->json($res);
    }

    // panel blocked page
    public function panelBlocked(Request $request)
    {
        // forgot cache
        $domain = parse_url($request->getHost())['path'];
        $data = [
            'api' => env('PANEL_USER'),
            'panel' => env('PANEL_CODE'),
            'domain' => $domain,
        ];
        $w = env('PANEL_WEB').'/panel-api/panel';
        // $response = Http::get("aevosmm.com", $data);
        // return $response;
        $cacheKey = 'panel-status_'.$data['panel'];
        Cache::forget($cacheKey);
        $responseData = Cache::remember($cacheKey, 20 * 60 * 60, function () use ($w, $data) {
            $response = Http::post($w, $data)->json();

            return $response;
        });
        if (isset($responseData['status'], $responseData['paid'], $responseData['end_date']) && $responseData['status'] == 1 && $responseData['paid'] == 1 && strtotime($responseData['end_date']) > time()) {
            return to_route('index');
        } else {
            // check sub status and redirect to home poge
            return view('blocked');
        }
    }
}
