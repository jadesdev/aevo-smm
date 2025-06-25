<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PaymentController;
use App\Models\DecoderTrx;
use App\Models\Deposit;
use App\Models\Listing;
use App\Models\ListingOffer;
use App\Models\NetworkTrx;
use App\Models\Order;
use App\Models\PowerTrx;
use App\Models\SupportTicket;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Withdrawal;
use App\Utility\MonnifyUtility;
use Auth;
use Cache;
use Hash;
use Illuminate\Http\Request;
use Purify;
use Str;
use Validator;

class UserController extends Controller
{
    //
    public function profile(Request $request)
    {
        $user = Auth::user();
        $user['first_name'] = ($user->fname);
        $user['last_name'] = ($user->lname);
        $user['kyc_status'] = ($user->kyc_status);
        $user['bankname'] = get_bank_name($user->bank_name);
        $user['virtual_banks'] = json_decode($user->virtual_banks);
        $user['profile_picture'] = my_asset($user->image);

        return response()->json([
            'status' => 'success',
            'message' => 'User Profile Fetched Successful',
            'user' => $user,
        ]);
    }
    public function balance(Request $request)
    {
        $user = Auth::user();
        return response()->json([
            'status' => 'success',
            'message' => 'User Balance Fetched Successful',
            'data' => [
                'balance' => $user->balance,
                'currency' => get_setting('currency_code'),
                'bonus' => $user->bonus,
            ],
        ]);
    }

    public function update_profile(Request $request)
    {
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'fname' => 'required|string|max:60',
            'lname' => 'required|string|max:60',
            'country' => 'nullable|string|max:50',
            'phone' => 'required|string|max:20|unique:users,phone,' . $user->id,
            'address' => 'nullable|string|max:250',
            'image' => 'nullable|image|mimes:jpg,png,svg,webp|max:10240',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
                'error' => $validator->errors()->all(),
            ], 422);
        }
        try {
            $user->fname = $request->fname;
            $user->lname = $request->lname;
            $user->address = $request->address;
            $user->country = $request->country;
            $user->phone = $request->phone;
            $user->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Profile Updated Successfully',
            ], 200);
        } catch (\Throwable $th) {
            // throw $th;
            return response()->json([
                'status' => 'error',
                'message' => 'Something went worng! Please try again',
            ], 400);
        }

        return $request;
    }

    public function update_profile_image(Request $request)
    {
        // validate  request
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpg,png,svg,webp|max:10240',
        ]);
        $user = Auth::user();
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = Str::random(23) . '.jpg';
            // if aws or local storage
            if ($user->image != null) {
                try {
                    unlink(public_path('uploads/' . $user->image));
                } catch (\Throwable $th) {
                    // throw $th;
                }
            }
            $image->move(public_path('uploads/user'), $imageName);
            $user->image = 'user/' . $imageName;
        } else {
            return response()->json([
                'status' => 'error',
                'message' => "Image wasn't uploaded. Please check and try again",
            ], 400);
        }
        $user->save();
        $user['first_name'] = ($user->fname);
        $user['last_name'] = ($user->lname);
        $user['kyc_status'] = ($user->kyc_status);
        $user['bankname'] = get_bank_name($user->bank_name);
        $user['virtual_banks'] = json_decode($user->virtual_banks);
        $user['profile_picture'] = my_asset($user->image);

        return response()->json([
            'status' => 'success',
            'message' => 'User Profile Updated Successful',
            'user' => $user,
        ]);
    }

    // Update password
    public function update_password(Request $request)
    {
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'old_password' => 'required|string|max:60',
            'new_password' => 'required|string|max:60',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
                'error' => $validator->errors()->all(),
            ], 422);
        }
        try {
            if (Hash::check($request->old_password, $user->password)) {
                $user->password = Hash::make($request->new_password);
                $user->save();

                return response()->json([
                    'status' => 'success',
                    'message' => 'Password Changed Successfully',
                ], 200);
            }

            return response()->json(['status' => 'error', 'message' => 'Old Password is incorrect'], 400);
        } catch (\Throwable $th) {
            // throw $th;
            return response()->json([
                'status' => 'error',
                'message' => 'Something went worng! Please try again',
            ], 400);
        }

        return $request;
    }

    public function banks(Request $request)
    {
        $monnify = new MonnifyUtility;
        $verifybanks = Cache::get('monnify_banks');
        if (! $verifybanks) {
            $verifybanks = $monnify->getBanks()['responseBody'] ?? [];
            Cache::put('monnify_banks', $verifybanks, 86400);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Bank codes fetched successfully',
            'data' => $verifybanks,
        ]);
    }

    // KYC
    public function verify_Kyc(Request $request)
    {
        $user = Auth::user();
        $monnify = new MonnifyUtility;
        $request->validate([
            'bvn' => 'required|numeric|digits:11',
            'bankCode' => 'required|string',
            'accountNumber' => 'required|digits:10',
        ]);
        $price = 10;
        if ($price > $user->balance) {
            return response()->json([
                'status' => 'error',
                'message' => 'Insufficient Balance to validate BVN Details. Please fund your Wallet and try again. User Profile Fetched Successful',
            ]);
        }
        $user->balance = $user->balance - $price;
        $user->bvn = $request->bvn;
        $user->verify_method = 'bvn';
        $user->save();
        // send request to monnify
        $verify = $monnify->verifyBvnAcc($request->all());
        $lm = json_encode($verify, JSON_PRETTY_PRINT);
        if (isset($verify['responseMessage']) && $verify['responseMessage'] == 'success') {
            $trans = new Transaction;
            $trans->user_id = $user->id;
            $trans->type = 1; // 1- credit, 2- deit, 3-others
            $trans->code = getTrx(14);
            $trans->message = 'BVN Verification fee';
            $trans->amount = $price;
            $trans->status = 1;
            $trans->charge = 0;
            $trans->service = 'kyc'; // bills
            $trans->old_balance = $user->balance - $price;
            $trans->new_balance = $user->balance;
            $trans->save();
            $mp = $verify['responseBody']['matchPercentage'];
            if (! $mp) {
                // refund user
                $user->balance += $price;
                $user->save();
                $trans->delete();
                $sts = 'error';
                $msg = 'Unable to validate BVN. Please try again';
            }
            if ($mp >= 50) {
                $user->kyc_status = 1;
                $user->save();
                if ($user->virtual_ref) {
                    $data = [
                        'bvn' => $request->bvn,
                        // 'nin' => $request->nin
                    ];
                    $updatekyc = $monnify->updateCustomerKyc($user->virtual_ref, $data);
                    $lm = json_encode($updatekyc, JSON_PRETTY_PRINT);
                    // file_put_contents('public/test-monnify.txt', $lm, FILE_APPEND);
                    if (isset($updatekyc['responseMessage']) && $updatekyc['responseMessage'] == 'success') {
                        $user->kyc_status = 1;
                        $user->save();
                        $msg = 'KYC Validated successfully';

                        return response()->json([
                            'status' => 'success',
                            'message' => $msg,
                        ]);
                    } else {
                        $user->kyc_status = 2;
                        $user->save();
                        $msg = 'KYC Verification not successful. Please wait and try again';
                        $sts = 'error';
                    }
                }
            } else {
                // return error without refund
                $trans->save();
                $msg = 'Unable to validate BVN. Please try again';
                $sts = 'error';
            }
        } else {
            // refund user
            $user->balance += $price;
            $user->save();
            $sts = 'error';
            $msg = 'Unable to validate BVN. Please try again';
        }

        return response()->json([
            'status' => $sts ?? 'error',
            'message' => $msg,
        ]);
    }

    // Generate bank accounts
    public function generate_account(Request $request)
    {
        $user = Auth::user();
        if (Auth::user()->virtual_ref == null) {
            $monnify = new MonnifyUtility;
            $data = [
                'email' => $user['email'],
                'name' => $user->name(),
                'currency' => get_setting('currency_code'),
                'reference' => \getTrx(8) . $user['username'],
            ];
            $response = $monnify->reserveAccount($data);
            if ($response['responseMessage'] == 'success') {
                $banks = $response['responseBody']['accounts'];
                $user->virtual_ref = $data['reference'];
                $user->virtual_banks = $banks;
                $user->save();
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Virtual Accounts not created! Please try again',
                ], 400);
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Accounts Generated Successfully',
            'data' => json_decode($user->virtual_banks),
        ], 200);
    }

    // Logout
    public function logout()
    {
        Auth::user()->tokens()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

    // Transactions
    public function transactions(Request $request)
    {

        $query = Transaction::whereUserId(auth()->id())->orderByDesc('id');
        if ($request->has('search')) {
            $query = Transaction::whereUserId(auth()->id())->search($request->search)->orderByDesc('id');
        }
        $pp = 10;
        $page = $request->input('page', 1);

        // Paginate the query directly
        $result = $query->paginate($pp, ['*'], 'page', $page);

        return [

            'status' => 'success',
            'message' => 'Transactions fetched successfully',
            'data' => $result->items(),
            'total' => $result->total(),
            'current_page' => $result->currentPage(),
            'previous_page' => $result->previousPageUrl(),
            'next_page' => $result->nextPageUrl(),
            'last_page' => $result->lastPage(),
        ];
    }

    // Make Deposit
    public function makeDeposit(Request $request)
    {
        $req = Purify::clean($request->all());
        $validator = Validator::make($req, [
            'amount' => 'required|numeric|min:' . sys_setting('min_deposit'),
            'method' => 'required|in:flutterwave,coinbase,perfect,binance,heleket,moorle',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
                'error' => $validator->errors()->all(),
            ], 422);
        }
        $user = Auth::user();
        if ($request->method == 'bank') {
            $charge = sys_setting('bank_fee');
        } else {
            $charge = (sys_setting('deposit_fee') * $request->amount) / 100;
        }
        $deposit = new Deposit;
        $deposit->user_id = $user->id;
        $deposit->type = 'card'; // 1- event, 2- form, 3-vote
        $deposit->code = getTrx();
        $deposit->message = 'Wallet deposit funding of ' . format_price($request->amount);
        $deposit->gateway = $request->method;
        $deposit->amount = $request->amount;
        $deposit->charge = $charge;
        $deposit->final_amount = $charge + $request->amount;
        $deposit->status = 3;
        $deposit->save();
        // payment details
        $details['amount'] = $deposit->amount;
        $details['final'] = $charge + $deposit->amount;
        $details['final2'] = round($details['final'] / get_setting('currency_rate'), 2);
        $details['name'] = $user->name();
        $details['user_id'] = $user->id;
        $details['deposit_id'] = $deposit->id;
        $details['phone'] = $user->phone;
        $details['description'] = $deposit->message;
        $details['gateway'] = $request->method;
        $details['email'] = $user->email;
        $details['reference'] = $deposit->code;

        // redirect to payment gateway
        $c = new PaymentController;
        if ($request->method == 'flutterwave') {
            return $data = $c->initFlutterApi($details);
        } elseif ($request->method == 'perfect') {
            return $data = $c->initPerfectMoneyApi($details);
        } elseif ($request->method == 'coinbase') {
            return $data = $c->initCoinbaseApi($details);
        } elseif ($request->method == 'binance') {
            return $data = $c->initBinanceApi($details);
        } elseif ($request->method == 'heleket') {
            return $data = $c->initHeleket($details);
        } elseif ($request->method == 'moorle') {
            return $data = $c->initMoorle($details);
        }

        $deposit->delete();

        return response()->json([
            'status' => 'error',
            'message' => 'Payment was not successful. Please try again',
        ]);
    }

    // Deposits
    public function deposits(Request $request)
    {

        $query = Deposit::whereUserId(auth()->id())->orderByDesc('id')->whereStatus(1);
        if ($request->has('search')) {
            $query = Deposit::whereUserId(auth()->id())->search($request->search)->orderByDesc('id');
        }
        $pp = 10;
        $page = $request->input('page', 1);

        // Paginate the query directly
        $result = $query->paginate($pp, ['*'], 'page', $page);

        return [

            'status' => 'success',
            'message' => 'Deposits fetched successfully',
            'data' => $result->items(),
            'total' => $result->total(),
            'current_page' => $result->currentPage(),
            'previous_page' => $result->previousPageUrl(),
            'next_page' => $result->nextPageUrl(),
            'last_page' => $result->lastPage(),
        ];
    }

    // Referrals
    public function referrals(Request $request)
    {
        $query = User::whereRefId(auth()->id())->orderByDesc('id')->whereStatus(1);
        if ($request->has('search')) {
            $query = User::whereRefId(auth()->id())->searchUser($request->search)->orderByDesc('id');
        }
        $pp = 20;
        $page = $request->input('page', 1);

        // Paginate the query directly
        $result = $query->paginate($pp, ['*'], 'page', $page);

        return [

            'status' => 'success',
            'message' => 'Referral fetched successfully',
            'data' => $result->items(),
            'total' => $result->total(),
            'current_page' => $result->currentPage(),
            'previous_page' => $result->previousPageUrl(),
            'next_page' => $result->nextPageUrl(),
            'last_page' => $result->lastPage(),
        ];
    }

    // Delete user account
    public function deleteAccount(Request $request)
    {
        $user = Auth::user();
        // delete deposits
        $dpt = Deposit::whereUserId($user->id)->get();
        $dpt->each(function ($tx) {
            $tx->forceDelete();
        });
        // delete tickets
        $sp = SupportTicket::whereUserId($user->id)->get();
        $sp->each(function ($tx) {
            // delete ticket comments
            $tx->comments()->forceDelete();
            $tx->forceDelete();
        });
        // delete transactions
        $trx = Transaction::whereUserId($user->id)->get();
        $trx->each(function ($tx) {
            $tx->forceDelete();
        });
        // delete orders
        $ord = Order::whereUserId($user->id)->get();
        $ord->each(function ($tx) {
            $tx->forceDelete();
        });
        // delete withdrawals
        $wdt = Withdrawal::whereUserId($user->id)->get();
        $wdt->each(function ($tx) {
            $tx->delete();
        });
        // delete offers
        $odt = ListingOffer::whereUserId($user->id)->get();
        $odt->each(function ($tx) {
            $tx->delete();
        });
        // delete Listings
        $ldt = Listing::whereUserId($user->id)->get();
        $ldt->each(function ($tx) {
            // comments
            $tx->comments()->delete();
            $tx->transactions()->delete();
            $tx->delete();
        });
        // network trx
        $ntx = NetworkTrx::whereUserId($user->id)->get();
        $ntx->each(function ($tx) {
            $tx->forceDelete();
        });
        // Decoder trx
        $dctx = DecoderTrx::whereUserId($user->id)->get();
        $dctx->each(function ($tx) {
            $tx->forceDelete();
        });
        // Power trx
        $ptx = PowerTrx::whereUserId($user->id)->get();
        $ptx->each(function ($tx) {
            $tx->delete();
        });

        // log user out
        // $user->tokens()->delete();
        // delete main user
        $user->delete();

        // auth()->logout();
        return response()->json([
            'status' => 'success',
            'message' => 'User Account Deleted successfully',
        ]);
    }
}
