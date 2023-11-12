<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index(Request $request)
    {
        if($request->method() == 'GET'){
            $charge = Setting::where('name','charge')->first();
            return view('setting',compact('charge'));
        }
        
        $setting = Setting::where('name',$request->name)->first();
        if(!$setting){
            $setting = new Setting;
        }
        $setting->name = $request->name;
        $setting->value = $request->value;
        $setting->save();
        return back()->with('message', 'Change successfully.');
    }

    public function create()
    {
        //
    }
}
