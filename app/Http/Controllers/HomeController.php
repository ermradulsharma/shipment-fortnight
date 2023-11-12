<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Query;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $queries = Query::orderBy('id','desc')->take(500)->get();
        return view('dashboard',compact('queries'));
    }
    
    public function query_delete($id)
    {
        $query = Query::find($id)->delete();
        return back()->with('status','Query Deleted Successfully.');
    }
    
    
}
