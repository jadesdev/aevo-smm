<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Setting;
use App\Models\Transaction;
use Illuminate\Http\Request;

class CronController extends Controller
{
    //
    public function initCronjob(Request $request)
    {
        $this->provider_service_update($request);
        $this->order_refill_status($request);
        $this->send_scheduled_email($request);
        $logFile = 'cronjob_log.txt';
        $data = [
            'date' => now(),
            'message' => 'Cron job was successful.',
        ];
        // $logMessage = json_encode($data, JSON_PRETTY_PRINT);
        // file_put_contents($logFile, $logMessage, FILE_APPEND);
        // update last cron job
        $general = Setting::first();
        $general->last_cron = now();
        $general->save();

        return 'success';
    }

    public function provider_service_update(Request $request)
    {
        $orders = Order::with(['service', 'service.provider', 'user'])->whereNotIn('status', ['completed', 'refunded', 'canceled', 'partial'])->whereApiOrder(1)->whereHas('service', function ($query) {
            $query->whereNotNull('api_provider_id')->orWhere('api_provider_id', '!=', 0);
        })->get();

        // return $orders;
        foreach ($orders as $order) {

            $service = $order->service;
            if (isset($service->api_provider_id)) {
                $apiproviderdata = $service->provider;
                $apiservicedata = send_post_request($apiproviderdata['api_url'], ['key' => $apiproviderdata['api_key'], 'action' => 'status', 'order' => $order->api_order_id]);
                $apidata = ($apiservicedata);
                if (isset($apidata['status'])) {
                    $value = (isset($apidata['remains']) && $apidata['remains'] !== '') ? $apidata['remains'] : 0;
                    $order->status = (strtolower($apidata['status']) == 'in progress') ? 'inprogress' : strtolower($apidata['status']);
                    $order->start_counter = empty($apidata['start_count']) ? 0 : $apidata['start_count'];
                    $order->remain = $value;
                    $order->response = $apidata;
                }

                if (isset($apidata['error'])) {
                    $order->response = $apidata;
                }
                $order->save();

                if ($order->status == 'refunded' && $order->remain != 0) {
                    // refund user
                    $perOrder = $order->price / $order->quantity;
                    $getBackAmo = $order->remain * $perOrder;

                    $user = $order->user;
                    $user->balance += $getBackAmo;
                    $user->save();

                    $trans = new Transaction;
                    $trans->user_id = $user->id;
                    $trans->type = 1; // 1- credit, 2- debit, 3-others
                    $trans->code = getTrx();
                    $trans->message = 'Refunded order on #'.$order->id;
                    $trans->amount = $getBackAmo;
                    $trans->status = 1;
                    $trans->charge = 0;
                    $trans->service = 'order';
                    $trans->response = '';
                    $trans->new_balance = $user->balance;
                    $trans->old_balance = $user->balance - $getBackAmo;
                    $trans->save();
                }
                // partial orders
                if ($order->status == 'partial' && $order->remain != 0) {
                    // refund user
                    $perOrder = $order->price / $order->quantity;
                    $getBackAmo = $order->remain * $perOrder;

                    $user = $order->user;
                    $user->balance += $getBackAmo;
                    $user->save();

                    $trans = new Transaction;
                    $trans->user_id = $user->id;
                    $trans->type = 1; // 1- credit, 2- debit, 3-others
                    $trans->code = getTrx();
                    $trans->message = 'Refunded order on #'.$order->id;
                    $trans->amount = $getBackAmo;
                    $trans->status = 1;
                    $trans->charge = 0;
                    $trans->service = 'order';
                    $trans->response = '';
                    $trans->new_balance = $user->balance;
                    $trans->old_balance = $user->balance - $getBackAmo;
                    $trans->save();
                }

                if ($order->status == 'canceled') {
                    $getBackAmo = $order->price;

                    $user = $order->user;
                    $user->balance += $getBackAmo;
                    $user->save();

                    $trans = new Transaction;
                    $trans->user_id = $user->id;
                    $trans->type = 1; // 1- credit, 2- debit, 3-others
                    $trans->code = getTrx();
                    $trans->message = 'Refunded order on #'.$order->id;
                    $trans->amount = $getBackAmo;
                    $trans->status = 1;
                    $trans->charge = 0;
                    $trans->service = 'order';
                    $trans->response = '';
                    $trans->new_balance = $user->balance;
                    $trans->old_balance = $user->balance - $getBackAmo;
                    $trans->save();
                }
                // send email if order is completed
                if ($order->status == 'completed') {
                    $user = $order->user;

                    // give user point
                    giveUserPoint($user->id, $order->price);

                    $sub = 'Order Completed';
                    $mesg = "Hi {$user->username}, <br>  <p>Your Order with ID {$order->id} is completed. Would You like to make a new order?</p> <br>
                    <a href='".route('user.orders.create')."' style='display: inline-block; background-color: #fa6e39; border: none; color: white; padding: 10px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; margin: 4px 2px; cursor: pointer; border-radius: 10px;'>New Order</a>";
                    general_email($user->email, $sub, $mesg);

                    // send notification
                    sendUserNotification(
                        $user,
                        'Order Completed',
                        "Your Order: #{$order->id} is completed. "
                    );
                }
            }
        }
    }

    public function order_refill_status()
    {

        $orders = Order::with(['service', 'service.provider'])->whereNotIn('status', ['completed', 'refunded', 'canceled'])->whereNotIn('refill_status', ['completed', 'refunded', 'canceled'])->whereNotNull('refilled_at')->whereNotNull('api_refill_id')->whereHas('service', function ($query) {
            $query->whereNotNull('api_provider_id')->orWhere('api_provider_id', '!=', 0);
        })->get();

        foreach ($orders as $order) {
            $service = $order->service;
            if (isset($service->api_provider_id)) {
                $apiproviderdata = $service->provider;
                $apidata = send_post_request($apiproviderdata['api_url'], ['key' => $apiproviderdata['api_key'], 'action' => 'refill_status', 'refill' => $order->api_refill_id]);
                if (isset($apidata['status'])) {
                    $order->status = strtolower($apidata['status']);
                    $order->save();
                }
            }
        }
    }

    // Send Scheduled Email
    public function send_scheduled_email(Request $request)
    {

        $qes = new EmailController;
        $qes->queue_emails();
    }
}
