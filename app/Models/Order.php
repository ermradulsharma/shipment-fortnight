<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use GuzzleHttp\Client;

class Order extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class,'userid');
    }

    public function ecome()
    {
        return $this->belongsTo(Ecome::class, 'pin', 'pincode');
    }

    public function calculateamount()
    {
        $order = $this;

        $url ='https://track.delhivery.com/api/kinko/v1/invoice/charges/.json?md=S&cgm='.$order->weight.'&o_pin='.$order->user->pin.'&d_pin='.$order->pin.'&ss=Delivered';
            $client = new Client([
                'verify' => false,
                "headers"=>[
                    'Content-Type'=>'application/json',
                    'Authorization'=>'Token '.env('DELIVEY_TOKEN','asdfgh')
                ]
            ]);
            $response = $client->request('GET', $url);
            $res = json_decode((string) $response->getBody());

            if($res[0]->status=='Delivered'){
                return $res[0];//$amount =$res[0]->total_amount;
            }
        return 'error';
    }
    //fetch DV Tracking No
    public function fetchDVTrackingNo()
    {
        $order = $this;
        if($order->trackingNo != NULL || !empty(trim($order->trackingNo))){
            return ['orderid'=>$order->id,'trackingNo'=>$order->trackingNo];
        }
        $url = "https://track.delhivery.com/api/cmu/create.json";

        $post_data = 'data={
            "pickup_location": {
                "pin":"'.$order->user->pin.'",
                "add":"'.$order->user->address.'",
                "phone":"'.$order->user->phone.'",
                "state":"'.$order->user->state.'",
                "city":"'.$order->user->city.'",
                "country":"'.$order->user->country.'",
                "name":"'.$order->user->email.'"
            },
            "shipments": [{
                "order":"'.$order->orderid.'",
                "phone":"'.$order->phone.'",
                "products_desc":"'.$order->products_desc.'",
                "cod_amount":"'.$order->price.'",
                "name":"'.$order->name.'",
                "country":"'.$order->country.'",
                "seller_inv_date":"'.$order->date.'",
                "order_date":"'.$order->created_at.'",
                "total_amount":"",
                "seller_add":"",
                "seller_cst":"",
                "add":"'.$order->address.'",
                "seller_name":"",
                "seller_inv":"",
                "seller_tin":"",
                "pin":"'.$order->pin.'",
                "quantity":"'.$order->quantity.'",
                "payment_mode":"'.$order->paymenttype.'",
                "state":"'.$order->state.'",
                "city":"'.$order->city.'",
                "weight":"'.$order->weight.'",
                "shipment_height":'.$order->height.',
                "shipment_width":'.$order->breadth.',
                "shipment_length":'.$order->length.'
            }]
            }';
            $post_data = preg_replace("/[\n\r&#%$;]/","",$post_data);
            $post_data = 'format=json&'.$post_data;
            //dd($post_data);

        $client = new Client([
            'verify' => false,
            "headers"=>[
                'Content-Type'=>'text/plain',
                'Authorization'=>'Token '.env('DELIVEY_TOKEN','asdfgh')
            ]
        ]);

        $response = $client->request('POST',$url, [
            'body' => $post_data
        ]);
        $res = json_decode((string) $response->getBody());
        if(!empty($res->packages)){
            $package = $res->packages[0];
            $awb = $package->waybill;
            if(!empty($awb) && $order->trackingNo == NULL){
                $order->trackingNo = $awb;
                $order->status = 2;
                $order->manifested_at = Carbon::now('Asia/Kolkata');
                $order->save();
                return 'success';
            }
            if($package->status != 'Fail'){
                return 'success';
            }
            return $package->remarks[0];
        }else{
           return $res->rmk;
        }

    }
    // update DV status

    public static function getDVOrderStatus()
    {
        $tokens = [1=> env('DELIVEY_TOKEN','asdfgh'),2=> env('DELIVEY_OLD_TOKEN','asdfgh')];
        foreach ($tokens as $company_id => $token) {
            self::getDVOrderStatusByToken($token);
        }
    }

    public static function getDVOrderStatusByToken($token)
    {
        $orderchunks = self::whereIn('status',[2,3])->where('sendBy','Dehlivery')->whereNotNull('trackingNo')->get()->chunk(50);
        $statusArr = [
            'Manifested'=>2, //'successed'
            'In Transit'=>2,
            'Pending'=>2,
            'Dispatched'=>3,//out for delivery
            'Delivered'=>4,
            'RTO'=>5,//return
            'LOST'=>6//lost
        ];
        $statusArrReturn = [
            'In Transit'=>2,
            'Pending'=>2,
            'Dispatched'=>3,
            'DTO'=>3
        ];
        $verbose = 2;
        //iterate orderchunks
        foreach($orderchunks as $orderchunk){
            $waybillArr = $orderchunk->pluck('trackingNo')->toArray();
            $waybillString = implode(",",$waybillArr);
            $url ='https://track.delhivery.com/api/v1/packages/json/?waybill='.$waybillString.'&verbose=2&token='.$token;
            $client = new Client([
                'verify' => false,
            ]);

            $response = $client->request('GET', $url);
            $res = json_decode((string) $response->getBody());

            foreach($res->ShipmentData ?? [] as $shipment){
                $status = trim($shipment->Shipment->Status->Status);
                $status_type = trim($shipment->Shipment->Status->StatusType);
                $awb = $shipment->Shipment->AWB;
                $order = order::where('trackingNo',$awb)->first();

                if(in_array($status_type,["UD","DL"])){
                    if(isset($statusArr[$status])){
                        $order->status = $statusArr[$status];
                    }
                }elseif(in_array($status_type,["RT","RTO"])){
                    if(isset($statusArrReturn[$status])){
                        $order->status = $statusArrReturn[$status];
                    }
                }
                $order->save();
            }
        }
    }


    //fatch ecome 
    public function fetchECTrackingNo()
    {
        $order = $this;
        $fetch_awb_url = 'https://api.ecomexpress.in/apiv2/fetch_awb/';
        $manifest_awb_url = 'http://api.ecomexpress.in/apiv2/manifest_awb/';
        if($order->trackingNo != NULL || !empty(trim($order->trackingNo))){
            $awb = $order->trackingNo;
        }else{
            if($order->paymenttype == 'Prepaid'){
                $orderType = 'ppd';
            }else{
                $orderType = 'cod';
            }


            $client = new Client([
                'verify' => false,
                "headers"=>[
                    'Content-Type'=>'application/json'
                ]
            ]);
            $response = $client->request('POST',$fetch_awb_url, [
                'form_params' => [
                    'username'=>env("ECOME_USERNAME","dfgh"),
                    'password'=>env("ECOME_PASSWORD","dfgh"),
                    'count'=>1,
                    'type'=>$orderType
                ]
            ]);
    
            $res = json_decode($response->getBody());
            $awb = $res->awb[0];
        }
        //fetch awb number
    
        $json_input = '
        [
            {
            "AWB_NUMBER": "'.$awb.'",
            "ORDER_NUMBER": "'.$order->orderid.'",
            "PRODUCT": "'.$orderType.'",
            "CONSIGNEE": "'.$order->name.'",
            "CONSIGNEE_ADDRESS1": "'.$order->address.'",
            "CONSIGNEE_ADDRESS2": "",
            "CONSIGNEE_ADDRESS3": "",
            "DESTINATION_CITY": "",
            "PINCODE": "'.$order->pin.'",
            "STATE": "",
            "MOBILE": "'.$order->phone.'",
            "TELEPHONE": "",
            "ITEM_DESCRIPTION": "'.$order->products_desc.'",
            "PIECES": '.$order->quantity.',
            "COLLECTABLE_VALUE": '.$order->price.',
            "DECLARED_VALUE": '.$order->price.',
            "ACTUAL_WEIGHT": '.($order->weight/1000).',
            "VOLUMETRIC_WEIGHT": '.($order->weight/1000).',
            "LENGTH": '.$order->length.',
            "BREADTH": '.$order->breadth.',
            "HEIGHT": '.$order->height.',
            "PICKUP_NAME": "'.$order->user->name.'",
            "PICKUP_ADDRESS_LINE1": "'.$order->user->address.'",
            "PICKUP_ADDRESS_LINE2": "'.$order->user->address.'",
            "PICKUP_PINCODE": "'.$order->user->pin.'",
            "PICKUP_PHONE": "'.$order->user->phone.'",
            "PICKUP_MOBILE": "'.$order->user->phone.'",
            "RETURN_NAME": "'.$order->user->name.'",
            "RETURN_ADDRESS_LINE1": "'.$order->user->address.'",
            "RETURN_ADDRESS_LINE2": "'.$order->user->address.'",
            "RETURN_PINCODE": "'.$order->user->pin.'",
            "RETURN_PHONE": "'.$order->user->phone.'",
            "RETURN_MOBILE": "'.$order->user->phone.'",
            "ADDONSERVICE": [""],
            "DG_SHIPMENT": "false",
            "ADDITIONAL_INFORMATION": {
            "DELIVERY_TYPE": "",
            "SELLER_TIN": "",
            "INVOICE_NUMBER": "'.$order->orderid.'",
            "INVOICE_DATE": "'.$order->date.'",
            "ESUGAM_NUMBER": "",
            "ITEM_CATEGORY": "",
            "PACKING_TYPE": "",
            "PICKUP_TYPE": "",
            "RETURN_TYPE": "",
            "CONSIGNEE_ADDRESS_TYPE": "",
            "PICKUP_LOCATION_CODE": "",
            "SELLER_GSTIN": "",
            "GST_HSN": "",
            "GST_ERN": "",
            "GST_TAX_NAME": "",
            "GST_TAX_BASE": "",
            "DISCOUNT": "",
            "GST_TAX_RATE_CGSTN": "",
            "GST_TAX_RATE_SGSTN": "",
            "GST_TAX_RATE_IGSTN": "",
            "GST_TAX_TOTAL": "",
            "GST_TAX_CGSTN": "",
            "GST_TAX_SGSTN": "",
            "GST_TAX_IGSTN": "" }}]
        ';
        $json_input = preg_replace("/[\n\r&#%$;]/","",$json_input);
        $manifest_client = new Client([
            'verify'=> false,
            'headers'=>[
                'Content-Type'=>'application/x-www-form-urlencoded'
            ]
        ]);
        $manifest_response = $manifest_client->request('POST',$manifest_awb_url, [
            'form_params' => [
                'username'=>env("ECOME_USERNAME","dfgh"),
                'password'=>env("ECOME_PASSWORD","dfgh"),
                'json_input'=>$json_input
            ]
        ]);
        $manifest_res = json_decode($manifest_response->getBody());
        $shipment = $manifest_res->shipments[0];
        $manifest_awb = $shipment->awb;
        if($shipment->success){
            $order->trackingNo = (string)$awb;
            $order->status = 2;
            $order->manifested_at = Carbon::now('Asia/Kolkata');
            $order->save();
            return 'success';
        }
        return $shipment->reason;
    }
    //ecome status
    public static function getECOrderStatus()
    {
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
            "225","226","227","228","229","231","232","233","234","235","236","237","238","242",
            "331","332","333","666","888","218","219","220","1224","1225",
            "77","80","82","83",
            "23201","23202"
        ];
        $return_initiated = ["777"];

        $orderchunks = self::whereIn('status',[2,3])->where('sendBy','Ecome')->whereNotNull('trackingNo')->get()->chunk(50);
        
        foreach($orderchunks as $orderchunk){
            $waybillArr = $orderchunk->pluck('trackingNo')->toArray();
            $waybillString = implode(",",$waybillArr);
            //dd($waybillString);
            $url = 'https://plapi.ecomexpress.in/track_me/api/mawbd/?username='.env("ECOME_USERNAME","dfgh").'&password='.env("ECOME_PASSWORD","dfgh").'&order=&awb='.$waybillString;
            $client = new Client([
                'verify' => false,
                "headers"=>[
                    'Content-Type'=>'application/json'
                ]
            ]);
            $response = $client->request('GET',$url);
            // $res = json_decode($response->getBody());
            libxml_use_internal_errors(true);
            $xml=simplexml_load_string($response->getBody()); //or die("Error: Cannot create object");
            //dd((String)($xml->object[0]->field[0]));//status is index 14 & waybill is index 0
            // if (true === $xml) {
               foreach($xml->object as $object){
                    $awb = (String) $object->field[0];
                    $ref_awb = trim((String) $object->field[22]);
                    $reason_code_number = trim((String) $object->field[14]);
                    $rts_reason_code_number = trim((String) $object->field[26]);
                    $last_scan = $object->field[36]->object[0]->field[3];
                    $status_code = $reason_code_number; //trim((String) $last_scan);
                    $update_date = trim((String) $object->field[20]);//trim((String)$last_scan_date);
                    
                    $order = order::where('trackingNo',$awb)->first();
                    
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
                        $order->trackingNo = $ref_awb;
                    }
                    
                   // $order->status_code = (String)$status_code;
                    $order->updated_at = Carbon::createFromFormat('d-M-Y H:i',$update_date)->toDateTimeString();
                    $order->save();
                } 
            // }
        }
    }
}
