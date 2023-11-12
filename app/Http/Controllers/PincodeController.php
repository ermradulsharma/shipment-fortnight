<?php

namespace App\Http\Controllers;

use App\Models\Pincode;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class PincodeController extends Controller
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
        if(Pincode::where('pin',$request->pincode)->exists()){
            return 'success';
        }else{
            return 'error';
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $url = "https://track.delhivery.com/c/api/pin-codes/json/?token=".env('DELIVEY_TOKEN','asdfgh');
        $client = new Client([
            'verify' => false,
            "headers"=>[
                'Content-Type'=>'application/json',
                'Authorization'=>'Token '.env('DELIVEY_TOKEN','asdfgh')
            ]
        ]);

        $response = $client->request('GET',$url);
        $res = json_decode((string) $response->getBody());
        Pincode::truncate();
        if(!empty($res)){
            $delivery_codes = $res->delivery_codes;
            foreach ($delivery_codes as $delivery_code) {
                $postal_code = $delivery_code->postal_code;
                Pincode::create([
                    'pin'=>$postal_code->pin,
                    'pre_paid'=>$postal_code->pre_paid,
                    'country_code'=>$postal_code->country_code,
                    'city'=>$postal_code->district,
                    'district'=>$postal_code->district,
                    'reverse_pickup'=>"Y",
                    'state_code'=>$postal_code->state_code,
                    'cod'=>$postal_code->cod,
                    'sort_code'=>$postal_code->sort_code,
                ]);
            }
        }

        return back()->with('status','Pincode Updated Successfully.');
    }

    public function check_pin_ecome_del(Request $request, $orderId)
    {
        $res = [];
        $delivery = Dehlivery::where('pin',$request->pincode)->first();
        if($delivery){
            
        }
        if(Ecome::where('pincode',$request->pincode)->exists()){
            $res[] = "Ecome";
        }
        return $res;
    }


}
