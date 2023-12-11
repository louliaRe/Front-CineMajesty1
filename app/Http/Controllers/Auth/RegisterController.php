<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request; 
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
    protected $redirectTo = '/';

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
            'f_name' => ['required', 'string', 'max:255'],
            'l_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'age' => ['required', 'integer'],
            'gender' => ['required', 'string', 'min:3'],
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
    $role_id=4;
    $user= User::create([
        'R_id'=> $role_id,
        'name' => $data['f_name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password']),
       
    ]);
    $role_id=4;

    $customer=Customer::create([
        'R_id'=> $role_id,
        'f_name' => $data['f_name'],
        'l_name' => $data['l_name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password']),
        'age' => $data['age'],
        'gender' => $data['gender'],
    ]);
    return $user;
}
protected function authenticated(Request $request, $user)
{
    if ($user->R_id === 4) { // Replace with your role-checking logic
        return redirect('/'); // Redirect admins to the admin dashboard
        }
}
}
