<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\Setting;
use Artisan;
use Cache;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    //
    public function index()
    {
        $currencies = Currency::orderByDesc('default')->get();

        return view('admin.currency', compact('currencies'));
    }

    public function store(Request $request)
    {
        $currency = new Currency;
        $currency->name = $request->name;
        $currency->symbol = $request->symbol;
        $currency->code = $request->code;
        $currency->rate = $request->rate;
        $currency->status = 1;
        $currency->save();

        Cache::forget('active_currencies');

        return back()->withSuccess(__('Currency Created Successfully'));
    }

    public function update(Request $request)
    {
        $currency = Currency::findOrFail($request->id);
        $currency->name = $request->name;
        $currency->symbol = $request->symbol;
        $currency->code = $request->code;
        $currency->rate = $request->rate;
        $currency->save();
        Cache::forget('active_currencies');

        return back()->withSuccess(__('Currency Updated Successfully'));
    }

    public function updateStatus(Request $request)
    {
        $currency = Currency::findOrFail($request->id);
        if ($request->status == 0) {
            if (get_setting('currency_code') == $currency->code) {
                // dont disable default currency
                return 0;
            }
        }
        $currency->status = $request->status;
        $currency->save();
        Cache::forget('active_currencies');

        return ['status' => true];
    }

    public function updateDefault(Request $request)
    {
        $currency = Currency::findOrFail($request['default_currency']);
        $currency->update(['status' => 1]);
        Setting::first()->update([
            'currency' => $currency->symbol,
            'currency_code' => $currency->code,
        ]);

        Artisan::call('cache:clear');
        Cache::forget('active_currencies');
        $request->session()->put('currency_code', $currency->code);
        $request->session()->put('currency_symbol', $currency->symbol);
        $request->session()->put('currency_rate', $currency->rate);

        return back()->withSuccess(__('Defult Currency Set'));
    }

    public function currency_change(Request $request)
    {
        $currency = Currency::where('code', $request->currency_code)->first();
        $request->session()->put('currency', $request->currency_code);

        $msg = __('Currency changed to ').$currency->name;
        Cache::forget('active_currencies');
        session()->flash('success', $msg);
    }
}
