<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\{
    Setting,
    SystemSetting
};
use Illuminate\Http\Request;

class SettingController extends Controller
{
    function settings(Request $request){
        $sett = Setting::first();
        $bills =[
            'status' => sys_setting('bills_payment'),
            'airtime' => sys_setting('is_airtime'),
            'data' => sys_setting('is_data'),
            'power' => sys_setting('is_power'),
            'cable' => sys_setting('is_cable'),
        ];
        $payment =[
            'monnify' => sys_setting('monnify_payment'),
            'paypal' => sys_setting('paypal_payment'),
            'perfect_money' => sys_setting('perfect_payment'),
            'paystack' => sys_setting('paystack_payment'),
            'flutterwave' => sys_setting('flutterwave_payment'),
            'coinbase' => sys_setting('coinbase_payment'),
            'binance' => sys_setting('binance_payment'),
            'currency' => $sett->currency,
            'currency_code' => $sett->currency_code,
            'currency_rate' => $sett->currency_rate,
        ];
        $data = [
            'title' => $sett->title,
            'about' => $sett->description,
            'email' => $sett->email,
            'name' => $sett->name,
            'phone' => $sett->phone,
            'currency' => $sett->currency,
            'currency_code' => $sett->currency_code,
            'currency_rate' => $sett->currency_rate,
            'is_welcome_message' => sys_setting('is_welcome_message'),
            'welcome_message' => sys_setting('welcome_message'),
            'bills' => $bills,
            'payment' => $payment
        ];
        return response()->json([
            'status' => "success",
            'message' => 'Site Settings fetched successfully',
            'data' => $data
        ]);
    }
}
