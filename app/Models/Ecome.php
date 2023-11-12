<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Auth;
class Ecome extends Model
{
    use HasFactory;
    protected $fillable = [
        'pincode',
        'region',
        'reg_code',
        'city',
        'code',
        'state',
        'dc_code',
        'service',
        'area',
    ];

    static function calculationEcome($order)
    {
        $pincode_url = "https://ratecard.ecomexpress.in/services/rateCalculatorAPI/";
        $client = new Client([
            'verify' => false,
            "headers"=>[
                'Content-Type'=>'application/json'
            ]
        ]);
        if($order->paymenttype == 'Prepaid'){
            $orderType = 'ppd';
            $price = 0;
        }else{
            $orderType = 'cod';
            $price = $order->price;
        }
        $json_input = '[{
            "orginPincode": '.$order->user->pin.',
            "destinationPincode": '.$order->pin.',
            "productType": "'.$orderType.'",
            "chargeableWeight":'.($order->weight/1000).',
            "codAmount":'.$price.'
        }]';
        $json_input = preg_replace("/[\n\r&#%$;]/","",$json_input);
        $response = $client->request('POST',$pincode_url, [
            'form_params' => [
                'username'=>env("ECOME_USERNAME","dfgh"),
                'password'=>env("ECOME_PASSWORD","dfgh"),
                'json_input' => $json_input
            ]
        ]);

        $res = json_decode($response->getBody());
        $charge = $res[0]->chargesBreakup->total_charge ?? null;
        if($charge > 0) {
            return $charge = $charge+10;
        }
        return null;
    }

    static function calculationDelivery($order)
    {
        $url ='https://track.delhivery.com/api/kinko/v1/invoice/charges/.json?md=E&cgm='.$order->weight.'&o_pin='.$order->user->pin.'&d_pin='.$order->pin.'&ss=Delivered';
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
        if($res[0]->status=='Delivered' && $order->paymenttype == 'COD'){
            $cod = $res['0']->charge_COD;
            if($order->price > 0){
                if($order->price<=1000){
                    $cod += 40;
                }else{
                    $cod += ($order->price*2)/100;
                }
                $gst = (($cod+10)*18)/100;
            }
        }
        $res = $res[0];
        return $res->total_amount+$cod+$gst+10+$res->charge_FS;
    }
}
