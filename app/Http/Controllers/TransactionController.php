<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Notification;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class TransactionController extends Controller
{
    /* public function updateTransaction($id)
    {
        $transaction = Transaction::find($id);
        if ($transaction->status =='1'){
            $transaction->update(['status' => '5']);
        }
    } */

    public function viewTransaction()
    {
        if (Auth::check()) {
            return view('transaction-history.modal-transaction-history');
        } else {
            return abort(404);
        }
    }

    public function getTransaction(Request $request)
    {
        if (request()->ajax() && Auth::check()) {
            $transaction = Transaction::where('transactions.user_id', '=', Auth::user()->id)
                /* ->join('bank_accounts', 'bank_accounts.bank_id', 'transactions.to_acc_id->bank_id')
                ->join('banks', 'banks.id', 'transactions.to_acc_id->bank_id') */
                ->select(
                    'transactions.*',
                    'transactions.from_bank->name as from_bank_name',
                    'transactions.your_receive_bank->name as your_receive_bank_name',
                    /* 'bank_accounts.account_no as to_acc',
                    'banks.name as to_acc_name', */
                    'transactions.to_acc_id->account_no as to_acc',
                    'transactions.to_acc_id->bank_name as to_acc_name',
                    'transactions.from_curr_id->name as from_curr_name',
                    'transactions.to_curr_id->name as to_curr_name',
                );
            /* $transaction = Transaction::join('banks as banks', 'transactions.from_bank', 'banks.id')
                ->join('banks as receive_banks', 'transactions.your_receive_bank', 'receive_banks.id')
                ->join('bank_accounts', 'transactions.to_acc_id', 'bank_accounts.id')
                ->join('banks as to_bank', 'bank_accounts.bank_id', 'to_bank.id')
                ->join('currencies as from_curr', 'transactions.from_curr_id', 'from_curr.id')
                ->join('currencies as to_curr', 'transactions.to_curr_id', 'to_curr.id')
                ->where('transactions.user_id', '=', Auth::user()->id)
                ->select(
                    'transactions.*',
                    'banks.name as from_bank_name',
                    'receive_banks.name as your_receive_bank',
                    'bank_accounts.account_no as to_acc',//
                    'to_bank.name as to_acc_name',
                    'from_curr.name as from_curr_name',
                    'to_curr.name as to_curr_name'
                ); */
            if ($request->type == 1) {
                $transaction = $transaction->orderBy('transactions.created_at', 'desc');
            } else if ($request->type == 2) {
                $transaction = $transaction->orderBy('transactions.created_at', 'asc');
            }
            $transaction = $transaction->get();
            return response()->json(['transaction' => $transaction]);
        } else {
            return abort(404);
        }
    }

    public function getSingleTransaction(Request $request)
    {
        if (request()->ajax() && Auth::check()) {
            $user = User::find(Auth::user()->id);
            $transaction = Transaction::where('transactions.user_id', '=', Auth::user()->id)
                ->where('transactions.id', '=', Crypt::decrypt($request->id))
                ->first();
            //$to_acc_bank = Bank::find(json_decode($transaction->to_acc_id)->bank_id);
            //$to_acc_bank = Bank::find($transaction->to_acc_id['bank_id']);
            if ($transaction) {
                return response()->json([
                    'id' => $request->id,
                    'email' => $user->email,
                    'from_acc' => $transaction->from_acc,
                    'from_bank' => $transaction->from_bank['name'],
                    'your_receive_acc' => $transaction->your_receive_acc,
                    'your_receive_bank' => $transaction->your_receive_bank['name'],
                    'from_curr' => $transaction->from_curr_id['name'],
                    'to_curr' => $transaction->to_curr_id['name'],
                    'from_amount' => $transaction->from_amount,
                    'fx_rate' => $transaction->fx_rate,
                    'result_amount' => $transaction->to_amount,
                    'recipient_acc' => $transaction->to_acc_id['account_no'],
                    'recipient_bank_name' => $transaction->to_acc_id['bank_name'],
                    'ref_no' => $transaction->ref_no,
                    'status' => $transaction->status,
                ]);
            } else {
                return abort(404);
            }
        } else {
            return abort(404);
        }
    }

    public function validateTransaction(Request $request)
    {
        if (Auth::check() && request()->ajax()) {
            try {
                $transaction = Transaction::where('user_id', '=', Auth::user()->id)->find(Crypt::decrypt($request->id));
            } catch (\RuntimeException $e) {
                $transaction = Transaction::where('user_id', '=', Auth::user()->id)->find($request->id);
            }
            if (($request->status == 2 || $request->status == 3) && ($transaction->status == 1)) {
                return response()->json([], 200);
            } else {
                return response()->json([], 400);
            }
        } else {
            abort(404);
        }
    }

    public function updateTransaction(Request $request)
    {
        if (Auth::check()) {
            if (request()->ajax()) {
                $transaction = Transaction::where('user_id', '=', Auth::user()->id)->find($request->id);
            } else {
                try {
                    $transaction = Transaction::where('user_id', '=', Auth::user()->id)->find(Crypt::decrypt($request->id));
                } catch (\RuntimeException $e) {
                    $transaction = Transaction::where('user_id', '=', Auth::user()->id)->find($request->id);
                }
            }
            //return $transaction;
            //return [$transaction,$request->status,$request->id];
            if ($transaction->status != $request->status) {
                $valid = true;
                //$transaction->status = $request->status;
                $file = $request->file('imgUpload');
                if ($file) {
                    $path = 'receiptAttach/';
                    $folder = '';
                    //$folder = $request->id . '/';
                    $file_name = time() . '_' . $file->getClientOriginalName();
                    //$tbl_users->profile_pic_path = $file_name;
                    $transaction->receipt_img_path = $folder . $file_name;
                    $upload = $file->move(public_path('receiptAttach'), $file_name);
                    //$upload = $file->storeAs($path . $folder, $file_name, 'local');
                    if (!$upload) {
                        $valid = false;
                    }
                }

                if ($request->status == 1) {
                    $message = 1;
                } else if ($request->status == 2) {
                    if ($transaction->status == 1) {
                        $message = 2;
                    } else {
                        $valid = false;
                    }
                } else if ($request->status == 3) {
                    if ($transaction->status == 1) {
                        $message = 3;
                    } else {
                        $valid = false;
                    }
                } else if ($request->status == 4) {
                    $message = 4;
                } else if ($request->status == 5) {
                    $message = 5;
                }

                if (!$valid) {
                    $message = 7;
                }

                $notification = Notification::create([
                    'user_id' => Auth::user()->id,
                    'transasction_id' => $transaction->id,
                    'message_type' => $message,
                    'reason_id' => -1,
                    'status' => 1,
                ]);

                if (request()->ajax()) {
                    if ($valid) {
                        $transaction->status = $request->status;
                        if ($transaction->save()) {
                            return response()->json([], 200);
                        } else {
                            return response()->json([], 500);
                        }
                    } else {
                        return response()->json([], 500);
                    }
                } else {
                    if ($valid) {
                        $transaction->status = $request->status;
                        if ($transaction->save()) {
                            return redirect()->back()->with(['success' => __('content.transaction.success')]);
                        } else {
                            return redirect()->back()->with(['error' => __('content.swal.smtg-went-wrong')]);
                        }
                    } else {
                        return redirect()->back()->with(['error' => __('content.swal.smtg-went-wrong')]);
                    }
                }
            } else {
                if (request()->ajax()) {
                    return response()->json([], 500);
                } else {
                    return redirect()->back()->with('error', __('content.swal.smtg-went-wrong'));
                }
            }
        } else {
            return abort(404);
        }
    }

    /* public function updateTransaction(Request $request)
    {
        return $request;
        if (Auth::check() && request()->ajax()) {
            //$transaction = Transaction::whereHas('transasction', function ($query) {
                //$query->where('user_id', '=', Auth::user()->id);
            //})->find($request->id);
            $transaction = Transaction::where('user_id', '=', Auth::user()->id)->find($request->id);
            //return [$transaction,$request->status,$request->id];
            if ($transaction->status != $request->status) {
                $order = '<b>Order #' . str_pad($transaction->id, 5, '0', STR_PAD_LEFT) . '</b>';
                $valid = true;
                //$transaction->status = $request->status;
                if ($request->status == 1) {
                    $message = 'Your ' . $order . ' has been pending! Please wait patiently until our staff transfer amount to you!';
                } else if ($request->status == 2) {
                    if ($transaction->status == 1) {
                        $message = 'You confirmed the transasction of ' . $order . '!';
                    } else {
                        $valid = false;
                        $message = 'Ops! There is some errors happeing in ' . $order . '. Please contact to our customer support if any mistake!';
                    }
                } else if ($request->status == 3) {
                    if ($transaction->status == 1) {
                        $message = 'You cancelled the transaction of ' . $order . '!';
                    } else {
                        $valid = false;
                        $message = 'Ops! There is some errors happeing in ' . $order . '. Please contact to our customer support if any mistake!';
                    }
                } else if ($request->status == 4) {
                    $message = 'Our staff has accepted the transaction of ' . $order . ' successfully! It might takes time dues to huge amounts of users using our platform! You may check your account whether is received! Thanks for using our service!';
                } else if ($request->status == 5) {
                    $message = 'Your ' . $order . ' has been rejected!';
                }

                $notification = Notification::create([
                    'transasction_id' => $request->id,
                    'message' => $message,
                ]);
                if (!$valid) {
                    return response()->json([], 500);
                }
                $transaction->status = $request->status;
                if ($transaction->save()) {
                    return response()->json([], 200);
                } else {
                    return response()->json([], 500);
                }
            } else {
                return response()->json([], 200);
            }
        } else {
            return abort(404);
        }
    } */

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
