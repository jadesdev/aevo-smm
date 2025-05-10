<?php

namespace App\Http\Controllers;

use App\Models\ApiProvider;
use App\Models\Category;
use App\Models\Order;
use App\Models\Service;
use App\Models\Transaction;
use Auth;
use Illuminate\Http\Request;
use Validator;

class OrderController extends Controller
{
    protected $theme;

    public function __construct()
    {
        switch (sys_setting('homepage_theme')) {
            case 'theme1':
                $this->theme = 'user.';
                break;
            case 'theme2':
                $this->theme = 'user.';
                break;
            case 'theme3':
                $this->theme = 'user3.';
                break;
            case 'theme4':
                $this->theme = 'user4.';
                break;
            default:
                $this->theme = 'user.';
        }
    }

    //
    public function create()
    {
        $category = Category::whereHas('activeServices')->whereStatus(1)->orderBy('name')->get();

        return view($this->theme.'orders.create', compact('category'));
    }

    public function index(Request $request)
    {
        $title = 'All Orders';
        $search = null;
        $type = 'index';
        $orders = Order::whereUserId(auth()->id())->orderByDesc('id')->paginate(30);
        if ($request->has('search')) {
            $search = $request->search;
            $orders = Order::search($request->search)->whereUserId(auth()->id())->orderByDesc('id')->paginate(30);
        }

        return view($this->theme.'orders.history', compact('title', 'type', 'orders', 'search'));
    }

    public function pending(Request $request)
    {
        $title = 'Pending Orders';
        $search = null;
        $type = 'pending';
        $orders = Order::whereUserId(auth()->id())->whereStatus($type)->orderByDesc('id')->paginate(30);
        if ($request->has('search')) {
            $search = $request->search;
            $orders = Order::search($request->search)->whereStatus($type)->whereUserId(auth()->id())->orderByDesc('id')->paginate(30);
        }

        return view($this->theme.'orders.history', compact('title', 'type', 'orders', 'search'));
    }

    public function processing(Request $request)
    {
        $title = 'Processing Orders';
        $type = 'processing';
        $search = null;
        $orders = Order::whereUserId(auth()->id())->whereStatus($type)->orderByDesc('id')->paginate(30);
        if ($request->has('search')) {
            $search = $request->search;
            $orders = Order::search($request->search)->whereStatus($type)->whereUserId(auth()->id())->orderByDesc('id')->paginate(30);
        }

        return view($this->theme.'orders.history', compact('title', 'type', 'orders', 'search'));
    }

    public function inprogress(Request $request)
    {
        $title = 'In Progress Orders';
        $type = 'inprogress';
        $search = null;
        $orders = Order::whereUserId(auth()->id())->whereStatus($type)->orderByDesc('id')->paginate(30);
        if ($request->has('search')) {
            $search = $request->search;
            $orders = Order::search($request->search)->whereStatus($type)->whereUserId(auth()->id())->orderByDesc('id')->paginate(30);
        }

        return view($this->theme.'orders.history', compact('title', 'type', 'orders', 'search'));
    }

    public function completed(Request $request)
    {
        $title = 'Completed Orders';
        $type = 'completed';
        $search = null;
        $orders = Order::whereUserId(auth()->id())->whereStatus($type)->orderByDesc('id')->paginate(30);
        if ($request->has('search')) {
            $search = $request->search;
            $orders = Order::search($request->search)->whereStatus($type)->whereUserId(auth()->id())->orderByDesc('id')->paginate(30);
        }

        return view($this->theme.'orders.history', compact('title', 'type', 'orders', 'search'));
    }

    public function partial(Request $request)
    {
        $title = 'Partial Orders';
        $type = 'partial';
        $search = null;
        $orders = Order::whereUserId(auth()->id())->whereStatus($type)->orderByDesc('id')->paginate(30);
        if ($request->has('search')) {
            $search = $request->search;
            $orders = Order::search($request->search)->whereStatus($type)->whereUserId(auth()->id())->orderByDesc('id')->paginate(30);
        }

        return view($this->theme.'orders.history', compact('title', 'type', 'orders', 'search'));
    }

    public function canceled(Request $request)
    {
        $title = 'Canceled Orders';
        $type = 'canceled';
        $search = null;
        $orders = Order::whereUserId(auth()->id())->whereStatus($type)->orWhere('status', 'refunded')->orderByDesc('id')->paginate(30);
        if ($request->has('search')) {
            $search = $request->search;
            $orders = Order::search($request->search)->whereStatus($type)->orWhere('status', 'refunded')->whereUserId(auth()->id())->orderByDesc('id')->paginate(30);
        }

        return view($this->theme.'orders.history', compact('title', 'type', 'orders', 'search'));
    }

    // Place Order
    public function place_order(Request $request)
    {
        // return $request;
        $category = Category::find($request->category);
        $service = Service::find($request->service);
        if ($service == null) {
            return back()->withErrors('Please Select a service')->withInput();
        }
        $min = $service->min;
        $max = $service->max;
        $request->validate([
            'category' => 'required|integer|exists:categories,id',
            'service' => 'required|integer',
            'link' => 'nullable|url|max:255',
            'comment' => 'nullable|string',
            'quantity' => 'required|integer',
        ]);
        $quantity = $request->quantity;
        if ($service->dripfeed == 1) {
            if (! isset($request->drip_feed)) {
                $rules['runs'] = 'required|integer|not_in:0';
                $rules['interval'] = 'required|integer|not_in:0';
                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    return back()->withErrors($validator)->withInput();
                }
                $quantity = $request->quantity * $request->runs;
            }
        }
        if ($service->min > $quantity) {
            return back()->with('error', "Order quantity should be minimum {$service->min} ")->withInput();
        }
        if ($quantity > $service->max) {
            return back()->with('error', "Order quantity should be maximum {$service->max}")->withInput();
        }
        // return $quantity;
        $amount1 = $quantity * ($service->api_price / 1000);
        $amount = $quantity * ($service->price / 1000);
        $formal_charge = ($service->api_price * $amount) / $service->price;
        $profit = $amount - ($amount1);
        $profit = round($profit, 2);
        $user = Auth::user();
        if ($user->balance < $amount) {
            $response['status'] = 'error';
            $response['message'] = 'Insufficient Balance Fund Your Wallet And Try Again '.format_price($user->balance);

            return back()->with('error', 'You dont have enough funds in your wallet to complete this transaction '.format_price($user->balance))->withInput();
        }
        // check is service is special
        $sOrders = $service->orders()->where('user_id', $user->id)->today()->count();
        if ($service->s_type == 'special' && $sOrders >= 1) {
            // return error
            return back()->with('error', 'This is a special service. You can only order it once daily')->withInput();

        }
        $user->balance -= $amount;
        $user->save();
        // create transactions ??
        $trans = new Transaction;
        $trans->user_id = $user->id;
        $trans->type = 2; // 1- credit, 2- debit, 3-others
        $trans->code = getTrx();
        $trans->message = 'You place an order of '.format_price($amount)." for {$service->name}";
        $trans->amount = $amount;
        $trans->status = 1;
        $trans->charge = 0;
        $trans->service = 'order';
        $trans->response = '';
        $trans->new_balance = $user->balance;
        $trans->old_balance = $user->balance + $amount;
        $trans->save();

        // Place order
        $order = new Order;
        $order->user_id = $user->id;
        $order->category_id = $request['category'];
        $order->service_id = $request['service'];
        $order->api_service_id = $service->api_service_id ?? 0;
        $order->api_provider_id = $service->api_provider_id ?? 0;
        $order->link = $request['link'] ?? '';
        $order->quantity = $quantity;
        $order->comments = $request['comments'] ?? '';
        $order->username = $request['username'] ?? '';
        $order->status = 'pending';
        $order->profit = $profit;
        $order->amount = $amount1;
        $order->price = $amount;
        $order->remain = $quantity;
        $order->api_order = $service->api_service_id ? 1 : 0;
        $order->drip_feed = isset($request['drip_feed']) ? 0 : 1;
        $order->runs = isset($request['runs']) && ! empty($request['runs']) ? $request['runs'] : null;
        $order->interval = isset($request['interval']) && ! empty($request['interval']) ? $request['interval'] : null;
        $order->api_order_id = 0;
        $order->save();

        $pmsg = '';
        if (sys_setting('point_system') == 1) {
            $pvalue = sys_setting('point_value');
            $point = round($amount / $pvalue, 1);
            $pmsg = "<br> You earned 💎{$point}";
        }
        // return $order;
        if (($service->manual_api == 0)) {
            $apiproviderdata = ApiProvider::find($service->api_provider_id);
            $postData = [
                'key' => $apiproviderdata['api_key'],
                'action' => 'add',
                'service' => $service->api_service_id,
                'link' => $request['link'],
                'quantity' => $request['quantity'],
            ];

            if ($service->dripfeed && ! isset($request->drip_feed)) {
                if (isset($order['runs'])) {
                    $postData['runs'] = $order['runs'];
                }
                if (isset($order['interval'])) {
                    $postData['interval'] = $order['interval'];
                }
            }

            if (isset($request['comments'])) {
                $postData['comments'] = $request['comments'];
            }

            if (isset($request['username'])) {
                $postData['username'] = $request['username'];
            }

            if (isset($request['usernames'])) {
                $postData['usernames'] = $request['usernames'];
            }

            $apidata = send_post_request($apiproviderdata->api_url, $postData);
            if (isset($apidata['order'])) {
                $order->response = $apidata;
                $order->status = 'processing';
                $order->api_order_id = $apidata['order'];

                if (sys_setting('is_affiliate') == 1) {
                    give_affiliate_bonus($user->id, $amount);
                }
                // give user point
                giveUserPoint($user->id, $amount);

            } else {
                // $order->status = 'canceled';
                $order->api_order_id = $apidata['order'] ?? null;
                $order->response = $apidata;
                $order->error = 1;
                $order->error_message = $apidata['error'] ?? '';
            }
        } else {
            // add manual orders to errors page
            $order->error = 1;
            $order->error_message = 'Manual order';
        }
        $order->save();
        // Send email to admin
        $sub = get_setting('title').'- New Order';

        $content = '<p><strong>Hi Admin!</strong></p><p>Someone have already placed order successfully on <strong>'.get_setting('title').'</strong> with following details:</p><ul><li>Email: <strong>'.$user->email.'</strong></li><li>OrderID:  <strong>'.$order->id.'</strong>  </li><li>Amount:  <strong>'.format_price($trans->amount).'</strong>    </li></ul>';

        $e_mess = "Hi {$user->username}, <br> A debit transaction  of <b>".format_price($trans->amount).'</b> occured on your Account.
            <br> <p> See Below for details of Transactions. </p>
            Amount : '.format_price($trans->amount)."<br> Details: {$trans->message} <br> Reference : {$trans->code} <br> Balance: ".format_price($user->balance).'<br> Date : '.show_datetime($trans->created_at);
        send_emails(get_setting('email'), $sub, $content);
        general_email($user->email, 'Order Placed Successfully', $e_mess);

        return redirect()->route('user.orders.create')->withSuccess('Order Placed Successfully'.$pmsg);
    }

    // get services
    public function get_services(Request $request)
    {
        $data = Service::where('category_id', $request->category)->whereStatus(1)->get();
        $option_plan = '';
        if ($data->count() > 0) {
            foreach ($data as $fetch_data) {
                $name = $fetch_data['name'].' - '.format_amount($fetch_data['price']).' for 1000';
                $desc = $fetch_data['description'] ? $fetch_data['description'] : '1. Please make sure your page is not Private.

                2. Kindly refrain from placing a second order on the same link until your initial order is completed.

                3. Please be note that there may be speed changes in service delivery during periods of high demand.';
                $option_plan .= '<option value="'.$fetch_data['id'].'" data-show="'.'show'.'" data-price="'.convert_price($fetch_data['price']).'" data-min="'.$fetch_data['min'].'" data-dripfeed="'.$fetch_data['dripfeed'].'" data-max="'.$fetch_data['max'].'" data-desc="'.$desc.'" '.(old('service') == $fetch_data['id'] ? 'selected' : '').'>'.$name.'</option>';
            }
        }

        return '<option value="default" data-price="0" id="0" selected> Select a Service </option>'.$option_plan;
    }

    public function show_service_form(Request $request)
    {
        $service = Service::find($request->service);
        if ($service) {
            $html = view('user.orders.form', compact('service'))->render();

            return response()->json(['html' => $html]);
        } else {
            $html = '
            <div class="form-group">
                <label class="text-danger">Please Select a service </label>
            </div>';

            return response()->json(['html' => $html]);
        }

    }
}
