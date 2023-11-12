<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderController extends Controller
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
        $orders = Order::whereYear('created_at',date('Y'));
        $start = date('Y-m-d');
        $end = date('Y-m-d',strtotime('+1 month'));
        
        if($request->start!=''){
            $orders = Order::whereBetween('created_at',[$request->start,$request->end]);
            $start = $request->start;
            $end = $request->end;
        }
        
        if($request->status!=''){
            $orders = $orders->where('status',$request->status);
        }
        
        if($request->userid!='')
        {
         $orders = $orders->where('userid',$request->userid);   
        }
        
        if($request->user()->roleid==2){
            $orders = $orders->where('userid',$request->user()->id);
        }
        $orders = $orders->latest()->get();
        $userid = $request->userid;
        $status = $request->status;
        $users = User::orderBy('name','asc')->where('roleid',2)->get();
        return view('order.index',compact('orders','users','userid','start','end','status'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('order.create');
    }

    public function check_order()
    {
        $orderno = rand(100000000,999999999);
        if(Order::where('orderid',$orderno)->exists()){
            $this->check_order();
        }
        return $orderno;
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
            'name' => 'required',
            'price' => 'required|numeric',
            'phone' => 'required|numeric',
            'products_desc' => 'required',
            'weight' => 'required',
            'paymenttype' => 'required',
            'address' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'pin' => 'required|numeric',
            'length' => 'required|numeric',
            'breadth' => 'required|numeric',
            'height' => 'required|numeric',
            'quantity' =>'required',
            'packagetype' =>'required'
        ]);
        $order = new Order;
        $order->date = date('Y-m-d,H:i:s');
        $order->orderid = $this->check_order();
        $order->userid = $request->user()->id;
        $order->name = $request->name;
        $order->price = $request->price;
        $order->phone = $request->phone;
        $order->products_desc = $request->products_desc;
        $order->packagetype = $request->packagetype;
        $order->paymenttype = $request->paymenttype;
        $order->address = $request->address;
        $order->country = $request->country;
        $order->quantity = $request->quantity;
        $order->weight = $request->weight;
        $order->length = $request->length;
        $order->breadth = $request->breadth;
        $order->height = $request->height;
        $order->state = $request->state;
        $order->city = $request->city;
        $order->pin = $request->pin;
        $order->save();
        return redirect(route('order.index'))->with('status','Stored Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        return view('order.show',compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        return view('order.edit',compact('order'));
    }

    public function print(Order $order)
    {
        return view('order.print',compact('order'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'phone' => 'required|numeric',
            'products_desc' => 'required',
            'weight' => 'required',
            'paymenttype' => 'required',
            'address' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'pin' => 'required|numeric',
            'packagetype' => 'required',
            'length' => 'required|numeric',
            'breadth' => 'required|numeric',
            'height' => 'required|numeric',
            'quantity' => 'required'
        ]);
        $order->name = $request->name;
        $order->price = $request->price;
        $order->phone = $request->phone;
        $order->products_desc = $request->products_desc;
        $order->paymenttype = $request->paymenttype;
        $order->packagetype = $request->packagetype;
        $order->quantity = $request->quantity;
        $order->weight = $request->weight;
        $order->length = $request->length;
        $order->breadth = $request->breadth;
        $order->height = $request->height;
        $order->address = $request->address;
        $order->country = $request->country;
        $order->state = $request->state;
        $order->city = $request->city;
        $order->pin = $request->pin;
        $order->save();
        return redirect(route('order.index'))->with('status','Stored Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return redirect(route('order.index'))->with('status','Deleted Successfully');
    }    
}
