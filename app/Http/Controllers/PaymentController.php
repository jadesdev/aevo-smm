<?php

namespace App\Http\Controllers;

use App\Models\Deposit;
use App\Utility\Binance;
use App\Utility\Coinbase;
use App\Utility\MonnifyUtility as Monnify;
use Auth;
use Bhekor\LaravelFlutterwave\Facades\Flutterwave;
use Http;
use Illuminate\Http\Request;
use Paystack;

class PaymentController extends Controller
{
    // FLutter api payment
    function initFlutterApi($details){
        $data = [
            'payment_options' => 'card,banktransfer',
            'amount' => $details['final'],
            'email' => $details['email'],
            'tx_ref' => $details['reference'],
            'meta' => $details,
            'currency' =>get_setting('currency_code'),
            'redirect_url' => route('flutter.success'),
            'customer' => [
                'email' => $details['email'],
                "phone_number" => $details['phone'],
                "name" => $details['name']
            ],
        ];
        // dd($data);
        $payment = Flutterwave::initializePayment($data);
        if ($payment['status'] !== 'success') {
            // notify something went wrong
            return response()->json(['status' => 'error','message' => 'Payment was not successful'], 403);
        }
        return response()->json([
            'status' => 'success',
            'gateway' => 'flutterwave',
            'message' => 'Payment Link generated successfully',
            'link'  => $payment['data']['link']
        ], 200);
    }

    function flutter_success(Request $request){
        $status = request()->status;

        if ($status ==  'cancelled'){
            $request->session()->remove('payment_data');
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Payment was not successful'], 403);
            }

            if (Auth::guest() ) {
                //redirect to payment success page
                return to_route('pay.error')->withError("Payment was not successful. Please Try again");
            }
            return redirect()->route('user.wallet')->withError('Payment not successful');
        }

        $transactionID = Flutterwave::getTransactionIDFromCallback();
        $payment = Flutterwave::verifyTransaction($transactionID);
        $details1 = $request->session()->get('payment_data');

        //if payment is successful
        if ($payment['status'] ==  'success' || $status == 'completed') {
            $details = $payment['data']['meta'];

            $complete = new UserController();
            return $complete->complete_deposit($details, $payment);
        }
        elseif ($status ==  'cancelled'){
            $request->session()->remove('payment_data');
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Payment was not successful'], 403);
            }

            if (Auth::guest() ) {
                //redirect to payment success page
                return to_route('pay.error')->withError("Payment was not successful. Please Try again");
            }
            return redirect()->route('user.wallet')->withError('Payment not successful');
        }
        else{
            // $deposit = Deposit::whereCode($details['reference'])->first();
            // $deposit->status = 3;
            // $deposit->save();
            $request->session()->remove('impt_data');
            $request->session()->remove('payment_data');
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Payment was not successful. Please Try again'], 200);
            }
            if (Auth::guest() ) {
                //redirect to payment success page
                return to_route('pay.error')->withError("Payment was not successful. Please Try again");
            }
            return redirect()->route('index')->withError('Payment was not Successfull. Please try again');
        }
    }

    function paystack_success(Request $request){
        // return $request;
        $payment = array();
        //The parameter after verify/ is the transaction reference to be verified
        $url = 'https://api.paystack.co/transaction/verify/' . $request->reference;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . env('PAYSTACK_SECRET_KEY')]);
        $response = curl_exec($ch);
        curl_close($ch);
        if ($response) {

            $payment = json_decode($response, true);
            $details = $request->session()->get('payment_data');

            if(!empty($payment['data']) && $payment['data']['status'] == 'success'){
                // return $details = $payment['data']['metadata'];

                $complete = new UserController();
                return $complete->complete_deposit($details, $payment);
            }
            else{
                $deposit = Deposit::whereCode($request['reference'])->first();
                $deposit->status = 3;
                $deposit->save();
                return redirect()->route('user.deposit')->withError('Payment was not successful. Please try Again');
            }
        }

        // return($payment);



    }

    // Monnify Success
    function monnify_success(Request $request){
        // return $request;
        $data = [
			'paymentReference' => $request['reference']
		] ;
        $details = $request->session()->get('payment_data');

        $monnify = new Monnify();
        $response = $monnify->verifyTransaction($data);

        if($response['responseMessage'] == 'success' && $response['responseBody']['paymentStatus'] == "PAID"){
            $complete = new UserController();
            return $complete->complete_deposit($details, $response);
        }
        else {
            $deposit = Deposit::whereCode($details['reference'])->first();
            $deposit->status = 3;
            $deposit->save();
            $request->session()->remove('payment_data');
            return redirect()->route('user.deposit')->withError('Payment not successful');
        }

    }
    public function listing_monnify_success (Request $request){
        $data = [
			'paymentReference' => $request['paymentReference']
		];
        $details = $request->session()->get('listings_payment_data');
        $details['paymentReference'] = $request['paymentReference'];
        $monnify = new Monnify();
        $response = $monnify->verifyTransaction($data);

        if($response['responseMessage'] == 'success' && $response['responseBody']['paymentStatus'] == "PAID"){
            $complete = new DealController();
            return $complete->complete_monnify_payment($details, $response);
        }
    }
    // Paypal success
    function paypal_success(Request $request){
        // return $request;
        $details = $request->session()->get('payment_data');
        $req = 'cmd=_notify-validate';
        if(sys_setting('paypal_demo') == 1){
            $paypalURL = "https://api.sandbox.paypal.com/v2/payments/captures/"; // use for sandbox text
        }else{
            $paypalURL = "https://api.paypal.com/v2/payments/captures/";
        }
        $url = $paypalURL . $request->token;
        // get deposit and approve payment
        $complete = new UserController();
        return $complete->complete_deposit($details, $request->all());
    }

    // Perfect Money
    function initPerfectMoneyApi($details){
        $val['PAYEE_ACCOUNT'] = trim(env('PM_WALLET'));
        $val['PAYEE_NAME'] = get_setting('title');
        $val['PAYMENT_ID'] = $details['reference'];
        $val['PAYMENT_AMOUNT'] = round($details['final2'], 2);
        $val['PAYMENT_UNITS'] = "USD";

        $val['STATUS_URL'] = route('perfect.success');
        $val['PAYMENT_URL'] = route('perfect.success');
        $val['PAYMENT_URL_METHOD'] = 'POST';
        $val['NOPAYMENT_URL'] = route('pay.error');
        $val['NOPAYMENT_URL_METHOD'] = 'GET';
        $val['SUGGESTED_MEMO'] = auth()->user()->username;
        $val['BAGGAGE_FIELDS'] = 'IDENT';

        $send['val'] = $val;
        $send['method'] = 'post';
        $send['url'] = 'https://perfectmoney.is/api/step1.asp';

        $response = Http::asForm()->post('https://perfectmoney.is/api/step1.asp', $val);


        return ($send);

    }
    function initPerfectMoney($details){

        $val['PAYEE_ACCOUNT'] = trim(env('PM_WALLET'));
        $val['PAYEE_NAME'] = get_setting('title');
        $val['PAYMENT_ID'] = $details['reference'];
        $val['PAYMENT_AMOUNT'] = round($details['final2'], 2);
        $val['PAYMENT_UNITS'] = "USD";

        $val['STATUS_URL'] = route('perfect.success');
        $val['PAYMENT_URL'] = route('perfect.success');
        $val['PAYMENT_URL_METHOD'] = 'POST';
        $val['NOPAYMENT_URL'] = route('user.deposit');
        $val['NOPAYMENT_URL_METHOD'] = 'GET';
        $val['SUGGESTED_MEMO'] = auth()->user()->username;
        $val['BAGGAGE_FIELDS'] = 'IDENT';

        $send['val'] = $val;
        $send['view'] = 'user.payment.perfect-money';
        $send['method'] = 'post';
        $send['url'] = 'https://perfectmoney.is/api/step1.asp';

        return ($send);

    }

    function perfect_success(Request $request){
        // save response to file
        $logFile = 'public/pmoney_log.txt';
        $logMessage = json_encode($request->all(), JSON_PRETTY_PRINT);
        file_put_contents($logFile, $logMessage, FILE_APPEND);
        $res =  $request->all();
        if($res['PAYEE_ACCOUNT'] != trim(env('PM_WALLET'))){
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Unauthorised Request'], 401);
            }
            return to_route('user.deposit')->withError('Unauthorised Request');
        }
        $deposit = Deposit::where('code',$res['PAYMENT_ID'])->first();
        if($deposit == null){
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Unidentified transaction. Please try again'], 404);
            }
            return to_route('user.deposit')->withError('Invalid Transaction. Please try again');
        }
        $user = $deposit->user;
        $details['amount'] = $deposit->amount;
        $details['final'] =  $deposit->final_amount;
        $details['final2'] =  round($details['final'] / get_setting('currency_rate'), 2);
        $details['name'] = $user->name();
        $details['user_id'] = $user->id;
        $details['deposit_id'] = $deposit->id;
        $details['phone'] = $user->phone;
        $details['description'] = $deposit->message;
        $details['gateway'] = "perfect";
        $details['email'] = $user->email;
        $details['reference'] = $deposit->code;
        // return [$details, $res];
        // $details = $request->session()->get('payment_data');
        $complete = new UserController();
        return $complete->complete_deposit($details, $res);
    }

    // Coinbase Payment
    function initCoinbase($details){
        $coinbase = new Coinbase();
        $checkoutData = [
            'name' => $details['name'],
            'description' => $details['description'],
            'pricing_type' => 'fixed_price',
            'local_price' => [
                'amount' => $details['final2'],
                'currency' => 'USD'
            ],
            'metadata' => $details,
            'cancel_url' => url()->previous(),
            'redirect_url' => route('coinbase.success'),
            // 'requested_info' => ['name', 'email']
        ];
        $response = $coinbase->createCharge($checkoutData);
        if ( isset($response['data']) ) {

            $send['redirect']     = true;
            $send['redirect_url'] = $response['data']['hosted_url'];
        }else{
            $send['redirect']     = false;
            session()->put('error','Payment was Not Successful');
            $send['redirect_url'] = route('user.deposit');
        }

        return $send;
    }
    function initCoinbaseApi($details){
        $coinbase = new Coinbase();
        $checkoutData = [
            'name' => $details['name'],
            'description' => $details['description'],
            'pricing_type' => 'fixed_price',
            'local_price' => [
                'amount' => $details['final2'],
                'currency' => 'USD'
            ],
            'metadata' => $details,
            'cancel_url' => route('pay.error'),
            'redirect_url' => route('coinbase.success'),
            // 'requested_info' => ['name', 'email']
        ];
        $response = $coinbase->createCharge($checkoutData);
        if ( isset($response['data']) ) {
            return response()->json([
                'status' => 'success',
                'gateway' => 'coinbase',
                'message' => 'Payment Link generated successfully',
                'link'  => $response['data']['hosted_url']
            ], 200);

        }else{
            return response()->json(['status' => 'error','message' => 'Payment was not successful'], 500);
        }
    }
    function coinbase_success(Request $request){
        $logFile = 'public/coinbase_log.txt';
        $logMessage = json_encode($request->all(), JSON_PRETTY_PRINT);
        file_put_contents($logFile, $logMessage, FILE_APPEND);

        $postdata    = $request->all();
        $headers     = apache_request_headers();
        $headers     = json_decode(json_encode($headers), true);
        $sentSign    = $headers['X-Cc-Webhook-Signature'];
        $sig         = hash_hmac('sha256', json_encode($postdata), env('COINBASE_SECRET'));

        if ($sentSign == $sig) {
            if ($postdata['event']['type'] == 'charge:confirmed') {
                // complete deposit
                // $details = $request->session()->get('payment_data');
                $details = $postdata['metadata'];
                $complete = new UserController();
                return $complete->complete_deposit($details, $postdata);
            }
        }
    }

    // Monnify Webhook
    function monnify_webhook(Request $request){
        // Save response to a text file
        $logFile = 'monnify_webhook_log.txt';
        $logMessage = json_encode($request->all(), JSON_PRETTY_PRINT);
        file_put_contents($logFile, $logMessage, FILE_APPEND);

        // VERIFY tRX
        $monnify = new Monnify();
        $input = $request->all();
        $data = [
			'paymentReference' => $input['eventData']['paymentReference']
		] ;
        $response = $monnify->verifyTransaction($data);

        if($response['responseMessage'] == 'success' && $response['responseBody']['paymentStatus'] == "PAID"){

            if($input['eventData']['paymentMethod'] == "ACCOUNT_TRANSFER"){
                // $details['amount'] = $input['eventData']['amountPaid'];
                $details['amount'] = $response['responseBody']['amountPaid'];
                $details['reference'] = $input['eventData']['product']['reference'];
                $details['final'] = $input['eventData']['settlementAmount'];
			    $details['trx'] = $input['eventData']['paymentReference'];

                $complete = new UserController();
                return $complete->complete_autodeposit($details, $response);
            }
            return "success";
        }
        return "error";
    }

    // binance payment
    function initBinance($details){
        $binance = new Binance();
        $data = [
            "env" => [
              "terminalType" => "APP"
            ],
            'returnUrl' => route('user.deposit'),
            'cancelUrl' => url()->previous(),
            'webhookUrl' => route('binance.webhook'),
            "merchantTradeNo" => $details['reference'],
            "fiatAmount" => $details['final2'],
            "fiatCurrency" => "USD",
            'description' => $details['description'],
            "goodsDetails" => [
              [
                "goodsType" => "02",
                "goodsCategory" => "Z000",
                "referenceGoodsId" => $details['reference'],
                "goodsName" => $details["name"],
                "goodsDetail" => $details['description']
              ]
            ]

        ];

        $response = $binance->createCharge($data);
        if ( isset($response['status']) && $response['status'] === "SUCCESS" && $response['code'] == "000000") {
            $send['redirect']     = true;
            $send['redirect_url'] = $response['data']['checkoutUrl'];
        }else{
            $send['redirect']     = false;
            session()->put('error','Payment was Not Successful');
            $send['redirect_url'] = route('user.deposit');
        }

        return $send;
    }
    function initBinanceApi($details){
        $binance = new Binance();
        $data = [
            "env" => [
              "terminalType" => "APP"
            ],
            'returnUrl' => route('pay.success'),
            'cancelUrl' => route('pay.error'),
            'webhookUrl' => route('binance.webhook'),
            "merchantTradeNo" => $details['reference'],
            "fiatAmount" => $details['final2'],
            "fiatCurrency" => "USD",
            'description' => $details['description'],
            "goodsDetails" => [
              [
                "goodsType" => "02",
                "goodsCategory" => "Z000",
                "referenceGoodsId" => $details['reference'],
                "goodsName" => $details["name"],
                "goodsDetail" => $details['description']
              ]
            ]

        ];

        $response = $binance->createCharge($data);
        if ( isset($response['status']) && $response['status'] === "SUCCESS" && $response['code'] == "000000") {
            return response()->json([
                'status' => 'success',
                'gateway' => 'binance',
                'message' => 'Payment Link generated successfully',
                'link'  => $response['data']['checkoutUrl']
            ], 200);
        }else{
            return response()->json(['status' => 'error','message' => 'Payment was not successful'], 500);
        }

    }
    function binance_webhook(Request $request){
        // save to file
        $logFile = 'public/binance_log.txt';
        $logMessage = json_encode($request->all(), JSON_PRETTY_PRINT);
        file_put_contents($logFile, $logMessage, FILE_APPEND);

        $response = $request->all();
        $type = $response['bizType'];
        $status = $response['bizStatus'];
        $data = json_decode($response['data']);
        $data->merchantTradeNo;
        if($status == "PAY_SUCCESS" && $type = "PAY"){
            // get details
            $deposit = Deposit::whereCode($data->merchantTradeNo)->first();
            if(!$deposit){
                return response()->json([
                    'status' => 'error',
                    'code' => 400,
                ], 400);
            }
            $user = $deposit->user;
            $details['amount'] = $deposit->amount;
            $details['final'] =  $deposit->final_amount;
            $details['final2'] =  round($details['final'] / get_setting('currency_rate'), 2);
            $details['name'] = $user->name();
            $details['user_id'] = $user->id;
            $details['deposit_id'] = $deposit->id;
            $details['phone'] = $user->phone;
            $details['description'] = $deposit->message;
            $details['gateway'] = $request->method;
            $details['email'] = $user->email;
            $details['reference'] = $deposit->code;
            $details1 = $request->session()->get('payment_data');
            $complete = new UserController();
            return $complete->complete_deposit($details, $response);

            return ['status' => 'success'];
        }
        return $request;
    }
}
