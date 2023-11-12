<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ecome;
use App\Models\Order;
use App\Models\Pincode;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Exception;

class EcomeController extends Controller
{

    public function updateEcomePincode()
    {
        $last_update = Ecome::whereDate('updated_at','<',today()->subDay()->toDateString())->oldest()->first();
        if(empty($last_update)){
            $status =  "uptodate";
        }else{
            $this->updatePincodes();
            $status = 'updated';
        }
        return back();
    }

    public function updatePincodes()
    {
        $pincode_url = "https://api.ecomexpress.in/apiv2/pincodes/";
        $client = new Client([
            'verify' => false,
            "headers"=>[
                'Content-Type'=>'application/json'
            ]
        ]);
        $response = $client->request('POST',$pincode_url, [
            'form_params' => [
                'username'=>env("ECOME_USERNAME","dfgh"),
                'password'=>env("ECOME_PASSWORD","dfgh")
            ]
        ]);

        $res = json_decode($response->getBody());
        if(!empty($res))
        Ecome::truncate();
        foreach($res as $pin){
            $all_pincode = Ecome::create(
                [
                    'pincode' => $pin->pincode,
                    'region' => $pin->state_code,
                    'reg_code' => $pin->city_code,
                    'city' => $pin->city,
                    'code' => $pin->route,
                    'state' => $pin->state,
                    'dc_code' => $pin->dccode,
                    'service' => 'Y',
                    'area' => $pin->city_type,
                ]
            );               
        }

        return 'success';
    }

    public function calculationEcome(Request $request)
    {
        $res = [];
        $order = Order::find($request->orderId);
        $ecomeCheck = Ecome::where('pincode',$order->pin)->first();
        if($ecomeCheck){
            $ecome = Ecome::calculationEcome($order);
            $res['ecome'] = $ecome;
        }else{
            $res['ecome'] = null;
        }
        $dehliveryCheck = Pincode::where('pin',$order->pin)->first();
        if($dehliveryCheck){
                $dehlivery = Ecome::calculationDelivery($order);
            $res['dehlivery'] = $dehlivery;
        }else{
            $res['dehlivery'] = null;
        }
        return response()->json($res, 200);
    }

}
