<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Deposit;
use App\Models\Faq;
use App\Models\PointLog;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Withdrawal;
use App\Utility\MonnifyUtility;
use Auth;
use Cache;
use Hash;
use Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Stevebauman\Purify\Facades\Purify;
use Str;

class UserController extends Controller
{
    protected $theme ;
    public function __construct()
    {
        switch (sys_setting('homepage_theme')) {
            case "theme1":
                $this->theme = "user.";
                break;
            case "theme2":
                $this->theme = "user.";
                break;
            case "theme3":
                $this->theme = "user3.";
                break;
            case "theme4":
                $this->theme = "user4.";
                break;
            default:
                $this->theme = "user.";
        }
    }
    //
    function index(Request $request){
        $trx = Transaction::whereUserId(auth()->id())->orderByDesc('id')->paginate(10);
        return view($this->theme.'index', compact('trx'));
    }

    public function logout() {
        auth()->logout();
        return redirect('/');
    }
    function profile(){
        $banks = file_get_contents(static_asset('banks.json')) ;
        $banks =  json_decode($banks);

        $monnify = new MonnifyUtility();
        $verifybanks = [];
        return view($this->theme.'profile', compact('verifybanks','banks'));
    }
    function update_profile(Request $request){
        $username = formatAndValidateUsername($request->username);
        if (!$username) {
            return back()->withInput()->withError('Invalid Username. Please change');
        }
        $request->validate([
            'fname' => 'required|string',
            'lname' => 'required|string',
            'phone' => 'required|string',
            'address' => 'nullable|string',
            'username' => 'required|string|unique:users,username,' . auth()->id() . '|max:25|regex:/\w*$/|alpha_dash'
        ]);
        // return $request;
        $user = Auth::user();
        $user->fname = $request->fname;
        $user->lname = $request->lname;
        $user->username = $username;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->save();
        return redirect()->back()->withSuccess('Profile updated successfully');
    }

    function generate_apikey(){
        $user = Auth::user();
        $user->api_token = generateToken();
        $user->save();

        return redirect()->back()->withSuccess('Api Token generated successfully.');
    }
    function update_password(Request $request){
        // return $request;
        $request->validate([
            'old_password' => 'required|string|min:5',
            'password' => 'required|string|min:5'
        ]);
        $user = Auth::User();
        // check if pssword matches
        if(Hash::check($request->old_password, $user->password)){
            $user->password = Hash::make($request->password);
            $user->save();
            return redirect()->back()->withSuccess('Password successfully changed');
        }
        return redirect()->back()->withError('Old Password is incorrect');
    }

    function verify_kyc(Request $request){
        // validate request
        // return $request;
        $request->validate([
            'verify_method' => 'required|string|in:nin,bvn',
        ]);
        $monnify = new MonnifyUtility();
        $user = Auth::user();
        if($request->verify_method == "nin"){
            $request->validate([
                'nin' => 'required|numeric|digits:11',
            ]);
        }else{
            $request->validate([
                'bvn' => 'required|numeric|digits:11',
                'bankCode' => 'required|string',
                'accountNumber' => 'required|digits:10',
            ]);
        }
        $price = 0;
        // if($price > $user->balance){
        //     return back()->withError("Insufficient Balance to validate BVN Details. Please fund your Wallet and try again");
        // }
        // $user->balance = $user->balance - $price;
        $user->bvn = $request->bvn;
        $user->nin = $request->nin;
        $user->verify_method = $request->verify_method;
        $user->save();
        // send request to monnify
        $verify = $monnify->verifyBvnAcc($request->all());
        $lm = json_encode($verify, JSON_PRETTY_PRINT);
        file_put_contents('public/test-monnify.txt', $lm, FILE_APPEND);
        if(isset($verify['responseMessage']) && $verify['responseMessage'] == "success"){
            $trans = new Transaction();
            $trans->user_id = $user->id;
            $trans->type = 1; // 1- credit, 2- deit, 3-others
            $trans->code = getTrx(14);
            $trans->message = "BVN Verification fee";
            $trans->amount = $price;
            $trans->status = 1;
            $trans->charge = 0;
            $trans->service = "kyc"; // bills
            $trans->old_balance = $user->balance - $price;
            $trans->new_balance = $user->balance;
            // $trans->save();
            $mp = $verify['responseBody']['matchPercentage'];
            if(!$mp){
                // refund user
                $user->balance += $price;
                $user->save();
                $trans->delete();
                $sts = 'error';
                $msg = "Unable to validate BVN. Please try again";
            }
            if($mp >= 50){
                $user->kyc_status = 1;
                $user->save();
                if($user->virtual_ref){
                    $data = [
                        'bvn' => $request->bvn,
                        // 'nin' => $request->nin
                    ];
                    $updatekyc = $monnify->updateCustomerKyc($user->virtual_ref, $data);
                    $lm = json_encode($updatekyc, JSON_PRETTY_PRINT);
                    file_put_contents('public/test-monnify.txt', $lm, FILE_APPEND);
                    if(isset($updatekyc['responseMessage']) && $updatekyc['responseMessage'] == "success"){
                        $user->kyc_status = 1;
                        $user->save();
                        $msg = "KYC Validated successfully";
                        return to_route('user.dashboard')->withSuccess($msg);
                    }else{
                        $user->kyc_status = 2;
                        $user->save();
                        $msg = "KYC Verification not successful. Please wait and try again";
                        $sts = 'error';
                    }
                }

            }else{
                // return error without refund
                $trans->save();
                $msg = "Unable to validate BVN. Please try again";
                $sts = 'error';
            }
        }else{
            // refund user
            $sts = 'error';
            $msg = "Unable to validate BVN. Please try again";
        }
        return back()->with($sts, $msg)->withInput();
        // send to monnify if user has virtual accounts
        if($user->virtual_ref){
            $data = [
                'bvn' => $request->bvn,
                // 'nin' => $request->nin
            ];
            $updatekyc = $monnify->updateCustomerKyc($user->virtual_ref, $data);
            if(isset($updatekyc['responseMessage']) && $updatekyc['responseMessage'] == "success"){
                $user->kyc_status = 1;
                $user->save();
                $msg = "KYC Validated successfully";
                return to_route('user.dashboard')->withSuccess($msg);
            }else{
                $user->kyc_status = 2;
                $user->save();
                $msg = "KYC Verification not successful. Please wait and try again";
                return to_route('user.dashboard')->withError($msg);
            }
        }else{
            $user->kyc_status = 1;
            $user->save();
            $msg = "KYC Validated successfully";
            return to_route('user.dashboard')->withSuccess($msg);
        }
    }
    // generate account
    function generate_account(Request $request){
        $user = Auth::user();
        if(Auth::user()->virtual_ref == null){
            try {
                $this->generate_bank();

            } catch (\Exception $e) {
            // dd($e);
                return redirect()->back()->withError('Virtual Account not Generated. Please Try again');
            }
        }

        return redirect()->back()->withSuccess('Account number was Generated Successfully.');

    }

    function generate_bank()
    {
        $user = Auth::user();
        $monnify = new MonnifyUtility();
        $data = [
            'bvn' => $user['bvn'],
            'email' => $user['email'],
            'name' => $user->name(),
            'currency' =>get_setting('currency_code'),
            'reference' => \getTrx(8).$user['username']
        ];
        $response = $monnify->reserveAccount($data);
        if($response['responseMessage'] == 'success'){
            $banks = $response['responseBody']['accounts'];
            $user->virtual_ref = $data['reference'];
            $user->virtual_banks = $banks;
            $user->save();
        }else{
            return;
        }
        // return redirect()->route('user.wallet')->withSuccess('Virtual Account Generated');
    }

    function deposit(){
        $deposits = Deposit::whereUserId(auth()->id())->orderByDesc('id')->paginate(20);
        $banks = Auth::user()->virtual_banks;
        $banks = \json_decode($banks);

        $monnify = new MonnifyUtility();
        $verifybanks = Cache::get('monnify_banks') ?? [];

        return view($this->theme.'deposit', compact('deposits','banks','verifybanks'));
    }

    function deposit_money(Request $request){
        $req = Purify::clean($request->all());
        $validator = Validator::make($req, [
            'amount' => 'required|numeric|min:'.sys_setting('min_deposit'),
            'method' => 'required|in:paystack,flutterwave,paypal,monnify,coinbase,perfect,bank,binance',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $user = Auth::user();
        if($request->method == "bank"){
            $charge = sys_setting('bank_fee');
        }else{
            $charge = (sys_setting('deposit_fee')* $request->amount )/100;
        }
        // create deposit trx
        $deposit = new Deposit();
        $deposit->user_id = Auth::id();
        $deposit->type = 'card'; // 1- event, 2- form, 3-vote
        $deposit->code = getTrx();
        $deposit->message = 'Wallet deposit funding';
        $deposit->gateway = $request->method;
        $deposit->amount = $request->amount;
        $deposit->charge = $charge;
        $deposit->final_amount = $charge + $request->amount;
        $deposit->status = 3;
        $deposit->save();
        // payment details
        $details['amount'] = $deposit->amount;
        $details['final'] =  $charge + $deposit->amount;
        $details['final2'] =  round($details['final'] / get_setting('currency_rate'), 2);
        $details['name'] = $user->name();
        $details['user_id'] = $user->id;
        $details['deposit_id'] = $deposit->id;
        $details['phone'] = $user->phone;
        $details['description'] = $deposit->message;
        $details['gateway'] = $request->method;
        $details['email'] = $user->email;
        $details['reference'] = $deposit->code;

        $request->session()->put('payment_data', $details);
        $request->session()->put('redirect_from', 'website');

        // return $details;
        if($request->method == "flutterwave"){
            return view('payments.flutterwave', compact('details'));
        }elseif($request->method == "paystack"){
            return view('payments.paystack', compact('details'));
        }elseif($request->method == "monnify"){
            return view('payments.monnify', compact('details'));
        }elseif($request->method == "paypal"){
            return view('payments.paypal', compact('details'));
        }elseif($request->method == "perfect"){
            $c = new PaymentController;
            $data = $c->initPerfectMoney($details);
            return view('payments.perfect-money', compact('details','data'));
        }elseif($request->method == 'coinbase'){
            $c = new PaymentController;
            $data = $c->initCoinbase($details);
            if($data['redirect'] == true){
                return view('payments.coinbase', compact('details','data'));
            }else{
                return redirect($data['redirect_url'])->withError('Payment was not successful');
            }
        }elseif($request->method == "bank"){
            return view('payments.bank', compact('details'));
        }elseif($request->method == 'binance'){
            $c = new PaymentController;
             $data = $c->initBinance($details);
            if($data['redirect'] == true){
                return view('payments.binance', compact('details','data'));
            }else{
                return redirect($data['redirect_url'])->withError('Payment was not successful');
            }
        }

        return back()->withError('Something went wrong');
    }

    function complete_deposit($details, $response = null){
        $rf = session()->get('redirect_from');
        $user = User::findOrFail($details['user_id']);
        $deposit = Deposit::whereCode($details['reference'])->first();
        if($deposit != null & $deposit->status != 1){
            $deposit->message = "You have successfully fund your wallet with ".format_price($deposit['amount']);
            $deposit->response = json_encode($response);
            $deposit->status = 1;
            $deposit->save();
            // create transaction
            $trans = new Transaction();
            $trans->user_id = $user->id;
            $trans->type = 1; // 1- credit, 2- debit, 3-others
            $trans->code = $deposit->code;
            $trans->message = $deposit->message;
            $trans->amount =$deposit['amount'];
            $trans->status = 1;
            $trans->charge = $deposit->charge;
            $trans->service = "deposit";
            $trans->response = json_encode($response);
            $trans->old_balance = $user->balance;
            $trans->new_balance = $user->balance + $deposit['amount'];
            $trans->save();
            // Add User Balance
            $user->balance =  $trans['new_balance'];
            $user->save();
            // send email
            $e_mess = "Hi {$user->username}, <br> A credit transaction  of <b>".format_price($trans->amount)."<b> occured on your Account.
            <br> <p> See Below for details of Transactions. </p>
                Amount : ".format_price($trans->amount) ."<br> Details: {$trans->message} <br> Reference : {$trans->code} <br> Balance: ".format_price($user->balance)."<br> Date : ".show_datetime($trans->created_at);
            general_email($user->email, 'Credit Alert',$e_mess );
            // give bonus
            give_deposit_bonus($user->id, $deposit->gateway, $deposit->amount);
            session()->remove('payment_data');
            if (request()->expectsJson()) {
                return response()->json(['success' => 'Payment Was successful'], 200);
            }
            if (Auth::guest() && $rf != "website") {
                //redirect to payment success page
                return to_route('pay.success')->withSuccess($deposit->message);
            }
            return redirect()->route('user.deposit')->withSuccess('Payment was successful');
        }

        // $deposit->status = 3;
        $deposit->save();
        if (request()->expectsJson()) {
            return response()->json(['success' => 'Payment Was successful'], 200);
        }
        if (Auth::guest() && $rf != "website") {
            //redirect to payment success page
            return to_route('pay.error')->withError("Payment has already been processed");
        }
        return redirect()->route('user.deposit')->withSuccess('Payment was successful');
    }

    function complete_autodeposit($details, $response = null){
        $user = User::where('virtual_ref', $details['reference'])->first();

        if($user == null){
            return 'wrong user';
        }

        // check if deposit doesnt exist
        $cdeposit = Deposit::whereTrx($details['trx'])->first();
        if($cdeposit && $cdeposit->status == 1){
            return "duplicate ";
        }

        $fee = sys_setting('auto_fee');
        $charge = ($fee * $details['amount'])/100;
        if($charge > sys_setting('auto_cap')){
            $charge = sys_setting('auto_cap');
        }

        $messg = "You have successfully fund your wallet with ".format_price($details['amount']);
        // save to deposit
        $deposit = new Deposit();
        $deposit->user_id = $user->id;
        $deposit->type = 'transfer'; // 1- event, 2- form, 3-vote
        $deposit->gateway = "bank";
        $deposit->code = \getTrx();
        $deposit->trx = $details['trx'];
        $deposit->message = $messg;
        $deposit->amount = $details['amount'] - $charge;
        $deposit->charge = $charge;
        $deposit->final_amount =  $details['amount'] ;
        $deposit->status = 1;
        $deposit->response = json_encode($response);
        $deposit->save();

        // create transaction
        $trans = new Transaction();
        $trans->user_id = $user->id;
        $trans->type = 1; // 1- credit, 2- debit, 3-others
        $trans->code = $deposit->code;
        $trans->message = $deposit->message;
        $trans->amount =$deposit['amount'];
        $trans->status = 1;
        $trans->charge = $deposit->charge;
        $trans->service = "deposit";
        $trans->response = json_encode($response);
        $trans->old_balance = $user->balance;
        $trans->new_balance = $user->balance + $deposit['amount'];
        $trans->save();
        // Add User Balance
        $user->balance =  $trans['new_balance'];
        $user->save();
        // send email
        $e_mess = "Hi {$user->username}, <br> A credit transaction  of <b>".format_price($trans->amount)."<b> occured on your Account.
        <br> <p> See Below for details of Transactions. </p>
            Amount : ".format_price($trans->amount) ."<br> Details: {$trans->message} <br> Reference : {$trans->code} <br> Balance: ".format_price($user->balance)."<br> Date : ".show_datetime($trans->created_at);
        general_email($user->email, 'Credit Alert',$e_mess );
        // give bonus
        give_deposit_bonus($user->id, $deposit->gateway, $deposit->amount);

        return "success";
    }

    function manual_deposit(Request $request)
    {
        $details = $request->session()->get('payment_data');
        $request->validate([
            'document' => 'required|mimes:png,jpg,jpeg',
            'name' => 'required|string',
        ]);
        $deposit = Deposit::find($request->deposit_id);
        $deposit->name = $request->name;
        $deposit->type = "manual";
        // upload document
        if ($request->hasFile('document')){
            $document = $request->file('document');
            $name = Str::random(22).'.jpg';
            $document->move(public_path('uploads/payment'),$name);
            $deposit->image = "payment/".$name;
        }
        $deposit->status = 2;
        $deposit->save();
        return redirect()->route('user.deposit')->withSuccess("Your Payment has been submited. Wallet will be funded once your payment has been confirmed by the admin");
    }
    function transactions(Request $request){
        $search = null;
        $trx = Transaction::whereUserId(auth()->id())->orderByDesc('id')->paginate(50);
        if($request->has('search') ){
            $search = $request->search;
            $trx = Transaction::whereUserId(auth()->id())->search($request->search)->orderByDesc('id')->paginate(50);
        }
        return view($this->theme.'transaction', compact('trx','search'));
    }

    public function services(Request $request)
    {
        $categories = Category::has('services')->whereStatus(1)->orderBy('name','asc')->paginate(1000);
        if($request->has('search')){

        }
        return view($this->theme.'services', compact('request','categories'));
    }
    public function api_docs()
    {
        return view($this->theme.'apidocs');
    }

    public function affiliate()
    {
        $banks = file_get_contents(static_asset('banks.json')) ;
        $banks =  json_decode($banks);
        $payouts = Withdrawal::whereUserId(Auth::id())->whereType('bank')->whereService('referral')->get();
        return view($this->theme.'affiliate', compact('banks','payouts'));
    }

    function bank_account(Request $request){
        $request->validate([
            'bank_name' => 'string|required',
            'acc_name' => 'required|string',
        ]);
        $user = Auth::user();
        $user->bank_name = $request->bank_name;
        $user->acc_number =$request->acc_number;
        $user->acc_name = $request->acc_name;
        $user->save();

        return back()->withSuccess('Bank Account Saved Successfully');
    }

    function affiliate_withdraw (Request $request){
        $request->validate([
            'withdraw_type' => 'string|required',
            'amount' => 'required|integer|min:0',
        ]);
        $user = Auth::user();
        if ($user->bonus < $request->amount){
            return back()->with('error', 'You dont have enough funds in your referral bonus to withdraw');
        }
        if($request->withdraw_type == "wallet"){
            $user->bonus = $user->bonus - $request->amount;
            $user->balance = $user->balance + $request->amount;
            $user->save();

            $trans = new Transaction();
            $trans->user_id = $user->id;
            $trans->type = 1; // 1- credit, 2- deit, 3-others
            $trans->code = getTrx(14);
            $trans->message = "Your withdrawal of ".format_price($request->amount)." to main wallet was successful";
            $trans->amount = $request->amount;
            $trans->status = 1;
            $trans->charge = 0;
            $trans->service = "referral"; // bills
            $trans->old_balance = $user->balance - $request->amount;
            $trans->new_balance = $user->balance;
            $trans->save();
            // Withdrawal Trx
            $withdraw = new Withdrawal();
            $withdraw->old_balance = $trans->old_balance;
            $withdraw->new_balance = $trans->new_balance;
            $withdraw->amount = $request->amount;
            $withdraw->final = $request->amount;
            $withdraw->user_id = $user->id;
            $withdraw->code = $trans->code;
            $withdraw->status = 1;
            $withdraw->charge = 0;
            $withdraw->message = "Your withdrawal of ".format_price($request->amount)." to main wallet was successful";
            $withdraw->type = "wallet";
            $withdraw->save();
            $message = $trans->message;

        }elseif($request->withdraw_type == "bank"){
            if (sys_setting('min_withdraw') > $request->amount){
                return back()->with('error', 'You can not withdraw below the minimum withdrawal amount '.format_price(sys_setting('min_withdraw')));
            }

            if($user->acc_name == null || $user->acc_number == null || $user->bank_name == null){
                return back()->withError('Please Input your account Details Before you withdraw');
            }
            $user->bonus = $user->bonus - $request->amount;
            $user->save();

            $trans = new Transaction();
            $trans->user_id = $user->id;
            $trans->type = 2; // 1- credit, 2- deit, 3-others
            $trans->code = getTrx(14);
            $trans->message = "Referral bonus withdrawal to bank account";
            $trans->amount = $request->amount;
            $trans->status = 1;
            $trans->charge = 0;
            $trans->service = "referral"; // bills
            $trans->old_balance = $user->bonus + $request->amount;
            $trans->new_balance = $user->bonus;
            $trans->save();
            // Withdrawal Trx
            $withdraw = new Withdrawal();
            $withdraw->old_balance = $trans->old_balance;
            $withdraw->new_balance = $trans->new_balance;
            $withdraw->amount = $request->amount;
            $withdraw->charge = 0;
            $withdraw->final = $request->amount - $withdraw->charge;
            $withdraw->user_id = $user->id;
            $withdraw->code = $trans->code;
            $withdraw->status = 2;
            $withdraw->message = "Your withdrawal of ".format_price($request->amount)." is pending.";
            $withdraw->type = "bank";
            $withdraw->save();
            $message = 'Withdrawal has been placed successfully and your account would be credited soon';
        }
        return redirect()->back()->withSuccess( $message);
    }

    function point_withdraw (Request $request){
        $request->validate([
            'withdraw_type' => 'string|required',
            'points' => 'required|integer|min:'.sys_setting('point_minimum'),
        ]);
        $user = Auth::user();
        $pvalue = sys_setting('point_value');
        $prate = sys_setting('point_rate');
        $pcode = sys_setting('point_code');

        if ($user->points < $request->points){
            return back()->with('error', 'You dont have enough '.sys_setting('point_code').' points to withdraw');
        }

        if (sys_setting('point_withdraw') != 1) {
            return back()->with('error', 'Point withdrawal is currently disabled. Please try again');
        }
        $message = "Please select a wallet";
        $amount = $request->points * $prate;
        if($request->withdraw_type == "wallet"){
            $user->points -= $request->points;
            $user->balance = $user->balance + $amount;
            $user->save();

            $trans = new Transaction();
            $trans->user_id = $user->id;
            $trans->type = 1; // 1- credit, 2- deit, 3-others
            $trans->code = getTrx(14);
            $trans->message = "Your withdrawal of ".($request->points)." {$pcode} to main wallet was successful";
            $trans->amount = $amount;
            $trans->status = 1;
            $trans->charge = 0;
            $trans->service = "points"; // bills
            $trans->old_balance = $user->balance - $amount;
            $trans->new_balance = $user->balance;
            $trans->save();
            // save point logs
            $log = new PointLog ();
            $log->user_id = $user->id;
            $log->point = $request->points;
            $log->type = 'debit';
            $log->amount = $amount;
            $log->code = getTrx(14);
            $log->status = 1;
            $log->message = "{$request->points} {$pcode} converted to main wallet for spending ". format_price($amount);
            $log->save();

            $message = $trans->message;
        }
        return redirect()->back()->withSuccess( $message);
    }

    public function faq()
    {
        $faqs = Faq::whereStatus(1)->get();
        return view($this->theme.'faq', compact('faqs'));
    }

    public function terms()
    {
        return view($this->theme.'terms');
    }

    function close_message(){
        $user = Auth::user();
        $user->wm = 0;
        $user->save();
        return ['status' => 'success'];
    }


}
