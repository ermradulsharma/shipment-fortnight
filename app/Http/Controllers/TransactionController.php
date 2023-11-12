<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Session;

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //session()->put('payamount',$request->amount);
        //return redirect(url('profile/'.$request->user()->id));
        $payments = Transaction::orderBy('id', 'desc');
        if($request->user()->roleid != 1){
            $payments = $payments->where('userid',$request->user()->id);
        }
        $payments = $payments->get();
        return view('paymentHistory', compact('payments'));
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
       
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'amount' => 'required'
        ]);
      
        $imageName = time().date('d-m-y').'.'.$request->image->extension(); 
        $request->image->storeAs('public/images', $imageName);
        $transaction = new Transaction;
        $transaction->userid = $request->user()->id;
        $transaction->transactionid = "PhonePay";
        $transaction->amount = $request->amount;
        $transaction->image = $imageName;
        $transaction->save();
        return back()->with('status','Payment Added Successfully, please wait for verify your payment.');
        /*
        $input = $request->all();
        $api = new Api(config('custom.razor_key'), config('custom.razor_secret'));
        $payment = $api->payment->fetch($input['razorpay_payment_id']);
        if(count($input)  && !empty($input['razorpay_payment_id'])) {
            try {
                $response = $api->payment->fetch($input['razorpay_payment_id'])->capture(array('amount'=>$payment['amount'])); 
                $user = User::find($request->user()->id);
                $user->points = $user->points+($payment['amount']/100);
                $user->save();
                $transaction = new Transaction;
                $transaction->userid = $request->user()->id;
                $transaction->transactionid = $input['razorpay_payment_id'];
                $transaction->amount = $payment['amount']/100;
                $transaction->save();
            } catch (Exception $e) {
                //$e->getMessage();
                Session::put('error',$e->getMessage());
                //return redirect()->back();
            }
        }
        session()->forget('payamount');
        
        return back()->with('status','Points Added Successfully');
        */
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
    public function update(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required'
        ]);
        $transaction = Transaction::find($id);
        $transaction->status = 1;
        $transaction->save();
        $user = User::find($transaction->userid);
        $user->points = $user->points+($request->amount);
        $user->save();  
        return back()->with('status','Payment Verified Successfully.');
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
