<?php

namespace App\Http\Controllers;

use App\Models\ApiProvider;
use App\Models\Order;
use App\Models\Service;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;

class ApiController extends Controller
{
    public function process(Request $request)
    {
        if (! $request->action) {
            return response()->json(['error' => 'The action field is required']);
        }

        if (! $request->key) {
            return response()->json(['error' => 'The api key field is required']);
        }
        // check request action
        $actionExists = ['services', 'add', 'status', 'refill', 'refill_status', 'balance'];

        if (! in_array($request->action, $actionExists)) {
            return response()->json(['error' => 'Invalid action']);
        }
        // Check if user  api keyis valid
        if (! User::where('api_token', $request->key)->exists()) {
            return response()->json(['error' => 'Invalid api key']);
        }
        // Checking the request action is services
        $action = $request->action;

        return $this->$action($request);
    }

    // Get User Balance
    private function balance($request)
    {
        // Validation
        $balance = User::where('api_token', $request->key)->select(['balance'])->first();

        if (! $balance) {
            return response()->json(['error' => 'Invalid api key']);
        }

        $result = [
            'status' => 'success',
            'balance' => ($balance->balance),
            'currency' => get_setting('currency_code'),
        ];

        return response()->json($result);
    }

    // List of services
    public function services()
    {
        $services = Service::whereStatus(1)->with('category')->get();
        $modifyService = [];

        foreach ($services as $service) {
            $modifyService[] = [
                'service' => $service->id,
                'name' => $service->name,
                'category' => $service->category->name ?? null,
                'rate' => $service->price,
                'min' => $service->min,
                'max' => $service->max,
                'type' => $service->type,
                'desc' => $service->description,
                'dripfeed' => $service->dripfeed,
            ];
        }

        return response()->json($modifyService, 200);
    }

    // Order status
    public function status($request)
    {

        if ($request->order) {
            $user = User::where('api_token', $request->key)->first();

            $order = Order::where('id', $request['order'])->where('user_id', $user->id)->first();
            if (! $order) {
                return response()->json(['error' => 'The selected order id is invalid.'], 422);
            }

            $result['status'] = strtoupper($order->status);
            $result['charge'] = $order->service['price'];
            $result['start_count'] = (int) $order->start_count;
            $result['remains'] = (int) $order->remain;
            $result['currency'] = get_setting('currency_code');

            return response()->json($result, 200);
        } elseif ($request->orders) {
            // multi orders
            return $this->orders($request);
        } else {
            return response()->json(['error' => 'The order field is required']);
        }
    }

    // \List Orders
    public function orders($request)
    {
        $orders = explode(',', $request['orders']);
        $user = User::where('api_token', $request->key)->first();
        $result = Order::whereIn('id', $orders)->where('user_id', $user->id)->get()->map(function ($order) {
            return [
                'order' => $order->id,
                'status' => strtoupper($order->status),
                'charge' => $order->service['price'],
                'start_count' => (int) $order->start_count,
                'remains' => (int) $order->remain,
                'currency' => get_setting('currency_code'),
            ];
        });

        return response()->json($result, 200);
    }

    // Place order
    public function add($request)
    {
        $validator = Validator::make($request->all(), [
            'service' => 'required',
            'link' => 'required',
            'quantity' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()->first()], 422);
        }
        // Get user
        $user = User::where('api_token', $request->key)->first();
        // get service
        $service = Service::where('id', $request['service'])->where('status', 1)->first();
        if (! $service) {
            return response()->json(['error' => 'The selected service is invalid.'], 422);
        }
        $quantity = $request['quantity'];
        if ($service->dripfeed == 1) {
            $rules['runs'] = 'required|integer|not_in:0';
            $rules['interval'] = 'required|integer|not_in:0';
            $validator = Validator::make($request, $rules);
            if ($validator->fails()) {
                return response()->json(['error' => $validator->messages()->first()], 422);
            }
            $quantity = $request['quantity'] * $request['runs'];
        }

        if ($service->min <= $quantity && $service->max >= $quantity) {
            $price = round(($quantity * $service->price) / 1000, 2);
            if ($user->balance < $price) {
                return response()->json(['error' => "You don't have sufficient balance."], 400);
            }
            $amount1 = round(($quantity * $service->price) / 1000, 2);
            $formal_charge = ($service->api_price * $price) / $service->price;
            $profit = $price - ($amount1);
            $profit = round($profit, 2);
            // deduct balance
            $user->balance -= $price;
            $user->save();
            // create transactions ??
            $trans = new Transaction;
            $trans->user_id = $user->id;
            $trans->type = 2; // 1- credit, 2- debit, 3-others
            $trans->code = getTrx();
            $trans->message = 'You place an order of '.format_price($price)." for {$service->name}";
            $trans->amount = $price;
            $trans->status = 1;
            $trans->charge = 0;
            $trans->service = 'order';
            $trans->response = '';
            $trans->new_balance = $user->balance;
            $trans->old_balance = $user->balance + $price;
            $trans->save();
            // place order
            $order = new Order;
            $order->user_id = $user->id;
            $order->category_id = $service->category_id;
            $order->service_id = $request['service'];
            $order->api_service_id = $service->api_service_id ?? 0;
            $order->api_provider_id = $service->api_provider_id ?? 0;
            $order->link = $request['link'];
            $order->quantity = $request['quantity'];
            $order->comments = $request['comments'] ?? '';
            $order->username = $request['username'] ?? '';
            $order->status = 'pending';
            $order->price = $price;
            $order->profit = $profit;
            $order->amount = $amount1;
            $order->remain = $request->quantity;
            $order->api_order = $service->api_service_id ? 1 : 0;
            $order->runs = isset($request['runs']) && ! empty($request['runs']) ? $request['runs'] : null;
            $order->interval = isset($reqquest['interval']) && ! empty($request['interval']) ? $request['interval'] : null;

            $order->api_order_id = 0;
            $order->save();

            if (($service->manual_api == 0)) {
                $apiproviderdata = ApiProvider::find($service->api_provider_id);
                $postData = [
                    'key' => $apiproviderdata['api_key'],
                    'action' => 'add',
                    'service' => $service->api_service_id,
                    'link' => $request['link'],
                    'quantity' => $request['quantity'],
                ];

                if (isset($request['runs'])) {
                    $postData['runs'] = $request['runs'];
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

                if (isset($request['interval'])) {
                    $postData['interval'] = $request['interval'];
                }

                $apidata = send_post_request($apiproviderdata->api_url, $postData);
                if (isset($apidata['order'])) {
                    $order->response = $apidata;
                    $order->api_order_id = $apidata['order'];
                } else {
                    // $order->status = 'canceled';
                    $order->api_order_id = $apidata['order'] ?? null;
                    $order->response = $apidata;
                    $order->error = 1;
                    $order->error_message = $apidata['error'] ?? '';
                    $order->save();
                    $result['status'] = 'error';
                    $result['error'] = $order->error_message;

                    return response()->json($result, 400);
                }
            }
            $order->save();
            // Send email to admin

            $result['status'] = 'success';
            $result['order'] = $order->id;

            return response()->json($result, 200);

        } else {
            return response()->json(['error' => "Order quantity should be minimum {$service->min} and maximum {$service->max}."], 400);
        }
    }

    // refill
    public function refill($request)
    {
        $user = User::where('api_token', $request->key)->first();
        $order = Order::with('service', 'service.provider')->where('id', $request['order'])->where('user_id', $user->id)->first();
        if (! $order) {
            return response()->json(['error' => 'The selected order id is invalid.'], 422);
        }
        if ($order->status == 'completed' && $order->remains > 0 && optional($order->service)->refill != 3 && $order->refilled_at->lt(Carbon::now()->subHours(24)) && (! isset($order->refill_status) || $order->refill_status == 'completed' || $order->refill_status == 'partial' || $order->refill_status == 'canceled' || $order->refill_status == 'refunded')) {
            if (optional($order->service)->refill == 2) {
                if (optional(optional($order->service)->provider)->status != 1) {
                    return response()->json(['error' => 'You are not eligible to send refill request.'], 400);
                }
                $refillResponse = send_post_request(optional($order->service)->provider->api_url, ['key' => optional(optional($order->service)->provider)->api_key, 'action' => 'refill', 'order' => $order->api_order_id]);
                if (isset($refillResponse['refill'])) {
                    $order->api_refill_id = $refillResponse['refill'];
                    $order->refill_status = 'awaiting';
                    $order->refilled_at = now();
                    $order->save();
                } else {
                    return response()->json(['error' => 'You are not eligible to send refill request.'], 400);
                }
            } else {
                $order->refill_status = 'awaiting';
                $order->refilled_at = now();
                $order->save();
            }
        } else {
            return response()->json(['error' => 'You are not eligible to send refill request.'], 400);
        }

        return response()->json(['status' => 'success', 'refill' => $order->id], 200);

        return $order;
    }

    public function refill_status($request)
    {
        $validator = Validator::make($request, [
            'order' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()->first()], 422);
        }
        $user = User::where('api_token', $request->key)->first();

        $order = Order::where('id', $request['order'])->where('user_id', $user->id)->whereNotNull('refill_status')->first();
        if (! $order) {
            return response()->json(['error' => 'The selected refill id is invalid.'], 422);
        }

        $result['status'] = strtoupper($order->refill_status);
    }
}
