<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\ListingComment;
use App\Models\ListingOffer;
use App\Models\ListTrx;
use App\Models\Transaction;
use App\Models\Withdrawal;
use App\Utility\MonnifyUtility;
use Auth;
use DB;
use Illuminate\Http\Request;
use Stevebauman\Purify\Facades\Purify;
use Str;

class DealController extends Controller
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

    public function index(Request $request)
    {
        $query = Listing::whereStatus(1)->where('sold', '!=', 1)->orderByDesc('id');

        if ($request->has('category')) {

            if ($request->category == '') {
                $query = $query;
            } else {
                $query = $query->whereAccountType($request->category);
            }
        }
        if ($request->has('search')) {
            $search = $request->search;
            if ($request->search == '') {
                $query = $query;
            } else {
                $query = $query->search($search);
            }
        }

        $listings = $query->paginate(24);

        return view($this->theme.'deals.index', compact('listings'));
    }

    //
    public function add()
    {
        return view($this->theme.'deals.add');
    }

    public function wallet()
    {
        $banks = file_get_contents(static_asset('banks.json'));
        $banks = json_decode($banks);
        $payouts = Withdrawal::whereUserId(Auth::id())->whereType('bank')->whereService('listing')->get();

        return view($this->theme.'deals.wallet', compact('banks', 'payouts'));
    }

    public function view($slug)
    {
        $listing = Listing::findOrfail($slug);
        if ($listing->status != 1) {
            abort(404);
        }
        $similar = Listing::whereAccountType($listing->account_type)->where('id', '!=', $listing->id)->whereStatus(1)->whereSold(2)->limit(4)->get();

        return view($this->theme.'deals.view', compact('listing', 'similar'));
    }

    public function my_deals()
    {
        $listings = Listing::whereUserId(Auth::id())->get();
        $type = 'index';

        return view($this->theme.'deals.deals', compact('type', 'listings'));
    }

    public function account_details($id)
    {
        $listing = Listing::where('user_id', Auth::id())->whereId($id)->first();
        if (! $listing) {
            return back()->withError('You do not have permission to view this account.');
        }
        $trx = $listing->transaction;

        return view($this->theme.'deals.seller.view_offer', compact('listing', 'trx'));
    }

    public function edit($id)
    {
        $listing = Listing::findOrfail($id);
        if ($listing->user_id != Auth::id()) {
            return back()->withError('You do not have permission to modify this Listing');
        }
        if ($listing->sold == 1) {
            return back()->withError('Product has been sold. You cannot edit it.');
        }

        return view($this->theme.'deals.seller.edit', compact('listing'));

    }

    public function deals_offer($id)
    {
        $listing = Listing::findOrfail($id);
        if ($listing->user_id != Auth::id()) {
            return back()->withError('You do not have permission to modify this Listing');
        }
        $offers = $listing->offers;

        return view($this->theme.'deals.seller.offers', compact('offers', 'listing'));

    }

    public function my_offers(Request $request)
    {
        $listings = ListingOffer::where('user_id', Auth::id())->with('listing')->get();

        return view($this->theme.'deals.myoffers', compact('listings'));
    }

    // Bought accounts
    public function my_accounts(Request $request)
    {
        $listings = ListTrx::where('buyer_id', Auth::id())->wherePaid(1)->orderByDesc('id')->with('listing')->get();

        return view($this->theme.'deals.myoffers', compact('listings'));
    }

    public function view_account($id)
    {
        $trx = ListTrx::where('buyer_id', Auth::id())->whereId($id)->first();
        if (! $trx) {
            return back()->withError('You do not have permission to view this account.');
        }
        if ($trx->status != 1 || $trx->paid != 1) {
            return back()->withError('Your do not have permission to view this account. ');
        }
        $listing = $trx->listing;

        return view($this->theme.'deals.account', compact('listing', 'trx'));
    }

    public function view_offer($id)
    {
        $offer = ListingOffer::where('user_id', Auth::id())->whereId($id)->first();
        if (! $offer) {
            return back()->withError('You do not have permission to modify this offer');
        }
        if ($offer->status != 'accepted') {
            return back()->withError("Your offer wasn't accepted. ");
        }
        $listing = $offer->listing;
        $trx = $offer->transaction;

        return view($this->theme.'deals.view_offer', compact('offer', 'listing', 'trx'));
    }

    public function seller_view_offer($id)
    {
        $offer = ListingOffer::where('seller_id', Auth::id())->whereId($id)->first();
        if (! $offer) {
            return back()->withError('You do not have permission to modify this offer');
        }
        $listing = $offer->listing;
        $trx = $offer->transaction;

        return view($this->theme.'deals.seller.view_offer', compact('offer', 'listing', 'trx'));
    }

    public function reject_offer($id)
    {
        $offer = ListingOffer::where('seller_id', Auth::id())->whereId($id)->first();
        if (! $offer) {
            return back()->withError('You do not have permission to modify this offer');
        }
        $offer->status = 'rejected';
        $offer->save();

        return back()->withSuccess('Offer Rejected Successfully');
    }

    public function accept_offer($id)
    {
        $offer = ListingOffer::where('seller_id', Auth::id())->whereId($id)->first();
        if (! $offer) {
            return back()->withError('You do not have permission to modify this offer');
        }
        $listing = $offer->listing;
        // set other offers status as rejected
        DB::beginTransaction();

        try {
            // Set other offers' status as rejected
            $listing->offers()->where('id', '<>', $offer->id)->update(['status' => 'rejected']);

            // Set the accepted offer's status as accepted
            $offer->status = 'accepted';
            $offer->save();

            $listing->status = 3;
            $listing->save();

            // Commit the transaction
            DB::commit();

            $seller = $listing->user;
            // create listing trx
            $trx = new ListTrx;
            $trx->code = getTrx();
            $trx->buyer_id = $offer->user->id;
            $trx->seller_id = $seller->id;
            $trx->offer_id = $offer->id;
            $trx->listing_id = $listing->id;
            $trx->status = 2;
            $trx->amount = $offer->amount;
            $trx->save();
            // send email to buyer that deal has been approved

            return back()->withSuccess('Offer Accepted Successfully');
        } catch (\Exception $e) {
            // An error occurred, rollback the transaction
            DB::rollBack();

            return back()->withError('Error accepting offer. Please try again.');
        }

    }

    // ADd Listings
    public function create(Request $request)
    {
        // validate request
        $req = $this->validate($request, [
            'name' => 'required|string|max:255',
            'account_type' => 'required|string',
            'follower_type' => 'required|string',
            'link' => 'required|url',
            'followers' => 'required|integer|min:0',
            'followings' => 'required|integer|min:0',
            'age' => 'required|string',
            'about' => 'required|string|max:500',
            'price' => 'required|numeric|min:0',
            'username' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string',
            'mobile' => 'required|string|min:8',
            'other_info' => 'nullable|string',
            'preview' => 'required|image|max:4048',
        ]);
        $input = Purify::clean($req);
        // upload image
        if ($request->hasFile('preview')) {
            $image = $request->file('preview');
            $imageName = 'listings-'.Str::random(15).'.'.$image->getClientOriginalExtension();

            $image->move(public_path('uploads/listings'), $imageName);
            $input['preview'] = 'listings/'.$imageName;
        }
        if ($request->hasFile('image1')) {
            $image = $request->file('image1');
            $imageName = 'listings-'.Str::random(14).'.'.$image->getClientOriginalExtension();

            $image->move(public_path('uploads/listings'), $imageName);
            $input['image1'] = 'listings/'.$imageName;
        }
        if ($request->hasFile('image2')) {
            $image = $request->file('image2');
            $imageName = 'listings-'.Str::random(16).'.'.$image->getClientOriginalExtension();

            $image->move(public_path('uploads/listings'), $imageName);
            $input['image2'] = 'listings/'.$imageName;
        }
        $input['user_id'] = Auth::id();
        $input['slug'] = uniqueSlug($input['name'], 'listings');
        $input['amount'] = $input['price'];
        $input['status'] = 2; // set as pending
        $data = Listing::create($input);

        return redirect()->route('user.listings.deals')->withSuccess('Listings added successfully');
    }

    // update
    public function update($id, Request $request)
    {
        // validate request
        $req = $this->validate($request, [
            'name' => 'required|string|max:255',
            'link' => 'required|url',
            'follower_type' => 'required|string',
            'followers' => 'required|integer|min:0',
            'followings' => 'required|integer|min:0',
            'age' => 'required|string',
            'about' => 'required|string|max:500',
            'price' => 'required|numeric|min:0',
            'username' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string',
            'mobile' => 'required|string|min:8',
            'other_info' => 'nullable|string',
            'preview' => 'nullable|image|max:4048',
        ]);
        $input = Purify::clean($req);
        $listing = Listing::findOrfail($id);
        if ($listing->user_id != Auth::id()) {
            return back()->withError('You do not have permission to modify this Listing');
        }
        // upload image
        if ($request->hasFile('preview')) {
            $image = $request->file('preview');
            $imageName = 'listings-'.Str::random(15).'.'.$image->getClientOriginalExtension();
            // delete old image?
            if ($listing->preview != null) {
                try {
                    unlink(public_path('uploads/'.$listing->preview));
                } catch (\Throwable $th) {
                    // throw $th;
                }
            }
            $image->move(public_path('uploads/listings'), $imageName);
            $input['preview'] = 'listings/'.$imageName;
        }
        if ($request->hasFile('image1')) {
            $image = $request->file('image1');
            $imageName = 'listings-'.Str::random(14).'.'.$image->getClientOriginalExtension();
            // delete old image?
            if ($listing->image1 != null) {
                try {
                    unlink(public_path('uploads/'.$listing->image1));
                } catch (\Throwable $th) {
                    // throw $th;
                }
            }
            $image->move(public_path('uploads/listings'), $imageName);
            $input['image1'] = 'listings/'.$imageName;
        }
        if ($request->hasFile('image2')) {
            $image = $request->file('image2');
            $imageName = 'listings-'.Str::random(16).'.'.$image->getClientOriginalExtension();
            // delete old image?
            if ($listing->image2 != null) {
                try {
                    unlink(public_path('uploads/'.$listing->image2));
                } catch (\Throwable $th) {
                    // throw $th;
                }
            }

            $image->move(public_path('uploads/listings'), $imageName);
            $input['image2'] = 'listings/'.$imageName;
        }
        $input['user_id'] = Auth::id();
        $input['amount'] = $request->price;
        $input['status'] = 2; // set as pending
        $data = $listing->update($input);

        return redirect()->route('user.listings.deals')->withSuccess('Listings updated successfully');
    }

    public function buy_now(Request $request)
    {
        $request->validate([
            'listing' => 'required|numeric|exists:listings,id',
            'payment_method' => 'required|string|in:wallet,gateway',
        ]);
        $listing = Listing::findOrFail($request->listing);
        $user = Auth::user();
        // check if deals hasn't been completed
        if ($listing->sold == 1) {
            return back()->withError('Listing has already been sold.');
        }
        if ($listing->user_id == $user->id) {
            return back()->withError('You can not buy your own account.');
        }
        $seller = $listing->user;
        $amount = $listing->amount;
        if ($request->payment_method == 'wallet') {
            // deduct from balance
            if ($user->balance < $amount) {
                return back()->with('error', 'You dont have enough funds in your wallet to complete this transaction '.format_price($user->balance))->withInput();
            }
            // List trx
            $trx = new ListTrx;
            $trx->code = getTrx();
            $trx->buyer_id = $user->id;
            $trx->seller_id = $seller->id;
            $trx->offer_id = 0;
            $trx->listing_id = $listing->id;
            $trx->paid = 1;
            $trx->status = 1;
            $trx->date = now();
            $trx->amount = $amount;
            $trx->save();
            // deduct balance and create transaction
            $user->balance -= $amount;
            $user->save();
            // debit transaction
            $trans = new Transaction;
            $trans->user_id = $user->id;
            $trans->type = 2; // 1- credit, 2- debit, 3-others
            $trans->code = $trx->code;
            $trans->message = "Payment for buying {$listing->name}";
            $trans->amount = $amount;
            $trans->status = 1;
            $trans->charge = 0;
            $trans->service = 'listing';
            $trans->response = '';
            $trans->new_balance = $user->balance;
            $trans->old_balance = $user->balance + $amount;
            $trans->save();
            // set listing as sold
            $listing->sold = 1;
            $listing->save();
            // credit seller
            $rate = sys_setting('seller_rate') ?? '10';
            $fee = ($rate / 100) * $amount;
            $final_amount = round($amount - $fee, 2);
            // send email notification to seller
            $subj = "Your Listing - {$listing->name} was purchased successfully.";
            $e_mess = 'A Credit Transaction of <b>'.format_price($final_amount).'</b> occured on your Account.
                <br> <p> See Below for details of Transactions. </p>
                    Amount : '.format_price($final_amount)."<br> Details: Payment for completing a Listing deal - {$listing->name} <br> Balance: ".format_price($seller->deal_wallet).'<br> Date : '.show_datetime(now());
            general_email($seller->email, $subj, $e_mess);

            return to_route('user.listings.my_account')->withSuccess('Account Purchased successfully');
        } elseif ($request->payment_method == 'gateway') {
            // List trx
            $trx = new ListTrx;
            $trx->code = getTrx();
            $trx->buyer_id = $user->id;
            $trx->seller_id = $seller->id;
            $trx->offer_id = 0;
            $trx->listing_id = $listing->id;
            $trx->paid = 0;
            $trx->status = 2;
            $trx->amount = $amount;
            $trx->save();

            $data['seller_id'] = $seller->id;
            $data['listing_id'] = $listing->id;
            $data['amount'] = $listing->amount;
            $data['email'] = $user->email;
            $data['user_id'] = $user->id;
            $data['message'] = "Payment for {$listing->name}";
            $data['code'] = $trx->code;
            $data['trx_type'] = 'listing';
            // create trx

            $request->session()->put('listings_payment_data', $data);
            $monnify = new MonnifyUtility;
            $details = [
                'amount' => $listing->amount,
                'email' => $data['email'],
                'name' => $user->fullname,
                'reference' => $data['code'],
                'currency' => get_setting('currency_code'),
                'redirectUrl' => route('monnify.success.listing'),
                'description' => $data['message'],
            ];
            $response = $monnify->offerPayment($details);
            if ($response['responseMessage'] !== 'success' && $response['requestSuccessful'] !== 'true') {
                return back()->withError('Unable to Initialize payment. Please try again');
            }

            return redirect($response['responseBody']['checkoutUrl']);
        }

        return back()->withError('Please select a payment method');

    }

    public function make_offer(Request $request)
    {
        // validate request
        $request->validate([
            'amount' => 'required|numeric|min:100',
        ]);
        $listing = Listing::findOrFail($request->listing);
        $user = Auth::user();
        // check if deals hasn't been completed
        if ($listing->status != 1) {
            return back()->withError('Listing has been completed successfully');
        }
        // Check if the user has already made an offer for this listing
        $existingOffer = ListingOffer::where('user_id', $user->id)->where('listing_id', $listing->id)->first();
        if ($existingOffer) {
            return back()->withError('You have already made an offer for this listing.');
        }

        if ($listing->user_id == $user->id) {
            return back()->withError('You can not buy your own account.');
        }
        $seller = $listing->user;

        // create offer
        $offer = new ListingOffer;
        $offer->user_id = $user->id;
        $offer->seller_id = $seller->id;
        $offer->listing_id = $listing->id;
        $offer->amount = $request->amount;
        $offer->save();

        // send email notification to seller
        $subj = "New Offer on your Listing. {$listing->name}.";
        $e_mess = 'You received a New Offer on your Listing. <b>'.$listing->name.'<b>.
        <br> <p> See Below for details of Transactions. </p>
            Amount : '.format_price($offer->amount)."<br> Bidder: {$user->username} <br> Date : ".show_datetime($offer->created_at);
        general_email($seller->email, $subj, $e_mess);

        return to_route('user.listings.deals')->withSuccess('Offer Made successfully');
    }

    public function offer_payment(Request $request, $id)
    {
        $offer = ListingOffer::where('user_id', Auth::id())->whereId($id)->first();
        if (! $offer) {
            return back()->withError('You do not have permission to modify this offer');
        }
        $listing = $offer->listing;
        $user = Auth::user();
        // check if deals hasn't been completed
        if ($listing->sold == 1) {
            return back()->withError('Listing has been completed successfully');
        }
        if ($listing->user_id == $user->id) {
            return back()->withError('You can not buy your own account.');
        }
        $seller = $listing->user;
        $trx = $offer->transaction;

        $data['seller_id'] = $seller->id;
        $data['offer_id'] = $offer->id;
        $data['listing_id'] = $listing->id;
        $data['amount'] = $offer->amount;
        $data['email'] = $user->email;
        $data['user_id'] = $user->id;
        $data['message'] = "Payment for {$listing->name}";
        $data['code'] = $trx->code;
        $data['trx_type'] = 'listing';
        // create trx

        $request->session()->put('listings_payment_data', $data);
        $monnify = new MonnifyUtility;
        $details = [
            'amount' => $offer->amount,
            'email' => $data['email'],
            'name' => $user->fullname,
            'reference' => $data['code'],
            'currency' => get_setting('currency_code'),
            'redirectUrl' => route('monnify.success.listing'),
            'description' => $data['message'],
        ];
        $response = $monnify->offerPayment($details);
        if ($response['responseMessage'] !== 'success' && $response['requestSuccessful'] !== 'true') {
            return back()->withError('Unable to Initialize payment. Please try again');
        }

        return redirect($response['responseBody']['checkoutUrl']);

    }

    public function seller_offer_comment($id, Request $request)
    {
        $trx = ListTrx::where('seller_id', Auth::id())->whereId($id)->first();
        if (! $trx) {
            return back()->withError('You do not have permission to modify this offer');
        }
        $comment = ListingComment::create([
            'listing_id' => $trx->listing->id,
            'offer_id' => 0,
            'type' => 0,
            'message' => Purify::clean($request->comment),
        ]);
        // send message to buyer
        $subj = 'New message from Seller on '.sys_setting('name');
        $msg = "{$request->comment}";
        general_email($trx->buyer->email, $subj, $msg);

        return back()->withSuccess('Message sent successuully.');
    }

    public function buyer_offer_comment($id, Request $request)
    {
        $trx = ListTrx::where('buyer_id', Auth::id())->whereId($id)->first();
        if (! $trx) {
            return back()->withError('You do not have permission to modify this offer');
        }
        $comment = ListingComment::create([
            'listing_id' => $trx->listing->id,
            'offer_id' => 0,
            'type' => 1,
            'message' => Purify::clean($request->comment),
        ]);

        $subj = 'New message from Buyer on '.sys_setting('name');
        $msg = "{$request->comment}";
        general_email($trx->seller->email, $subj, $msg);

        return back()->withSuccess('Message sent successuully.');
    }

    // deal confirmation
    public function buyer_offer_confirmation($id, Request $request)
    {
        $trx = ListTrx::where('buyer_id', Auth::id())->whereId($id)->first();
        if (! $trx) {
            return back()->withError('You do not have permission to confirm this deal.');
        }
        if ($trx->status != 1) {
            return back()->withError('Please make payment before you can confor this deal.');
        }
        $trx->buyer_confirm = 1;
        $trx->save();
        $listing = $trx->listing;
        $seller = $trx->seller;
        // send email to seller
        $subj = "Buyer confirmation for : {$listing->name}";
        $msg = 'The buyer has successfully  confirmed having access to the account. Please complete the deal as soon as possible.';
        general_email($seller->email, $subj, $msg);

        return back()->withSuccess('Buyer Confirmation was successful');
    }

    public function seller_offer_confirmation($id, Request $request)
    {
        $trx = ListTrx::where('seller_id', Auth::id())->whereId($id)->first();
        if (! $trx) {
            return back()->withError('You do not have permission to confirm this deal');
        }
        if ($trx->status != 1) {
            return back()->withError('Please make payment befor you can confirm this deal');
        }
        // check is buyer already confirmed
        if ($trx->buyer_confirm != 1) {
            return back()->withError('The buyer has to confirm this deal before you can receive your earnings. Please wait');
        }
        if ($trx->seller_confirm == 1) {
            return back()->withError('You have already completed this deal.');
        }

        $trx->seller_confirm = 1;
        $trx->save();
        $listing = $trx->listing;
        $seller = $trx->seller;
        $buyer = $trx->buyer;
        // set listing as sold
        $listing->status = 1;
        $listing->sold = 1;
        $listing->save();
        // Credit Seller Deals balance
        $rate = sys_setting('seller_rate') ?? '10';
        $amount = $trx->amount;
        $fee = ($rate / 100) * $amount;
        $final_amount = round($amount - $fee, 2);
        $seller->deal_wallet += $final_amount;
        $seller->save();
        $trxcode = getTrx(12);
        $seller->transactions()->create([
            'amount' => $final_amount,
            'user_id' => $seller->id,
            'charge' => $fee,
            'old_balance' => $seller->deal_wallet - $final_amount,
            'new_balance' => $seller->deal_wallet,
            'type' => 1,
            'status' => 1,
            'service' => 'listing',
            'message' => 'Payment from Listings - '.$listing->name,
            'code' => $trxcode,
        ]);
        // send email
        $e_mess = 'A Credit Transaction of <b>'.format_price($final_amount).'</b> occured on your Account.
        <br> <p> See Below for details of Transactions. </p>
            Amount : '.format_price($final_amount)."<br> Details: Payment for completing a Listing deal - {$listing->name} <br> Reference : {$trxcode} <br> Balance: ".format_price($seller->deal_wallet).'<br> Date : '.show_datetime(now());
        general_email($seller->email, 'Credit Transaction Alert', $e_mess);
        // send email to buyer
        $subj = "Seller confirmation for : {$listing->name}";
        $msg = 'The seller has successfully confirmed this deal. Thanks for trading with us.';
        general_email($buyer->email, $subj, $msg);

        return back()->withSuccess('Seller Confirmation was successful');
    }

    public function complete_monnify_payment($details, $response = null)
    {
        // get trx
        $trx = ListTrx::whereCode($details['paymentReference'])->first();

        $trx->date = now();
        $trx->status = 1;
        $trx->paid = 1;
        $trx->response = $response;
        $trx->save();

        $listing = $trx->listing;
        $listing->sold = 1;
        $listing->save();

        $seller = $trx->seller;
        $amount = $trx->amount;
        $buyer = $trx->buyer;
        $rate = sys_setting('seller_rate') ?? '10';
        $fee = ($rate / 100) * $amount;
        $final_amount = round($amount - $fee, 2);
        //
        // send email notification to seller
        $subj = "Payment for your Listing: {$listing->name}";
        $msg = 'You received a payment of '.format_price($amount)."for your listing- {$listing->name}. Please Confirm and complete the deal as soon as possible.";
        $msg1 = 'Dear Admin, You received a payment of '.format_price($amount)."for a listing- {$listing->name}. Please Confirm and complete the deal as soon as possible.";
        general_email($seller->email, $subj, $msg); // email to seller
        request()->session()->remove('listings_payment_data');

        return to_route('user.listings.index')->withSuccess('Account Purchased Successfully');
    }

    public function withdraw(Request $request)
    {
        $request->validate([
            'withdraw_type' => 'string|required',
            'amount' => 'required|integer|min:1',
        ]);
        $user = Auth::user();
        if ($user->deal_wallet < $request->amount) {
            return back()->with('error', 'You dont have enough funds in your referral bonus to withdraw');
        }
        if ($request->withdraw_type == 'wallet') {
            $user->deal_wallet = $user->deal_wallet - $request->amount;
            $user->balance = $user->balance + $request->amount;
            $user->save();

            $trans = new Transaction;
            $trans->user_id = $user->id;
            $trans->type = 1; // 1- credit, 2- deit, 3-others
            $trans->code = getTrx(14);
            $trans->message = 'Your withdrawal of '.format_price($request->amount).' to main wallet was successful';
            $trans->amount = $request->amount;
            $trans->status = 1;
            $trans->charge = 0;
            $trans->service = 'referral'; // bills
            $trans->old_balance = $user->balance - $request->amount;
            $trans->new_balance = $user->balance;
            $trans->save();
            // Withdrawal Trx
            $withdraw = new Withdrawal;
            $withdraw->old_balance = $trans->old_balance;
            $withdraw->new_balance = $trans->new_balance;
            $withdraw->amount = $request->amount;
            $withdraw->final = $request->amount;
            $withdraw->user_id = $user->id;
            $withdraw->code = $trans->code;
            $withdraw->status = 1;
            $withdraw->charge = 0;
            $withdraw->message = 'Your withdrawal of '.format_price($request->amount).' to main wallet was successful';
            $withdraw->type = 'wallet';
            $withdraw->service = 'listing';
            $withdraw->save();
            $message = $trans->message;

        } elseif ($request->withdraw_type == 'bank') {
            if (sys_setting('min_withdraw') > $request->amount) {
                return back()->with('error', 'You can not withdraw below the minimum withdrawal amount '.format_price(sys_setting('min_withdraw')));
            }

            if ($user->acc_name == null || $user->acc_number == null || $user->bank_name == null) {
                return back()->withError('Please Input your account Details Before you withdraw');
            }
            $user->deal_wallet = $user->deal_wallet - $request->amount;
            $user->save();

            $trans = new Transaction;
            $trans->user_id = $user->id;
            $trans->type = 2; // 1- credit, 2- deit, 3-others
            $trans->code = getTrx(14);
            $trans->message = 'Referral bonus withdrawal to bank account';
            $trans->amount = $request->amount;
            $trans->status = 1;
            $trans->charge = 0;
            $trans->service = 'referral'; // bills
            $trans->old_balance = $user->deal_wallet + $request->amount;
            $trans->new_balance = $user->deal_wallet;
            $trans->save();
            // Withdrawal Trx
            $withdraw = new Withdrawal;
            $withdraw->old_balance = $trans->old_balance;
            $withdraw->new_balance = $trans->new_balance;
            $withdraw->amount = $request->amount;
            $withdraw->charge = 0;
            $withdraw->final = $request->amount - $withdraw->charge;
            $withdraw->user_id = $user->id;
            $withdraw->code = $trans->code;
            $withdraw->status = 2;
            $withdraw->message = 'Your withdrawal of '.format_price($request->amount).' is pending.';
            $withdraw->type = 'bank';
            $withdraw->service = 'listing';
            $withdraw->save();
            $message = 'Withdrawal has been placed successfully and your account would be credited soon';
        }

        return redirect()->back()->withSuccess($message);
    }
}
