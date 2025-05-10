<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //
    public function index(Request $request)
    {
        $title = "All Orders";
        $type = 'index';
        $search = "";
        $orders = Order::orderByDesc('id')->paginate(50);
        if($request->has('search')){
            $search = $request->search;
            $orders = Order::search($request->search)->orderByDesc('id')->paginate(50);
        }
        return view('admin.orders.index', compact('title','type','orders','search'));
    }

    public function pending(Request $request)
    {
        $title = "Pending Orders";
        $type = 'pending';
        $search = "";
        $orders = Order::whereStatus($type)->orderByDesc('id')->paginate(50);
        if($request->has('search')){
            $search = $request->search;
            $orders = Order::search($request->search)->whereStatus($type)->orderByDesc('id')->paginate(50);
        }
        return view('admin.orders.index', compact('title','type','orders','search'));
    }

    public function processing(Request $request)
    {
        $title = "Processing Orders";
        $type = 'processing';
        $search = "";
        $orders = Order::whereStatus($type)->orderByDesc('id')->paginate(50);
        if($request->has('search')){
            $search = $request->search;
            $orders = Order::search($request->search)->whereStatus($type)->orderByDesc('id')->paginate(50);
        }
        return view('admin.orders.index', compact('title','type','orders','search'));
    }

    public function inprogress(Request $request)
    {
        $title = "In Progress Orders";
        $type = 'inprogress';
        $search = "";
        $orders = Order::whereStatus($type)->orderByDesc('id')->paginate(50);
        if($request->has('search')){
            $search = $request->search;
            $orders = Order::search($request->search)->whereStatus($type)->orderByDesc('id')->paginate(50);
        }
        return view('admin.orders.index', compact('title','type','orders','search'));
    }

    public function completed(Request $request)
    {
        $title = "Completed Orders";
        $type = 'completed';
        $search = "";
        $orders = Order::whereStatus($type)->orderByDesc('id')->paginate(50);
        if($request->has('search')){
            $search = $request->search;
            $orders = Order::search($request->search)->whereStatus($type)->orderByDesc('id')->paginate(50);
        }
        return view('admin.orders.index', compact('title','type','orders','search'));
    }

    public function partial(Request $request)
    {
        $title = "Partial Orders";
        $type = 'partial';
        $search = "";
        $orders = Order::whereStatus($type)->orderByDesc('id')->paginate(50);
        if($request->has('search')){
            $search = $request->search;
            $orders = Order::search($request->search)->whereStatus($type)->orderByDesc('id')->paginate(50);
        }
        return view('admin.orders.index', compact('title','type','orders','search'));
    }

    public function canceled(Request $request)
    {
        $title = "Canceled and Refunded Orders";
        $type = 'canceled';
        $search = "";
        $orders = Order::whereStatus($type)->orWhere('status','refunded')->orderByDesc('id')->paginate(50);
        if($request->has('search')){
            $search = $request->search;
            $orders = Order::search($request->search)->whereStatus($type)->orWhere('status','refunded')->orderByDesc('id')->paginate(50);
        }
        return view('admin.orders.index', compact('title','type','orders','search'));
    }
    public function error_orders(Request $request)
    {
        $title = "Error Orders";
        $type = 'error';
        $search = "";
        $orders = Order::whereError(1)->orderByDesc('id')->paginate(100);
        if($request->has('search')){
            $search = $request->search;
            $orders = Order::search($request->search)->whereError(1)->orderByDesc('id')->paginate(50);
        }
        return view('admin.orders.index', compact('title','type','orders','search'));
    }

    function delete_order($id){
        $order = Order::findOrFail($id);
        $order->delete();

        session()->flash('success', 'Order has been deleted');
        return back();
    }
    function order_details($id){
        $order = Order::findOrFail($id);
        return view('admin.orders.details',compact('order'));
    }

    function update_order(Request $request, $id){
        $this->validate($request, [
            'link' => 'required',
            'remain' => 'nullable|numeric|not_in:0',
            'start_counter' => 'nullable|numeric|not_in:0',
            'status' => 'required|in:pending,processing,progress,completed,partial,canceled,refunded',
            'refill_status' => 'sometimes|in:awaiting,pending,processing,progress,completed,partial,canceled,refunded'
        ]);

        $order = Order::with('user')->find($id);
        $order->start_counter = $request['start_counter'] == '' ? null : $request['start_counter'];
        $order->link = $request['link'];
        $order->remain = $request['remain'] == '' ? null : $request['remain'];
        $order->reason = $request['reason'] ?? "";
        $order->error = 0;
        $user = $order->user;

        if ($request->status == 'canceled' && $order->remain != 0 && $order->status != "canceled" && $order->status != "completed") {
            $perOrder = $order->price / $order->quantity;
            $getBackAmo = $order->remain * $perOrder;

            $user = $order->user;
            $user->balance += $getBackAmo;
            $user->save();

            $trans = new Transaction();
            $trans->user_id = $user->id;
            $trans->type = 1; // 1- credit, 2- debit, 3-others
            $trans->code = getTrx();
            $trans->message = 'Refunded order on #'.$order->id;
            $trans->amount =$getBackAmo;
            $trans->status = 1;
            $trans->charge = 0;
            $trans->service = "order";
            $trans->response = "";
            $trans->new_balance = $user->balance;
            $trans->old_balance = $user->balance - $getBackAmo;
            $trans->save();
        }

        $order->status = $request['status'];
        $order->save();

        // send email
        $user = $order->user;
        $sub = "Order Status Updated";
        $mesg = "<p>Your Order has been updated </p> <ul><li> Order Id: ".$order->id." </li><li> Remains: ".$order->remain. "</li> <li>Order status: ".$order->status ."</li></ul>" ;
        general_email($user->email, $sub, $mesg );

        return back()->with('success', 'Order Updated Successfully');

    }

    function update_order_status(Request $request){
        // return $request->all();
        $status = $request->status;
        if ($request->strIds == null) {
            session()->flash('error', "You have not selected any order.");
            return response()->json(['error' => 1]);
        } else {
            $ids = explode(",", $request->strIds);

            if (count($ids) > 0) {
                $logs = Order::whereIn('id', $ids)->with('user')->get()->map(function ($order) use($status){

                    if ($status == 'canceled' && $order->remain != 0 && $order->status != "canceled" && $order->status != "completed") {
                        $perOrder = $order->price / $order->quantity;
                        $getBackAmo = $order->remain * $perOrder;

                        $user = $order->user;
                        $user->balance += $getBackAmo;
                        $user->save();

                        $trans = new Transaction();
                        $trans->user_id = $user->id;
                        $trans->type = 1; // 1- credit, 2- debit, 3-others
                        $trans->code = getTrx();
                        $trans->message = 'Refunded order on #'.$order->id;
                        $trans->amount =$getBackAmo;
                        $trans->status = 1;
                        $trans->charge = 0;
                        $trans->service = "order";
                        $trans->response = "";
                        $trans->new_balance = $user->balance;
                        $trans->old_balance = $user->balance - $getBackAmo;
                        $trans->save();

                    }
                    $order->error = 0;
                    $order->status = $status;
                    $order->save();

                    if ($order->status == 'completed') {
                        $user = $order->user;
                        $sub = "Order Completed";
                        $mesg = "Hi {$user->username}, <br>  <p>Your Order with ID {$order->id} is completed. Would You like to make a new order?</p> <br>
                        <a href='" . route('user.orders.create') . "' style='display: inline-block; background-color: #fa6e39; border: none; color: white; padding: 10px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; margin: 4px 2px; cursor: pointer; border-radius: 10px;'>New Order</a>";
                        general_email($user->email, $sub, $mesg );

                        // send notification
                    }

                    // send email
                    // $user = $order->user;
                    // $sub = "Order Status Updated";
                    // $mesg = "<p>Your Order has been updated </p> <ul><li> Order Id: ".$order->id." </li><li> Remains: ".$order->remain. "</li> <li>Order status: ".$order->status ."</li></ul>" ;
                    // general_email($user->email, $sub, $mesg );

                    return $order;

                });

                return $logs;
            }

            session()->flash('success', 'Order has been updated');
            return response()->json(['success' => 1]);
        }
    }

    // resend orders
    function resend_order($id){
        $order = Order::with('service','provider')->find($id);
        $user = $order->user;
        $apiproviderdata = $order->provider;
        $service = $order->service;
        $order->error = 0;
        $order->status = 'pending';
        if($service && $service->manual_api == 0){
            $postData = [
                'key' => $apiproviderdata['api_key'],
                'action' => 'add',
                'service' => $service->api_service_id,
                'link' => $order['link'],
                'quantity' => $order['quantity'],
            ];
            if($service->dripfeed){
                if (isset($order['runs']))
                    $postData['runs'] = $order['runs'];
                if (isset($order['interval']))
                    $postData['interval'] = $order['interval'];
            }

            if (isset($order['comments']))
                $postData['comments'] = $order['comments'];

            if (isset($order['username']))
                $postData['username'] = $order['username'];

            if (isset($order['usernames']))
                $postData['usernames'] = $order['usernames'];


            $apidata = send_post_request($apiproviderdata->api_url, $postData);
            if (isset($apidata['order'])) {
                $order->response = $apidata;
                $order->status = "processing";
                $order->api_order_id = $apidata['order'];
            } else {
                // $order->status = 'canceled';
                $order->api_order_id = $apidata['order'] ?? null;
                $order->response = $apidata;
                // $order->error = 1;
                $order->error_message = $apidata['error'] ?? "";
            }
        }

        $order->save();

        return redirect()->route('admin.orders.index')->withSuccess('Order Resent Successfully');
    }
}
