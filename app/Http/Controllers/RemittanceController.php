<?php

namespace App\Http\Controllers;

use App\Models\Remittance;
use App\Models\User;
use Illuminate\Http\Request;

class RemittanceController extends Controller
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
        $remittances = Remittance::where('status','Complete')->get();
        if($request->user()->roleid==2){
            $remittances = $remittances->where('userid',$request->user()->id);
        }
        return view('remittance',compact('remittances'));
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
        $validatedData = $request->validate([
            'amount' => 'required',
            'userid' => 'required'
        ]);
        $user = User::find($request->userid);
        if($user->remittance<$request->amount){
            return back()->with('error','Estimated Amount is less then Pay Amount. ');
        }
        $remittance = new Remittance;
        $remittance->userid = $request->userid;
        $remittance->transactionid = $request->transactionid;
        $remittance->amount = $request->amount;
        $remittance->status = 'Complete';
        $remittance->save();
        
        $user->remittance = $user->remittance-$request->amount;
        $user->save();
        
        return back()->with('status','Stored Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Remittance  $remittance
     * @return \Illuminate\Http\Response
     */
    public function show(Remittance $remittance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Remittance  $remittance
     * @return \Illuminate\Http\Response
     */
    public function edit(Remittance $remittance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Remittance  $remittance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Remittance $remittance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Remittance  $remittance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Remittance $remittance)
    {
        //
    }
}
