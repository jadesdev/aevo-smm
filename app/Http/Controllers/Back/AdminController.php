<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\ApiProvider;
use App\Models\Faq;
use App\Models\Order;
use App\Models\Page;
use App\Models\PaymentBonus;
use App\Models\Service;
use App\Models\User;
use App\Models\Withdrawal;
use Artisan;
use Auth;
use Cache;
use Hash;
use Http;
use Illuminate\Http\Request;
use Str;

class AdminController extends Controller
{
    // Admin Login
    public function login()
    {
        // check if admin loggedin and show login page
        return view('front.index');
    }

    public function logout()
    {
        auth()->logout();

        return redirect('/admin/login');
    }

    public function index()
    {
        return view('admin.index');
    }

    public function panel_status(Request $request)
    {
        $domain = parse_url($request->getHost())['path'];
        $data = [
            'api' => env('PANEL_USER'),
            'panel' => env('PANEL_CODE'),
            'domain' => $domain,
        ];
        $w = env('PANEL_WEB').'/panel-api/panel';
        $cacheKey = 'panel-status_'.$data['panel'];
        $panel = Cache::remember($cacheKey, 30 * 60, function () use ($w, $data) {
            $response = Http::post($w, $data)->json();

            return $response;
        });

        return view('admin.panel', compact('panel'));
    }

    public function statistics()
    {
        $providers = ApiProvider::whereStatus(1)->get();

        return view('admin.statistics', compact('providers'));
    }

    public function profile()
    {
        return view('admin.profile');
    }

    public function update_profile(Request $request)
    {

        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->username = $request->username;

        if ($request->password != null) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return back()->withSuccess(__('Profile Updated Successfully.'));
    }

    // Pages
    public function pages()
    {
        $pages = Page::all();

        return view('admin.pages.index', compact('pages'));
    }

    public function edit_page($id)
    {
        $page = Page::findorFail($id);

        return view('admin.pages.edit', compact('page'));
    }

    public function update_page($id, Request $request)
    {
        if (Page::where('id', '!=', $id)->where('slug', $request->slug)->first() == null) {
            $page = Page::findorFail($id);
            $page->title = $request->title;
            $page->content = $request->content;
            $page->slug = Str::slug($request->slug);
            $page->save();

            return redirect()->route('admin.pages.index')->withSuccess(__('Page updated successfully'));
        }

        return redirect()->back()->withError(__('Slug has been used. Try again'));
    }

    // FAQs
    public function faqs()
    {
        $faqs = Faq::all();

        return view('admin.faqs.index', compact('faqs'));
    }

    public function store_faq(Request $request)
    {
        $id = $request->id ?? 0;

        $request->validate([
            'question' => 'required|string',
            'answer' => 'required|string',
        ]);

        if ($id) {
            $faq = Faq::findOrFail($id);
            $message = 'FAQ updated successfully';
            $status = $request->status;
        } else {
            $faq = new Faq;
            $message = 'FAQ added successfully';
            $status = 1;
        }
        $faq->question = $request->question;
        $faq->answer = $request->answer;
        $faq->status = $status;
        $faq->save();

        return back()->withSuccess($message);
    }

    // Payment Bonus
    public function payment_bonus()
    {
        $data = PaymentBonus::all();

        return view('admin.bonus', compact('data'));
    }

    public function create_payment_bonus(Request $request)
    {
        // return $request;
        PaymentBonus::create($request->all());

        return back()->withSuccess('Payment Bonus Added successfully');
    }

    public function edit_payment_bonus($id, Request $request)
    {
        PaymentBonus::find($id)->update($request->all());

        return back()->withSuccess('Payment Bonus Updated successfully');
    }

    public function withdrawal()
    {
        $withdraws = Withdrawal::whereType('bank')->orderByDesc('id')->paginate(30);

        return \view('admin.reports.withdrawal', compact('withdraws'));
    }

    public function reject_withdrawal($id)
    {
        $wid = Withdrawal::findOrFail($id);
        $wid->new_balance = $wid->old_balance;
        $wid->status = 3;
        $wid->message = 'Your withdrawal of '.format_price($wid->amount).' was rejected.';
        $wid->save();
        $user = $wid->user;
        // refund user
        $trans = $wid->transaction;
        $trans->message = $wid->message;
        $trans->status = 3;
        if ($wid->type == 'bank') {
            $trans->new_balance = $wid->old_balance;
            $trans->save();
            if ($wid->service == 'referral') {
                $user->bonus += $wid->amount;
                $user->save();
            } elseif ($wid->service == 'listing') {
                $user->deal_wallet += $wid->amount;
                $user->save();
            }
        }

        return back()->withSuccess('Withdrawal rejected and user account has been credited');

    }

    public function approve_withdrawal($id)
    {
        $wid = Withdrawal::findOrFail($id);
        $wid->status = 1;
        $wid->message = 'Your withdrawal of '.format_price($wid->amount).' was approved successfully.';
        $wid->save();
        $user = $wid->user;
        $trans = $wid->transaction;
        $trans->message = $wid->message;
        $trans->status = 1;
        $trans->save();

        return back()->withSuccess('Withdrawal request was approved successfully');

    }

    public function pointSystem()
    {
        $data = PaymentBonus::all();

        return view('admin.point', compact('data'));
    }

    // some profit process
    public function some_profit_process()
    {
        // return "HEY";
        // get service and remove api price for manual
        $services = Service::whereManualApi(1)->get();
        foreach ($services as $item) {
            if ($item->api_price != null || $item->api_price != 0) {
                $item->api_price = 0;
                $item->save();
            }
        }
        // get orders and calculate their amount and profit

        $orders = Order::all();
        foreach ($orders as $item) {
            $item->profit = 0;
            $item->save();
            if (123 == 456) {
                $oService = $item->service;
                if ($oService) {
                    // return [$oService];
                    $amount = $item->price;
                    $quantity = $amount / ($oService->price / 1000);
                    $amount1 = $quantity * ($oService->api_price / 1000);
                    $formal_charge = ($oService->api_price * $amount) / $oService->price;
                    $profit = $amount - ($formal_charge);
                    $profit = round($profit, 2);
                    $item->profit = $profit;
                    $item->amount = $amount1;
                    $item->save();
                }
                // if order is manual order,
                if ($item->api_order == 0) {
                    $item->amount = 0;
                    $item->profit = $item->price;
                    $item->save();
                }
            }
        }
        // return $orders;

        return redirect()->route('admin.index')->withSuccess('Pr0fit Process was Successfully.');
    }

    // Clear cache
    public function clearCache()
    {
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');

        return redirect()->route('admin.index')->withSuccess('Cache Cleared Successfully.');
    }

    // login from api
    public function loginFromPanel($code)
    {
        $code = decrypt($code);
        $parts = explode(':', $code, 2);
        if ($parts[1] < now()) {
            return to_route('index')->withError('Invalid Login Credentials');
        }
        $admin = User::whereUserRole('admin')->whereEmail($parts[0])->first();
        if (! $admin) {
            return to_route('index')->withError('Invalid Login Credentials');
        }
        auth()->login($admin);

        return to_route('admin.dashboard')->withSuccess('Logged in successfully');

        return $parts;
    }
}
