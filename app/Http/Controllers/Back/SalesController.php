<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Session;

class SalesController extends Controller
{
    //
    function transactions(Request $request){
        $transactions = Transaction::orderByDesc('id')->paginate(50);
        $search = null;
        if($request->has('search') ){
            $search = $request->search;
            $transactions = Transaction::search($request->search)->orderByDesc('id')->paginate(50);
        }
        return view('admin.reports.transaction',compact('transactions','search'));
    }

    function deposits(Request $request){
        $deposits = Deposit::orderByDesc('id')->paginate(50);
        $search = "";
        if($request->has('search') ){
            $search = $request->search;
            $deposits = Deposit::search($request->search)->orderByDesc('id')->paginate(50);
        }
        return view('admin.reports.deposits',compact('deposits','search'));
    }

    function manual_deposits(Request $request){
        $deposits = Deposit::whereGateway('bank')->orderByDesc('id')->paginate(50);
        if($request->has('search') ){
            $deposits = Deposit::search($request->search)->orderByDesc('id')->paginate(50);
        }
        return view('admin.reports.mdeposits',compact('deposits'));
    }

    function deposit_status(Request $request){

        if($request->status == 'approve' ){
            $status = 1;
        }elseif($request->status == 'delete' ){
            $status = 4;
        }elseif($request->status == 'pending' ){
            $status = 2;
        }elseif($request->status == 'canceled' ){
            $status = 3;
        }
        if ($request->strIds == null) {
            session()->flash('error', "You have not selected any transaction.");
            return response()->json(['error' => 1]);
        } else {
            $ids = explode(",", $request->strIds);

            if (count($ids) > 0) {
                $logs = Deposit::whereIn('id', $ids)->with('user')->get()->map(function ($deposit) use($status){

                    if ($status == '1' && $deposit->status != 1) {

                        $amount = $deposit->amount;

                        // create transaction
                        $user = $deposit->user;
                        $user->balance += $amount;
                        $user->save();

                        // create transaction
                        $trans = new Transaction();
                        $trans->user_id = $user->id;
                        $trans->type = 1; // 1- credit, 2- debit, 3-others
                        $trans->code = getTrx();
                        $trans->message = $deposit->message;
                        $trans->amount =$deposit['amount'];
                        $trans->status = 1;
                        $trans->charge = $deposit->charge;
                        $trans->service = "deposit";
                        $trans->new_balance = $user->balance;
                        $trans->old_balance = $user->balance - $amount;
                        $trans->save();

                    }
                    $deposit->status = $status;
                    $deposit->save();
                    if($status == 4){
                        $deposit->delete();
                        return 1;
                    }else{
                        return $deposit ?? "";
                    }

                });

                return $logs;
            }

            Session::flash('success', 'Deposit has been updated successfully');
            return response()->json(['success' => 1]);
        }
    }

    function update_deposit($id,Request $request){
        $deposit = Deposit::findorFail($id);
        $deposit->amount = $request->amount;

        if ($request->status == '1' && $deposit->status != 1) {

            $amount = $deposit->amount;

            // create transaction
            $user = $deposit->user;
            $user->balance += $amount;
            $user->save();

            // create transaction
            $trans = new Transaction();
            $trans->user_id = $user->id;
            $trans->type = 1; // 1- credit, 2- debit, 3-others
            $trans->code = getTrx();
            $trans->message = $deposit->message;
            $trans->amount =$deposit['amount'];
            $trans->status = 1;
            $trans->charge = $deposit->charge;
            $trans->service = "deposit";
            $trans->new_balance = $user->balance;
            $trans->old_balance = $user->balance - $amount;
            $trans->save();

        }
        $deposit->status = $request->status;
        $deposit->save();

        Session::flash('success', 'Deposit has been updated successfully');
        return back();
    }
}
