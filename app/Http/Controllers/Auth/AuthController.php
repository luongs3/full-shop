<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use Input;
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
    protected function validator(array $data){
        return Validator::make($data, [
            'name' => 'max:60',
            'address' => '',
            'role' => 'in:admin,user',
            'status' => 'in:0,1',
            'phone_number' => '',
            'email' => 'required|email|max:100|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data){
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
    public function postRegister()
    {
        $input = Input::all();
        if (array_get($input,'secret_key')=="10201994") {
            $input['role'] = 'admin';
            $input['status'] = 1;
            $validator = $this->validator($input);

            if ($validator->fails()) {
                $this->throwValidationException(
                    $input, $validator
                );
            }
            $this->login($this->create($input));
            return redirect($this->redirectPath());
        }
        else return redirect()->route('auth.register')->with('error',trans('message.secret_key_not_valid'));
    }
}
