<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Client;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'min:10'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            /*'address' => ['required', 'string', 'max:255'],
            'pin' => ['required', 'string', 'min:6', 'max:6'],
            'city' => ['required'],
            'state' => ['required'],
            'country' => ['required'],
            'returnadd' => ['required'],
            'ac_name' => ['required'],
            'ac_no' => ['required'],
            'ac_ifsc' => ['required'],
            'bank' => ['required'],*/
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            /*'address' => $data['address'],
            'pin' => $data['pin'],
            'city' => $data['city'],
            'state' => $data['state'],
            'country' => $data['country'],
            'returnadd' => $data['returnadd'],
            'ac_name' => $data['ac_name'],
            'ac_no' => $data['ac_no'],
            'ac_ifsc' => $data['ac_ifsc'],
            'bank' => $data['bank'],*/
            'password' => Hash::make($data['password']),
        ]);
    }
}
