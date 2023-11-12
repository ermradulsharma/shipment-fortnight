<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Models\Order;

class WebhookController extends Controller
{
    //Delhivery Push Api
    public function updateDelhiveryOrder(Request $request){
        $shipment = (object) $request->Shipment;
        $shipmentStatus = (object) $shipment->Status;
        $status = $shipmentStatus->Status;
        $status_type = $shipmentStatus->StatusType;
        $StatusDateTime = $shipmentStatus->StatusDateTime;
        $awb = $shipment->AWB;
        $order = order::where('trackingNo',$awb)->first();
        $statusArr = [
            'Manifested'=>2, //'successed'
            'In Transit'=>2,//in transit
            'Pending'=>2,//undelivered
            'Dispatched'=>3,//out for delivery
            'Delivered'=>4,//delivered
            'RTO'=>5,//return
            'LOST'=>6,
            'LT'=>6
        ];
        $statusArrReturn = [
            'In Transit'=>2, // return in transit
            'Pending'=>2,
            'Dispatched'=>3,//return initiated
            'DTO'=>2,
            'LOST'=>6,
            'LT'=>6
        ];
        
        if(in_array($status_type,["UD","DL"])){
            if(isset($statusArr[$status])){
                $order->status = $statusArr[$status];
            }
            if($status == 'Manifested'){
                $manifested_date = new Carbon($StatusDateTime);
                $order->manifested_at = $manifested_date->toDateTimeString();
            }
        }elseif(in_array($status_type,["RT","RTO","LT","LOST"])){
            if(isset($statusArrReturn[$status])){
                $order->status = $statusArrReturn[$status];
            } 
        }
        $update_date = new Carbon($StatusDateTime);
        $order->updated_at = $update_date->toDateTimeString();
        $order->save();
        return response('OK', 200);
    }
    
    //Ecom Push Api
    public function updateEcomOrder(Request $request){
        //Log::info($request);
        $manifested_codes = [
            "001","013","1210","1220","1230","1260","1310","1320","1330",
            "1340","1350","1360","1370","1380","1390","1400","1410","1420","1430","0011","014","310","326","334"];
        $in_transit_codes = ["002","127","003","004","005","100","101","203","205",
                        "240","301","303","304","305","306","307","308","309","325"];
        $delivered_codes = ["204","999"];
        $shipment_lost = ["333"];
        $out_for_delivery_codes = ['006'];
        $undelivered_codes = ["200","201","202","206","207","208","209","210","211","212",
            "213","214","215","216","217","218","219","220","221","222","223","224",
            "225","226","227","228","229","231","232","233","234","235","236","237","238",
            "331","332","333","666","888","218","219","220","1224","1225",
            "77","80","82","83",
            "23201","23202"
        ];
        $return_initiated = ["777"];
        
        $awb = $request->awb;
        $update_date = $request->datetime;
        $status = $request->status;
        $reason_code = $request->reason_code;
        $status_code = $request->reason_code_number;
        $location = $request->location;
        $employee = $request->Employee;
        $status_update_number = $request->status_update_number;
        $order_number = $request->order_number;
        $city = $request->city;
        $ref_awb = $request->ref_awb;
        
        $order = order::where('trackingNo',$awb)->orWhere('status_type',$awb)->first();
        if(!$order){
            return response()->json(['awb'=>$awb,'status'=>false,'reason'=>'Invalid Response','status_update_number'=>$status_update_number],200);
        }
        if(in_array($status_code,$manifested_codes)){
                $order->status = 2;
        }
        elseif(in_array($status_code,$in_transit_codes)){
                $order->status = 2;
        }
        elseif(in_array($status_code,$delivered_codes)){
                $order->status = 4;
        }
        elseif(in_array($status_code,$undelivered_codes)){
            $order->status = 2;
        }
        elseif(in_array($status_code,$out_for_delivery_codes)){
                $order->status = 3;
        }
        elseif(in_array($status_code,$shipment_lost)){
            $order->status = 6;
        }
        elseif(in_array($status_code,$return_initiated)){
            $order->status = 5;
            //$order->status_type = $order->trackingNo;
            $order->trackingNo = $ref_awb;
        }
        
        //$order->status_code = (String)$status_code;
        $order->updated_at = $update_date;
        $order->save();
        
        return response()->json(['awb'=>$awb,'status'=>true,'status_update_number'=>$status_update_number],200);
    }
    
    public function getStatusEC($awb){
        $order = order::where('trackingNo',$awb)->first();
        $url = "https://plapi.ecomexpress.in/track_me/api/mawbd/?username=".env('ECOME_USERNAME','dfghj')."&password=".env("ECOME_PASSWORD","dfgh")."&awb=".$awb;
        $client = new Client([
                'verify' => false,
                "headers"=>[
                    'Content-Type'=>'application/json'
                ]
            ]);
        $response = $client->request('GET',$url);

        $xml=simplexml_load_string($response->getBody()) or die("Error: Cannot create object");
        $scansXML = $xml->object->field[36];
        $expected_date = $xml->object->field[18];
        $scans = [];
        if(!isset($scansXML) || empty($scansXML)){
            if(!$order){
                return abort(404,'Order not found');
            }
            
            return abort(404,"Shipment doesn't exists");
        }
        foreach($scansXML as $scanfield){
            $scan = $scanfield->field;
            $scanArr = [
                            'updated_on' => trim((string)$scan[0]),
                            'status'=> trim((string)$scan[1]),
                            'reason_code'=>trim((string)$scan[2]),
                            'reason_code_number'=>trim((string)$scan[3]),
                            'scan_status'=> trim((string)$scan[4]),
                            'location'=>trim((string)$scan[5]),
                            'location_city'=>trim((string)$scan[6]),
                            'location_type'=>trim((string)$scan[7]),
                            'city_name'=>trim((string)$scan[8]),
                            'Employee'=>trim((string)$scan[9]),
                        ];
            $scans[] = $scanArr;
        }
        
        return view('order.status',["service"=>"ecom_express","scans"=>$scans,"awb"=>$awb,"order"=>$order,"expected_date"=>$expected_date]);
    }
    
    public function getStatusDV($awb){
        $token = env('DELIVEY_TOKEN','asdfgh');
        $verbose = 2;
        $url ='https://track.delhivery.com/api/v1/packages/json/?waybill='.$awb.'&verbose=2&token='.$token;
        $client = new Client([
            'verify' => false,
        ]);
        $response = $client->request('GET', $url);
        $res = json_decode((string) $response->getBody());
        $scans = [];
        foreach($res->ShipmentData[0]->Shipment->Scans as $scan){
            $dt = new Carbon($scan->ScanDetail->ScanDateTime);
            $updated_on = $dt->format('jS M,Y h:i A');
            $scan->ScanDetail->ScanDateTime = $updated_on;
            $scans[] = (array)$scan->ScanDetail;
        }
        $scans = array_reverse($scans);
        //dd($scans);
        $order = Order::where('trackingNo',$awb)->first();
        return view('order.status',["service"=>"delhivery","scans"=>$scans,"awb"=>$awb,"order"=>$order]);
    }

    public function cancelDelhiveryOrder($awb)
    {
        $client = new Client([
            'verify' => false,
            "headers"=>[
                'Content-Type'=>'text/plain',
                'Authorization'=>'Token '.env('DELIVEY_TOKEN','asdfgh')
            ]
        ]);
        $url = 'https://staging-express.delhivery.com/api/p/edit';
        $post_data = '{"waybill":"'.$awb.'","cancellation":"true"}';
        $response = $client->request('POST',$url, [
            'body' => $post_data
        ]);          
        $res = $response->getBody();
        if(isset($res['status']) && $res['status'] == true){
            $order = Order::where('trackingNo',$awb)->first();
            $order->status = 7;
            $order->save();
            return back()->with('status', $res['remark']);
        }
        return back()->with('error', "oops! something went wrong");
    }

    public function cancelEcomOrder($awb)
    {
        $cancel_url = "https://api.ecomexpress.in/apiv2/cancel_awb?username=".env('ECOME_USERNAME','dfghj')."&password=".env('ECOME_PASSWORD','dfgh')."&awbs=".$awb;
        $client = new Client([
            'verify' => false,
            "headers"=>[
                'Content-Type'=>'application/json'
            ]
        ]);
        $response = $client->request('POST',$cancel_url, [
            'form_params' => [
                'username'=>env("ECOME_USERNAME","dfgh"),
                'password'=>env("ECOME_PASSWORD","dfgh"),
                'awbs'=>"$awb"
            ]
        ]);

        $res = json_decode($response->getBody());
        $res = $res[0];
        if(isset($res['success']) && $res['success'] == true)
        {
            $order = Order::where('trackingNo',$awb)->first();
            $order->status = 7;
            $order->save();
            return back()->with('status', 'Order cancel successfully.');
        }
        return back()->with('error', $res['reason']);
    }
}