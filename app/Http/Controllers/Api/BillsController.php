<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Process\BillProcess;
use App\Models\Betsite;
use App\Models\BetTrx;
use App\Models\CablePlan;
use App\Models\DataBundle;
use App\Models\Decoder;
use App\Models\DecoderTrx;
use App\Models\Electricity;
use App\Models\Network;
use App\Models\NetworkTrx;
use App\Models\PowerTrx;
use App\Models\Transaction;
use App\Utility\Ncwallet;
use Auth;
use Illuminate\Http\Request;
use Validator;

class BillsController extends Controller
{
    // Get Networks
    public function networks(Request $request)
    {
        $networks = Network::whereStatus(1)->get();
        $res = [];
        foreach ($networks as $item) {
            $res[] = [
                'id' => $item['id'],
                'image' => my_asset($item['image']),
                'airtime' => $item['airtime'],
                'data' => $item['data'],
                'name' => $item['name'],
                'airtime_discount' => $item['discount'],
                'airtime_minimum' => $item['minimum'],
            ];

        }
        $response['status'] = 'success';
        $response['message'] = 'Networks Fetched successfully';
        $response['data'] = $res;

        return $response;
    }

    // Buy Airtime
    public function buy_airtime(Request $request)
    {
        if (sys_setting('is_airtime') != 1) {
            return response()->json([
                'status' => 'error',
                'message' => 'Airtime service is currently disabled. Please try again later.',
            ]);
        }
        // $request->all();
        $request->validate([
            'amount' => 'required|numeric|min:100',
            'phone' => 'required|digits:11|numeric',
            'network' => 'required|exists:networks,id',
        ]);
        if ($request->amount < 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'Amount must not be less than 1. Try again',
            ]);
        }
        $user = Auth::user();
        $network = Network::findOrFail($request->network);
        $cost = $request->amount * ($network->discount / 100);
        if ($user->balance < $cost) {
            $response['status'] = 'error';
            $response['message'] = 'Insufficient Balance Fund Your Wallet And Try Again '.format_price($user->balance);

            return $response;
        }
        $trans = new Transaction;
        $trans->user_id = $user->id;
        $trans->type = 2; // 1- credit, 2- debit, 3-others
        $trans->code = getTrx();
        $trans->message = "Pending Purchase of  {$network->name} Airtime worth ".format_price($request->amount).' for '.$request->phone;
        $trans->amount = $cost;
        $trans->status = 2;
        $trans->charge = 0;
        $trans->service = 'airtime';
        $trans->old_balance = $user->balance;
        $trans->new_balance = $user->balance - $cost;
        $trans->save();
        // Create network Trx
        $trx = new NetworkTrx;
        $trx->user_id = $user->id;
        $trx->network_id = $network->id;
        $trx->type = 1; // 1- airtime, 2- data, 3-swap
        $trx->code = $trans->code;
        $trx->name = "Purchase of {$network->name} Airtime worth  ".format_price($request->amount).' for '.$request->phone;
        $trx->amount = $cost;
        $trx->status = 2; // 1 - success , 2- pending, 3 -declined
        $trx->charge = 0;
        $trx->number = $request->phone;
        $trx->new_balance = $user->balance - $cost;
        $trx->old_balance = $user->balance;
        $trx->save();
        // deduct balance
        $user->balance = $user->balance - $cost;
        $user->save();
        // api transaction
        $data = [
            'amount' => $request['amount'],
            'phone' => $request['phone'],
            'network' => $network['id'],
            'ref' => $trx->code,
        ];
        $process = new BillProcess;
        $apires = $process->purchase_airtime($data);
        if (isset($apires['api_status']) && $apires['api_status'] == 'success') {
            $trans->message = "You Successfully Purchased {$network->name} Airtime worth  ".format_price($request->amount).' for '.$request->phone;
            $trans->status = 1;
            $trans->response = json_encode($apires);
            $trans->save();
            // Create network Trx
            $trx->name = "You Successfully Purchased {$network->name} Airtime worth  ".format_price($request->amount).' for '.$request->phone;
            $trx->response = json_encode($apires);
            $trx->status = 1; // 1 - success , 2- pending, 3 -declined
            $trx->api_name = $apires['name'];
            $trx->save();
            // give referral bonus
            if (sys_setting('is_affiliate') == 1) {
                give_affiliate_bonus($user->id, $request->amount);
            }

            // give user point
            giveUserPoint($user->id, $request->amount);

            $e_mess = "Hi {$user->username}, <br> A debit transaction  of <b>".format_price($request->amount).'</b> occured on your Account.
            <br> <p> See Below for details of Transactions. </p>
                Amount : '.format_price($trans->amount)."<br> Details: {$trans->message} <br> Reference : {$trans->code} <br> Balance: ".format_price($user->balance).'<br> Date : '.show_datetime($trans->created_at);
            general_email($user->email, 'Debit Alert', $e_mess);

            $res['status'] = 'success';
            $res['message'] = "Successfully purchased {$request->amount} worth of {$network->name} airtime for {$request->phone}.";

            return $res;

        } else {
            $trx->new_balance = $trx->old_balance;
            $trans->new_balance = $trx->old_balance;
            $trans->status = 3;
            $trans->response = json_encode($apires);
            $trans->save();
            // Create network Trx
            $trx->api_name = $apires['name'];
            $trx->response = json_encode($apires);
            $trx->status = 3; // 1 - success , 2- pendig, 3 -declined
            $trx->save();
            // refund user
            $user->balance = $user->balance + $cost;
            $user->save();
            $messg = 'Please try again';
            // cancel transaction
            $res['status'] = 'error';
            $res['message'] = "Failed to purchase {$request->amount} worth of {$network->name} airtime for {$request->phone}.";

            return $res;
            // return back()->with('error', 'Transaction wasnot successful. '.$messg);
        }
        $res['status'] = 'error';
        $res['message'] = 'Something went wrong. Please try again';

        return $res;

    }

    // Data
    public function data_plans(Request $request)
    {
        $option_plan = [];

        $dataplan = DataBundle::where('network_id', $request->network)->whereStatus(1)->get();

        if ($dataplan->count() > 0) {
            foreach ($dataplan as $fetch_data) {
                $option_plan[] = [
                    'network' => $fetch_data['network_id'],
                    'id' => $fetch_data['id'],
                    'type' => $fetch_data['service'],
                    'price' => $fetch_data['price'],
                    'name' => $fetch_data['name'].' - ₦'.$fetch_data['price'],
                ];
            }

            $response['status'] = 'success';
            $response['message'] = 'Data Plans Fetched successfully';
            $response['data'] = $option_plan;

            return $response;
        }

        $response['status'] = 'error';
        $response['message'] = 'No dataplan found.';

        return $response;
    }

    // Buy Data
    public function buy_data(Request $request)
    {
        // validate requests
        if (sys_setting('is_data') != 1) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data service is currently disabled. Please try again later.',
            ]);
        }
        $request->validate([
            'phone' => 'required|digits:11|numeric',
            'plan' => 'required|exists:data_bundles,id',
            'type' => 'required',
            'network' => 'required|numeric',
        ]);

        // return $request;
        $user = Auth::user();
        $plan = DataBundle::findOrFail($request->plan);
        $network = $plan->network;
        if ($user->balance < $plan->price) {
            $response['status'] = 'error';
            $response['message'] = 'Insufficient Balance Fund Your Wallet And Try Again '.format_price($user->balance);

            return $response;
        }
        // create transaction
        $trans = new Transaction;
        $trans->user_id = $user->id;
        $trans->type = 2; // 1- credit, 2- deit, 3-others
        $trans->code = getTrx();
        $trans->message = 'Purchase of '.$plan->name.' to '.$request['phone'];
        $trans->amount = $plan->price;
        $trans->status = 3;
        $trans->charge = 0;
        $trans->service = 'data'; // bills
        $trans->old_balance = $user->balance;
        $trans->new_balance = $user->balance - $plan->price;
        $trans->save();
        // Create network Trx
        $trx = new NetworkTrx;
        $trx->user_id = $user->id;
        $trx->network_id = $network->id;
        $trx->type = 2; // 1- airtime, 2- data, 3-swap
        $trx->code = $trans->code;
        $trx->name = $trans->message;
        $trx->amount = $plan->price;
        $trx->status = 2; // 1 - success , 2- pendig, 3 -declined
        $trx->charge = 0;
        $trx->number = $request->phone;
        $trx->new_balance = $user->balance - $plan->price;
        $trx->old_balance = $user->balance;
        $trx->save();
        // deduct balance
        $user->balance = $user->balance - $plan->price;
        $user->save();
        $data = [
            'amount' => $plan->price,
            'phone' => $request['phone'],
            'service' => $plan['service'],
            'network' => $network['id'],
            'plan' => $plan->id,
            'ref' => $trx->code,
        ];
        $process = new BillProcess;
        $apires = $process->purchase_data($data);
        if (isset($apires['api_status']) && $apires['api_status'] == 'success') {
            $trans->message = 'You have successfully purchased '.$plan->name.' to '.$request['phone'];
            // $trans->message =  $apires['message'];
            $trans->status = 1;
            $trans->response = json_encode($apires['response']);
            $trans->save();
            // Create network Trx
            $trx->api_name = $apires['name'];
            $trx->name = $trans['message'];
            $trx->status = 1; // 1 - success , 2- pendig, 3 -declined
            $trx->response = json_encode($apires['response']);
            $trx->save();
            // give referral bonus
            if (sys_setting('is_affiliate') == 1) {
                give_affiliate_bonus($user->id, $plan->price);
            }

            // give user point
            giveUserPoint($user->id, $plan->price);

            $e_mess = "Hi {$user->username}, <br> A debit transaction  of <b>".format_price($plan->price).'</b> occured on your Account.
            <br> <p> See Below for details of Transactions. </p>
                Amount : '.format_price($trans->amount)."<br> Details: {$trans->message} <br> Reference : {$trans->code} <br> Balance: ".format_price($user->balance).'<br> Date : '.show_datetime($trans->created_at);
            general_email($user->email, 'Debit Alert', $e_mess);

            $messg = $trans['message'];
            $res['status'] = 'success';
            $res['message'] = $messg;

            return $res;

        } else {
            $trans->status = 3;
            $trans->response = json_encode($apires['response']);
            $trans->new_balance = $trans->old_balance;
            $trans->save();
            // Create network Trx
            $trx->api_name = $apires['name'];
            $trx->status = 3; // 1 - success , 2- pendig, 3 -declined
            $trx->response = json_encode($apires['response']);
            $trx->new_balance = $trx->old_balance;
            $trx->save();
            // refund user
            $user = Auth::user();
            $user->balance = $user->balance + $plan->price;
            $user->save();
            // cancel transaction

            $res['status'] = 'error';
            $res['message'] = 'Transaction wasnot successful. Please try again';

            return $res;
        }
        $res['status'] = 'error';
        $res['message'] = 'Something went wrong. Please try again';

        return $res;
    }

    // Cables
    public function cables()
    {
        $cables = Decoder::whereStatus(1)->get();
        $res = null;
        foreach ($cables as $item) {
            $res[] = [
                'id' => $item['id'],
                'image' => my_asset($item['image']),
                'name' => $item['name'],
                'status' => $item['status'],
            ];

        }

        $response['status'] = 'success';
        $response['message'] = 'Decoders Fetched successfully';
        $response['data'] = $res;

        return $response;
    }

    public function cable_plans(Request $request)
    {
        $option_plan = [];
        $cableplan = CablePlan::where('decoder_id', $request->cable)->whereStatus(1)->get();

        if ($cableplan->count() > 0) {
            foreach ($cableplan as $fetch_data) {
                $option_plan[] = [
                    'cable' => $fetch_data['decoder_id'],
                    'id' => $fetch_data['id'],
                    'price' => $fetch_data['price'],
                    'name' => $fetch_data['name'].' - ₦'.$fetch_data['price'],
                ];
            }

            $response['status'] = 'success';
            $response['message'] = 'Cable Plans Fetched successfully';
            $response['data'] = $option_plan;

            return $response;
        }

        $response['status'] = 'error';
        $response['message'] = 'No cable plan found.';

        return $response;
    }

    public function cable_validation(Request $request)
    {
        $data = [
            'cable' => $request->cable,
            'iuc' => $request['number'],
        ];
        $api = new Ncwallet;
        try {
            $response = $api->validateCable($data);
            if (isset($response['name'])) {
                return [
                    'status' => 'success',
                    'message' => 'Name Validated Successfully',
                    'name' => $response['name'],
                    'current_plan' => $response['current_plan'] ?? '',
                ];
            } else {
                return [
                    'status' => 'error',
                    'message' => 'Unable to get Customer Name. Please check and try again',
                ];
            }
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Customer Validation failed. Please check and try again',
            ];
        }

    }

    // Buy Cable
    public function buy_cable(Request $request)
    {
        // return $request->all();
        if (sys_setting('is_cable') != 1) {
            return response()->json([
                'status' => 'error',
                'message' => 'Cable Subscription is currently disabled. Please try again later.',
            ]);
        }
        $validator = Validator::make($request->all(), [
            'cable_plan' => 'required|numeric',
            'cable' => 'required|string',
            'number' => 'required|min:9',
            'customer_name' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->all(),
            ]);
        }
        $user = Auth::user();
        $decoder = Decoder::find($request->cable);
        $plan = CablePlan::findorFail($request->cable_plan);

        $cost = $plan->price;
        if ($user->balance < $cost) {
            $response['status'] = 'error';
            $response['message'] = 'Insufficient Balance Fund Your Wallet And Try Again '.format_price($user->balance);

            return $response;
        }
        // create transaction
        $trans = new Transaction;
        $trans->user_id = $user->id;
        $trans->type = 2; // 1- credit, 2- deit, 3-others
        $trans->code = getTrx();
        $trans->message = "Pending purchase of  {$decoder->name} {$plan->name}  to {$request->number}";
        $trans->amount = $cost;
        $trans->status = 2;
        $trans->charge = 0;
        $trans->service = 'cable'; // cable
        $trans->old_balance = $user->balance;
        $trans->new_balance = $user->balance - $cost;
        $trans->save();
        // Cable Trx
        $trx = new DecoderTrx;
        $trx->user_id = $user->id;
        $trx->decoder_id = $decoder->id;
        $trx->code = $trans->code;
        $trx->name = "Pending purchase of {$decoder->name} - {$plan->name}  to {$request->number}";
        $trx->message = "Pending purchase of {$decoder->name} - {$plan->name}  to {$request->number}";
        $trx->amount = $cost;
        $trx->status = 2; // 1 - success , 2- pending, 3 -declined
        $trx->charge = 0;
        $trx->customer_name = $request->customer_name ?? 'Bypass user';
        $trx->number = $request->number;
        $trx->new_balance = $user->balance - $cost;
        $trx->old_balance = $user->balance;
        $trx->save();
        // deduct balance
        $user->balance = $user->balance - $cost;
        $user->save();
        // api transaction
        $data = [
            'amount' => $cost,
            'customer' => $request['number'],
            'plan' => $plan->id,
            'decoder' => $decoder->id,
            'ref' => $trans->code,
            'name' => $request->customer_name ?? 'Test User',
        ];
        $process = new BillProcess;
        $apires = $process->purchase_cabletv($data);
        if (isset($apires['api_status']) && $apires['api_status'] == 'success') {
            $trans->message = "You have successfully purchase {$decoder->name} {$plan->name}  to {$request->number}";
            $trans->status = 1;
            $trans->response = json_encode($apires['response']);
            $trans->save();
            // Create Cable Trx
            $trx->response = json_encode($apires['response']);
            $trx->name = "You have successfully purchase {$decoder->name} - {$plan->name}  to {$request->number}";
            $trx->message = "You have successfully purchase {$decoder->name} - {$plan->name}  to {$request->number}";
            $trx->status = 1; // 1 - success , 2- pending, 3 -declined
            $trx->save();
            // give referral bonus
            if (sys_setting('is_affiliate') == 1) {
                give_affiliate_bonus($user->id, $cost);
            }

            // give user point
            giveUserPoint($user->id, $cost);

            $e_mess = "Hi {$user->username}, <br> A debit transaction  of <b>".format_price($request->amount).'</b> occured on your Account.
            <br> <p> See Below for details of Transactions. </p>
                Amount : '.format_price($trans->amount)."<br> Details: {$trans->message} <br> Reference : {$trans->code} <br> Balance: ".format_price($user->balance).'<br> Date : '.show_datetime($trans->created_at);
            general_email($user->email, 'Debit Alert', $e_mess);

            $res['status'] = 'success';
            $res['message'] = $trans->message;

            return $res;

        } else {
            $trans->new_balance = $user->balance + $cost;
            $trans->message = "Transaction failed for {$decoder->name} - {$plan->name}  to {$request->number}";
            $trans->status = 3;
            $trans->response = json_encode($apires['response']);
            $trans->save();
            $trx->new_balance = $user->balance + $cost;
            $trx->name = $trans->message;
            $trx->message = $trans->message;
            $trx->status = 3; // 1 - success , 2- pending, 3 -declined
            $trx->response = json_encode($apires['response']);
            $trx->save();
            // refund user
            $user = Auth::user();
            $user->balance = $user->balance + $cost;
            $user->save();
            $res['status'] = 'error';
            $res['message'] = $trans->message;

            return $res;
            // cancel transaction
        }
        $res['status'] = 'error';
        $res['message'] = 'Something went wrong. Please try again';

        return $res;
    }

    // ELectricity Payment
    public function powers()
    {
        $plans = Electricity::whereStatus(1)->get();
        $res = [];
        foreach ($plans as $item) {
            $res[] = [
                'id' => $item['id'],
                'name' => $item['name'],
                'fee' => $item['fee'],
                'minimum' => $item['minimum'],
                'status' => $item['status'],
            ];

        }

        $response['status'] = 'success';
        $response['message'] = 'Power Plans Fetched successfully';
        $response['data'] = $res;

        return $response;
    }

    // Validate meter
    public function power_validation(Request $request)
    {
        $disco = Electricity::findOrFail($request->disco);
        $data = [
            'disco' => $disco->code,
            'meter_number' => $request['meter_number'],
            'meter_type' => $request->meter_type,
        ];
        $api = new Ncwallet;
        try {
            $response = $api->validateMeter($data);
            if (isset($response['status']) && $response['status'] == 'success') {
                if ($response['meter_name'] == null) {
                    return [
                        'status' => 'error',
                        'message' => 'Invalid Name. Please check meter',
                        'name' => 'Invalid Name. Please check meter',
                    ];
                }

                return [
                    'status' => 'success',
                    'name' => $response['meter_name'],
                    'company' => $response['meter_company'],
                    'address' => $response['meter_address'],
                ];
            } else {
                return [
                    'status' => 'error',
                    'message' => 'invalid Meter Number',
                ];
            }
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Unable to get Customer Name. Please check and try again',
            ];
        }

    }

    public function buy_electricity(Request $request)
    {
        if (sys_setting('is_power') != 1) {
            return response()->json([
                'status' => 'error',
                'message' => 'Electricity Payment is currently disabled. Please try again later.',
            ]);
        }
        // return $request->all();
        $disco = Electricity::findOrFail($request->disco);
        $min = $disco->minimum;
        $validator = Validator::make($request->all(), [
            'disco' => 'required|numeric',
            'type' => 'required|string',
            'number' => 'required|numeric|min:9',
            'customer_name' => 'required|string',
            'amount' => 'required|min:'.$min.'|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->all(),
            ]);
        }
        $user = Auth::user();
        $cost = $request->amount + $disco->fee;
        if ($user->balance < $cost) {
            return response()->json([
                'status' => 'error',
                'message' => 'Insufficient Balance Fund Your Wallet And Try Again '.format_price($user->balance),
            ]);
        }
        // create transaction
        $trans = new Transaction;
        $trans->user_id = $user->id;
        $trans->type = 2; // 1- credit, 2- deit, 3-others
        $trans->code = getTrx();
        $trans->message = 'Pending transaction '.$request['amount'].' Purchase '.$disco->name.' for '.$request->number;
        $trans->amount = $request->amount;
        $trans->status = 2;
        $trans->charge = $disco->fee;
        $trans->service = 'electricity'; // electricity
        $trans->old_balance = $user->balance;
        $trans->new_balance = $user->balance - $cost;
        $trans->save();
        // Power Trx
        $trx = new PowerTrx;
        $trx->user_id = $user->id;
        $trx->electricity_id = $disco->id;
        $trx->code = $trans['code'];
        $trx->name = $trans->message;
        $trx->amount = $request->amount;
        $trx->status = 2; // 1 - success , 2- pending, 3 -declined
        $trx->customer_name = $request->customer_name;
        $trx->number = $request->number;
        $trx->new_balance = $user->balance - $cost;
        $trx->old_balance = $user->balance;
        $trx->save();

        // deduct balance
        $user->balance = $user->balance - $cost;
        $user->save();
        $data = [
            'name' => $request->customer_name,
            'type' => $request->type,
            'amount' => $request->amount,
            'service' => $disco['code'],
            'number' => $request->number,
            'disco' => $disco['id'],
            'phone' => $user->phone ?? '09039941461',
            'ref' => $trans->code,
        ];
        $process = new BillProcess;
        $response = $process->purchase_power($data);
        if (isset($response['api_status']) && $response['api_status'] == 'success') {
            $trans->status = 1;
            $trans->message = "You have successfully purchase {$disco->name} - {$request->amount} to {$request->number}. {$response['token']}";
            $trans->response = json_encode($response);
            $trans->save();
            // Power Trx
            $trx->response = json_encode($response);
            $trx->name = "You have successfully purchase {$disco->name} - {$request->amount} to {$request->number}. {$response['token']}";
            $trx->status = 1; // 1 - success , 2- pending, 3 -declined
            $trx->token = $response['token'] ?? '';
            $trx->save();

            // give referral bonus
            if (sys_setting('is_affiliate') == 1) {
                give_affiliate_bonus($user->id, $request->amount);
            }

            // give user point
            giveUserPoint($user->id, $request->amount);

            $res['status'] = 'success';
            $res['message'] = $trx->name;
            $res['token'] = $trx->token ?? '';

            $e_mess = "Hi {$user->username}, <br> A debit transaction  of <b>".format_price($request->amount).'</b> occured on your Account.
            <br> <p> See Below for details of Transactions. </p>
                Amount : '.format_price($trans->amount)."<br> Details: {$trans->message} <br> Reference : {$trans->code} <br> Balance: ".format_price($user->balance).'<br> Date : '.show_datetime($trans->created_at);
            general_email($user->email, 'Debit Alert', $e_mess);

            return $res;
        } else {
            $trans->status = 3;
            $trans->new_balance = $trans->old_balance;
            $trans->response = json_encode($response);
            $trans->save();
            $trx->status = 3;
            $trx->new_balance = $trans->old_balance;
            $trx->response = json_encode($response);
            $trx->save();
            // refund user
            $user->balance = $user->balance + $cost;
            $user->save();
            // cancel transaction
            $res['status'] = 'error';
            $res['message'] = 'Transaction wasnot successful. Please try again';

            return $res;
        }
        $res['status'] = 'error';
        $res['message'] = 'Something went wrong. Please try again';

        return $res;
    }

    // Betting
    public function betplans()
    {
        $plans = Betsite::whereStatus(1)->get();
        $res = [];
        foreach ($plans as $item) {
            $res[] = [
                'id' => $item['id'],
                'name' => $item['name'],
                'fee' => $item['fee'],
                'minimum' => $item['minimum'],
                'status' => $item['status'],
            ];

        }

        $response['status'] = 'success';
        $response['message'] = 'Bet Plans Fetched successfully';
        $response['data'] = $res;

        return $response;
    }

    public function bet_validation(Request $request)
    {
        $betsite = Betsite::findOrFail($request->betsite);
        $data = [
            'betsite_id' => $betsite->code,
            'betting_number' => $request['accountId'],
        ];
        $api = new Ncwallet;
        try {
            $response = $api->validateBet($data);
            if (isset($response['status']) && $response['status'] == 'success') {
                if ($response['betting_name'] == null) {
                    return [
                        'status' => 'error',
                        'message' => 'Invalid Name. Please check meter',
                        'name' => 'Invalid Name. Please check meter',
                    ];
                }

                return [
                    'status' => 'success',
                    'name' => $response['betting_name'],
                    'company' => $response['betting_company'],
                    'number' => $response['betting_number'],
                ];
            } else {
                return [
                    'status' => 'error',
                    'message' => 'invalid Meter Number',
                ];
            }

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Unable to get Customer Name. Please check and try again',
            ];
        }

    }

    public function buy_bet(Request $request)
    {
        // return $request->all();
        if (sys_setting('is_betting') != 1) {
            return response()->json([
                'status' => 'error',
                'message' => 'Bet Payment is currently disabled. Please try again later.',
            ]);
        }
        $disco = Betsite::findOrFail($request->betsite);
        $min = $disco->minimum;
        $validator = Validator::make($request->all(), [
            'betsite' => 'required|numeric',
            'number' => 'required|string|min:4',
            'bypass' => 'string',
            'amount' => 'required|min:'.$min.'|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->all(),
            ]);
        }
        $user = Auth::user();
        $cost = $request->amount + $disco->fee;
        if ($user->balance < $cost) {
            return response()->json([
                'status' => 'error',
                'message' => 'Insufficient Balance Fund Your Wallet And Try Again '.format_price($user->balance),
            ]);
        }
        // create transaction
        $trans = new Transaction;
        $trans->user_id = $user->id;
        $trans->type = 2; // 1- credit, 2- deit, 3-others
        $trans->code = getTrx();
        $trans->message = 'Pending transaction for '.$request['amount'].' Purchase '.$disco->name.' for '.$request->number;
        $trans->amount = $request->amount;
        $trans->status = 2;
        $trans->charge = $disco->fee;
        $trans->service = 'betting'; // betting
        $trans->old_balance = $user->balance;
        $trans->new_balance = $user->balance - $cost;
        $trans->save();
        // Bet Trx
        $trx = new BetTrx;
        $trx->user_id = $user->id;
        $trx->betsite_id = $disco->id;
        $trx->code = $trans['code'];
        $trx->name = $trans->message;
        $trx->amount = $request->amount;
        $trx->status = 2; // 1 - success , 2- pending, 3 -declined
        $trx->customer_name = $request->customer_name ?? '';
        $trx->number = $request->number;
        $trx->new_balance = $user->balance - $cost;
        $trx->old_balance = $user->balance;
        $trx->save();

        // deduct balance
        $user->balance = $user->balance - $request->amount;
        $user->save();
        $data = [
            'amount' => $request->amount,
            'service' => $disco['code'],
            'number' => $request->number,
            'betsite' => $disco['id'],
            'ref' => $trans->code,
        ];
        $process = new BillProcess;
        $response = $process->purchase_betting($data);
        if (isset($response['api_status']) && $response['api_status'] == 'success') {
            $trans->status = 1;
            $trans->message = "You have successfully purchase {$disco->name} {$request->amount} to {$request->number}.";
            $trans->response = json_encode($response);
            $trans->save();
            // Bet Trx
            $trx->response = json_encode($response);
            $trx->name = "You have successfully purchase {$disco->name} - {$request->amount} to {$request->number}.";
            $trx->status = 1; // 1 - success , 2- pending, 3 -declined
            $trx->save();

            // give referral bonus
            if (sys_setting('is_affiliate') == 1) {
                give_affiliate_bonus($user->id, $request->amount);
            }
            // give user point
            giveUserPoint($user->id, $request->amount);

            $res['status'] = 'success';
            $res['message'] = $trx->name;

            $e_mess = "Hi {$user->username}, <br> A debit transaction  of <b>".format_price($request->amount).'</b> occured on your Account.
            <br> <p> See Below for details of Transactions. </p>
                Amount : '.format_price($trans->amount)."<br> Details: {$trans->message} <br> Reference : {$trans->code} <br> Balance: ".format_price($user->balance).'<br> Date : '.show_datetime($trans->created_at);
            general_email($user->email, 'Debit Alert', $e_mess);

            return $res;
        } else {
            $trans->status = 3;
            $trans->new_balance = $trans->old_balance;
            $trans->response = json_encode($response);
            $trans->save();
            $trx->status = 3;
            $trx->new_balance = $trans->old_balance;
            $trx->response = json_encode($response);
            $trx->save();
            // refund user
            $user->balance = $user->balance + $request->amount;
            $user->save();
            // cancel transaction
            $res['status'] = 'error';
            $res['message'] = 'Transaction wasnot successful. Please try again';

            return $res;
        }
        $res['status'] = 'error';
        $res['message'] = 'Something went wrong. Please try again';

        return $res;
    }
}
