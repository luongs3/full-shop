<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Support\Facades\Redirect;
use Input;
use Auth;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;
    protected $redirectPath = '/';
    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
//    role: 1=admin, 2=contributor, 3=guest
    protected function validator(array $data){
        return Validator::make($data, [
            'name' => 'max:60',
            'address' => '',
            'role' => 'in:admin,user',
            'status' => 'between:0,1',
            'phone_number' => '',
            'email' => 'required|email|max:100|unique:users',
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required|alpha_num|between:6,30',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data){
        isset($data['role']) or $data['role'] = 'user';
        isset($data['status']) or $data['status'] = 1;
        return User::create([
            'name' => array_get($data,'name'),
            'email' => $data['email'],
            'address' => array_get($data,'address'),
            'phone_number' => array_get($data,'phone_number'),
            'role' => $data['role'],
            'status' => $data['status'],
            'password' => bcrypt($data['password']),
        ]);
    }
}
