<?php

namespace App\Http\Controllers;

use App\Models\Query;
use Illuminate\Http\Request;
use Carbon\Carbon;
use GuzzleHttp\Client;

class FrontendController extends Controller
{
    public function query(Request $request)
    {
        $query = new Query;
        $query->name = $request->name;
        $query->phone = $request->phone;
        $query->email = $request->email;
        $query->subject = $request->subject;
        $query->message = $request->message;
        $query->save();
        return back()->with('status','Query Send Successfully.');
    }
}