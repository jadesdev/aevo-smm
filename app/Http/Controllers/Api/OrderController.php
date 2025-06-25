<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ApiProvider;
use App\Models\Category;
use App\Models\Order;
use App\Models\Service;
use App\Models\Transaction;
use Auth;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //
    public function all_categories(Request $request)
    {
        $category = Category::has('services')->whereStatus(1)->orderBy('name')->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Categories fetched successfully',
            'data' => $category,
        ]);
    }

    public function category_services($id)
    {
        $category = Category::findOrFail($id);
        $services = $category->services()->whereStatus(1)->get();
        $category['services'] = $services;

        return response()->json([
            'status' => 'success',
            'message' => 'Categories fetched successfully',
            'data' => $category,
        ]);
    }

    public function services($id = null)
    {
        if ($id) {
            $services = Service::whereId($id)->whereStatus(1)->orderBy('name')->first();
            if ($services == null) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Services not found',
                ], 400);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Service fetched successfully',
                'data' => $services,
            ]);
        }
        $services = Service::whereStatus(1)->orderBy('name')->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Services fetched successfully',
            'data' => $services,
        ]);
    }

    public function get_orders($type = null)
    {
        $orders = Order::whereUserId(auth()->id())->orderByDesc('id')->has('service')->get();
        if ($type) {
            $orders = Order::whereUserId(auth()->id())->whereStatus($type)->has('service')->orderByDesc('id')->get();
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Orders fetched successfully',
            'data' => $orders,
        ]);
    }

    public function get_order($id = null)
    {
        $orders = Order::whereUserId(auth()->id())->has('service')->findOrFail($id);
        $orders['service'] = $orders->service;

        return response()->json([
            'status' => 'success',
            'message' => 'Order fetched successfully',
            'data' => $orders,
        ]);
    }

    public function create_order(Request $request)
    {
        $request->validate([
            'service' => 'required|integer|exists:services,id',
            'link' => 'nullable|url|max:255',
            'comment' => 'nullable|string',
            'quantity' => 'required|integer',
        ]);
        $service = Service::find($request->service);
        if ($service->status != 1) {
            return response()->json([
                'status' => 'error',
                'message' => 'Service is Currently Disabled.',
            ], 400);
        }
        $quantity = $request->quantity;
        if ($service->min > $quantity) {
            return response()->json([
                'status' => 'error',
                'message' => "Order quantity should be minimum {$service->min} ",
            ], 400);

        }
        if ($quantity > $service->max) {
            return response()->json([
                'status' => 'error',
                'message' => "Order quantity should be maximum {$service->max}.",
            ], 400);
        }
        $amount = $quantity * ($service->price / 1000);
        $amount1 = $quantity * ($service->api_price / 1000);
        $formal_charge = ($service->api_price * $amount) / $service->price;
        $profit = $amount - ($amount1);
        $profit = round($profit, 2);
        $user = Auth::user();
        // check is service is special
        $sOrders = $service->orders()->where('user_id', $user->id)->today()->count();
        if ($service->s_type == 'special' && $sOrders >= 1) {
            // return error
            $response['status'] = 'error';
            $response['message'] = 'This is a special service. Yo can only order it once daily. ';

            return response()->json($response, 401);

        }
        if ($user->balance < $amount) {
            $response['status'] = 'error';
            $response['message'] = 'Insufficient Balance Fund Your Wallet And Try Again '.format_price($user->balance);

            return response()->json($response, 400);
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
        $order->category_id = $service->category_id;
        $order->service_id = $request['service'];
        $order->api_service_id = $service->api_service_id ?? 0;
        $order->api_provider_id = $service->api_provider_id ?? 0;
        $order->link = $request['link'] ?? ' ';
        $order->quantity = $quantity;
        $order->comments = $request['comments'] ?? '';
        $order->username = $request['username'] ?? '';
        $order->status = 'pending';
        $order->price = $amount;
        $order->amount = $amount1;
        $order->profit = $profit;
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
            $pmsg = "- You earned 💎{$point}";
        }

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
                // giveUserPoint($user->id , $amount);
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
        $sub = get_setting('title').'- New Order via APP';

        $content = '<p><strong>Hi Admin!</strong></p><p>Someone have already placed order successfully on <strong>'.get_setting('title').'</strong> with following details:</p><ul><li>Email: <strong>'.$user->email.'</strong></li><li>OrderID:  <strong>'.$order->id.'</strong> Â </li><li>Amount:  <strong>'.format_price($trans->amount).'</strong>Â  Â Â </li></ul>';

        $e_mess = "Hi {$user->username}, <br> A debit transaction  of <b>".format_price($trans->amount).'</b> occured on your Account.
            <br> <p> See Below for details of Transactions. </p>
            Amount : '.format_price($trans->amount)."<br> Details: {$trans->message} <br> Reference : {$trans->code} <br> Balance: ".format_price($user->balance).'<br> Date : '.show_datetime($trans->created_at);
        send_emails(get_setting('email'), $sub, $content);
        general_email($user->email, 'Order Placed Successfully', $e_mess);

        return response()->json([
            'status' => 'success',
            'message' => 'Order Placed Successfully.'.$pmsg,
            'data' => [
                'orderId' => $order->id,
                'status' => $order->status,
                'trx' => $trans->code,
            ],
        ], 201);

    }
}
