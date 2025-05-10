<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\Transaction;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //

    public function users(Request $request)
    {
        $search = null;
        $users = User::whereStatus(1)->orderByDesc('id')->paginate(50);
        if ($request->has('search')) {
            $search = $request->search;
            $users = User::searchUser($search)->orderByDesc('id')->paginate(50);
        }

        return view('admin.users.index', compact('users', 'search'));
    }

    public function user_downlines(Request $request)
    {
        $search = null;
        $users = User::where('status', 1)->withCount('referrals')->orderByDesc('referrals_count')->paginate(100);
        if ($request->has('search')) {
            $search = $request->search;
            $users = User::searchUser($search)->withCount('referrals')->orderByDesc('referrals_count')->paginate(100);
        }

        return view('admin.users.downline', compact('users', 'search'));
    }

    public function view_user_downline($id)
    {
        $user = User::find($id);
        $referrals = $user->referrals;

        return view('admin.users.viewdown', compact('user', 'referrals'));
    }

    public function view_user($id)
    {
        $user = User::find($id);

        return view('admin.users.view', compact('user'));
    }

    public function user_settings()
    {
        return view('admin.users.settings');
    }

    // update users
    public function update_user(Request $request, $id)
    {
        // return $request;
        $user = User::findorFail($id);
        $user->fname = $request->fname;
        $user->lname = $request->lname;
        $user->email = $request->email;
        $user->username = $request->username;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->status = $request->status;
        $user->user_role = $request->user_role;
        if ($request->password != null) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return redirect()->back()->withSuccess(__('User updated Successfully.'));

    }

    public function user_sendemail($id, Request $request)
    {
        $this->validate($request, [
            'subject' => 'required',
            'message' => 'required|string',
        ]);
        $user = User::findorFail($id);
        general_email($user->email, $request->subject, $request->message);

        return back()->withSuccess('Email Sent Successfully');
    }

    public function update_user_balance($id, Request $request)
    {
        $this->validate($request, [
            'amount' => 'required|numeric|min:0',
            'type' => 'required',
            'message' => 'required',
        ]);
        // return $request;
        $reference = getTrx();
        $user = User::findorFail($id);
        $mesg = 'User Balance updated Successfully.';
        if ($request->type == 1) {
            $deposit = new Deposit;
            $deposit->user_id = $user->id;
            $deposit->type = 'admin'; // 1- event, 2- form, 3-vote
            $deposit->gateway = 'system';
            $deposit->code = $reference;
            $deposit->message = $request['message'];
            $deposit->charge = 0;
            $deposit->amount = $request['amount'];
            $deposit->status = 1;
            $deposit->save();
            // create transaction
            $trans = new Transaction;
            $trans->user_id = $user->id;
            $trans->type = 1; // 1- credit, 2- debit, 3-others
            $trans->code = $reference;
            $trans->message = $deposit->message;
            $trans->amount = $deposit['amount'];
            $trans->status = 1;
            $trans->charge = $deposit->charge;
            $trans->service = 'deposit';
            $trans->old_balance = $user->balance;
            $trans->new_balance = $user->balance + $deposit['amount'];
            $trans->save();

            // Add User Balance
            $user->balance += $request['amount'];
            $user->save();
            // send email
            $e_mess = 'A Credit Transaction of <b>'.format_price($request->amount).'</b> occured on your Account.
            <br> <p> See Below for details of Transactions. </p>
            Amount : '.format_price($request->amount)."<br> Details: {$trans->message} <br> Reference : {$trans->code} <br> Balance: ".format_price($user->balance).'<br> Date : '.show_datetime($trans->created_at);
            general_email($user->email, 'Credit Transaction Alert', $e_mess);

            $mesg = 'User Balance Added Successfully.';
        } else {
            $deposit = new Deposit;
            $deposit->user_id = $user->id;
            $deposit->type = 'admin'; // 1- event, 2- form, 3-vote
            $deposit->gateway = 'system';
            $deposit->code = $reference;
            $deposit->message = $request['message'];
            $deposit->charge = 0;
            $deposit->amount = $request['amount'];
            $deposit->status = 1;
            $deposit->save();

            // create transaction
            $trans = new Transaction;
            $trans->user_id = $user->id;
            $trans->type = 2; // 1- credit, 2- debit, 3-others
            $trans->code = $reference;
            $trans->message = $deposit->message;
            $trans->amount = $deposit['amount'];
            $trans->status = 1;
            $trans->charge = $deposit->charge;
            $trans->service = 'deposit';
            $trans->old_balance = $user->balance;
            $trans->new_balance = $user->balance - $deposit['amount'];
            $trans->save();

            // Add User Balance
            $user->balance -= $request['amount'];
            $user->save();
            // send email
            $e_mess = 'A debit Transaction of <b>'.format_price($request->amount).'</b> occured on your Account.
            <br> <p> See Below for details of Transactions. </p>
                Amount : '.format_price($request->amount)."<br> Details: {$trans->message} <br> Reference : {$trans->code} <br> Balance: ".format_price($user->balance).'<br> Date : '.show_datetime($trans->created_at);
            general_email($user->email, 'Debit Transaction Alert', $e_mess);
            $mesg = 'User Balance deducted Successfully.';
        }

        return redirect()->back()->withSuccess($mesg);
    }

    public function user_login($id)
    {
        $user = User::findOrFail(decrypt($id));

        auth()->login($user, false);

        return redirect()->route('user.dashboard');
    }
}
