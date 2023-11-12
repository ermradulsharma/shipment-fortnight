<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Transaction;
use Illuminate\Support\Facades\Hash;
use GuzzleHttp\Client;

class UserController extends Controller
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
        if($request->user()->roleid==2){
            return abort(404);
        }
        $users = User::whereNotIn('roleid',[1,2])->get();
        $roles = Role::where('status',1)->get();
        return view('users',compact('users','roles'));
    }

    public function profile($id)
    {
        $user = User::find($id);
        $transactions = Transaction::where('userid',$id)->get();
        return view('profile',compact('user','transactions'));
    }

    public function userWallet(Request  $request)
    {
        $id = $request->user()->id;
        $user = User::find($id);
        $transactions = Transaction::where('userid',$id)->get();
        return view('profile',compact('user','transactions'));
    }
    
    public function shppingcharge(Request $request)
    {
        $id = $request->userid;
        $user = User::find($id);
        $user->points = $user->points-$request->amount;
        $user->save();
        return back()->with('status','Cuted Shipping Charged');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function customer()
    {
        $customers = User::whereIn('roleid',[2])->get();
        return view('customer',compact('customers'));
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
            'email' => 'required|unique:users|max:255',
            'name' => 'required',
            'roleid' => 'required',
            'phone' => 'required',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = New User;
        $user->roleid = $request->roleid;
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        return back()->with('status','Stored Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return json_encode($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'phone' => 'required',
        ]);
        
        $user = User::find($id);
        if($request->roleid!='')
        {
            $user->roleid = $request->roleid;
        }
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->returnadd = $request->returnadd;
        $user->pin = $request->pin;
        $user->city = $request->city;
        $user->state = $request->state;
        if($request->password){
            $user->password = Hash::make($request->password);
        }
        $user->save();
        return back()->with('status','Updated Successfully');
    }
    
     public function updateupdate(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'returnadd' => 'required',
            'pin' => 'required',
            'city' => 'required',
            'state' => 'required',
            'ac_name' => 'required',
            'ac_no' => 'required',
            'ac_ifsc' => 'required',
            'bank' => 'required',
        ]);
        
        $user = User::find($request->user()->id);
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->returnadd = $request->returnadd;
        $user->pin = $request->pin;
        $user->city = $request->city;
        $user->state = $request->state;
        $user->ac_name = $request->ac_name;
        $user->ac_no = $request->ac_no;
        $user->ac_ifsc = $request->ac_ifsc;
        $user->bank = $request->bank;
        $user->save();
        return back()->with('status','Profile Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id)->delete();
        return back()->with('status','Deleted Successfully');
    }

    public function password(Request $request)
    {
        $validatedData = $request->validate([
            'password' => 'required|confirmed'
        ]);

        $user = User::find($id);
        $user->password = Hash::make($request->user()->id);
        $user->save();
        return back()->with('status','Updated Successfully');
    }

}
