<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Models\Pincode;
use App\Models\Ecome;
use Illuminate\Http\Request;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Exception;
class DelhiveryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function updateOrdersStatus()
    {
        Order::getDVOrderStatus();
        Order::getECOrderStatus();
        return back()->with('status','successs');
    }

    public function createWharehouse(Request $request)
    {
        $user = User::find($request->user()->id);
        try{
            $url = "https://track.delhivery.com/api/backend/clientwarehouse/create/";
            $client = new Client([
                'verify' => false,
                "headers"=>[
                    'Content-Type'=>'application/json',
                    'Authorization'=>'Token '.env('DELIVEY_TOKEN','asdfgh')
                ]
            ]);

            $post_data = '{
                          "phone": "'.$user->phone.'",
                          "city": "'.$user->city.'",
                          "name": "'.$user->email.'",
                          "pin": "'.$user->pin.'",
                          "address": "'.$user->address.'",
                          "country": "India",
                          "email": "'.$user->email.'",
                          "registered_name": "'.$user->email.'",
                           "return_address": "'.$user->returnadd.'",
                           "return_pin":"'.$user->pin.'",
                           "return_city":"'.$user->city.'",
                           "return_state":"'.$user->state.'",
                           "return_country": "India"
                        }';

            $response = $client->request('POST',$url, [
                'body' => $post_data
            ]);
            $res = json_decode((string) $response->getBody());
        }catch (Exception $e) {
            //return $e;
        }
        $user->wharehouse=2;
        $user->save();
        return back()->with('status','WhareHouse Created.');
    }

    public function orderstatus(Request $request, $id)
    {
        $order = Order::find($id);

        if($order->status=='1'){
            $required_fields = [
                'price'=>'Order price is required',
                'name'=>'Customer name is required',
                'address'=>'Order address is required',
                'phone'=>'Mobile no. is required',
                'date'=>'Order date is required'
            ];
            $errors = [];
            foreach($required_fields as $field=>$error){
                if(empty($order->$field)){
                    $errors[] = $error;
                }
            }
            if(!empty($errors)){
                return back()->with('error',json_encode($errors));
            }

            if($request->sendBy == 'Ecome'){
                $charge = Ecome::calculationEcome($order);
            }else{
                $charge = Ecome::calculationDelivery($order);
            }

            $user = User::find($order->userid);
            if($user->points < $charge)
            {
                return back()->with('error','Insignificant Balance.');
            }
            //fatch tracking no
            if($request->sendBy == 'Ecome'){
                $result = $order->fetchECTrackingNo();
            }else{
                $result = $order->fetchDVTrackingNo();
            }
            if($result != 'success'){
                return back()->with('error',$result);
            }
            $order->shipingcost = $charge;
            $order->sendBy = $request->sendBy;
            $order->save();
            $user->remittance = $user->remittance + $order->price;
            $user->points = $user->points - $charge;
            $user->save();
            return back()->with('status','Order Send Successfully.');
        }
        return back();
    }

    public function orderprint($id){
        $order = Order::find($id);
        if($order->sendBy == 'Dehlivery')
        {
            $packages = [];
            $waybill = $order->trackingNo;
            if($waybill==''){
                return back()->with('status','Please generate  waybill first then user print.');
            }
            $package = NULL;
            $url = "https://track.delhivery.com/api/p/packing_slip?wbns=".$waybill;
            $client = new Client([
                'verify' => false,
                "headers"=>[
                    'Content-Type'=>'text/plain',
                    'Authorization'=>'Token '.env('DELIVEY_TOKEN','asdfgh')
                ]
            ]);
            $response = $client->request('GET',$url);
            $res = json_decode((string) $response->getBody());
            $packages[] = $res->packages[0];
            if($order->save()){
                return view('order.print',['order'=>$order,'packages'=>$packages]);
            }
        }else{
            return view('order.printEcome',['order'=>$order]);
        }
    }

    public function calculate(Request $request)
    {
        $data = [];
        if($request->destinationPincode!='' && $request->originPincode!='')
        {
            if(!Pincode::where('pin',$request->destinationPincode)->exists()){
                return back()->with('error','Service not available.');
            }
            if(!Pincode::where('pin',$request->originPincode)->exists()){
                return back()->with('error','Service not available.');
            }

            $validatedData = $request->validate([
                'destinationPincode' => 'required|numeric',
                'originPincode' => 'required|numeric',
                'deliveryMode' => 'required',
                'packageStatus' => 'required',
                'packageType' => 'required',
                'weight' => 'required|numeric',
            ]);

            $url ='https://track.delhivery.com/api/kinko/v1/invoice/charges/.json?md='.$request->deliveryMode.'&cgm='.$request->weight.'&o_pin='.$request->originPincode.'&d_pin='.$request->destinationPincode.'&ss=Delivered';
            $client = new Client([
                'verify' => false,
                "headers"=>[
                    'Content-Type'=>'application/json',
                    'Authorization'=>'Token '.env('DELIVEY_TOKEN','asdfgh')
                ]
            ]);
            $response = $client->request('GET', $url);
            $res = json_decode((string) $response->getBody());
                $cod = 0; $gst=0;
                if($res[0]->status=='Delivered' && $request->packageType == 'COD'){
                    $cod = $res['0']->charge_COD;
                    if($request->amount!='' && $request->amount > 0){
                        if($request->amount<=1000){
                            $cod += 40;
                        }else{
                            $cod += ($request->amount*2)/100;
                        }
                        $gst = (($cod+10)*18)/100;
                    }
                }

                $data['details'] = $res[0];
                $data['cod'] = $cod;
                $data['gst'] = $gst;
        }
        return view('calculate',compact('data'));
    }
}
