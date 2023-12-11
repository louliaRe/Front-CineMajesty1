<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request; // Import the correct Request class

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated(Request $request, $user)
    {
        if ($user->R_id === 1) { // Replace with your role-checking logic
            return redirect('/admin'); // Redirect admins to the admin dashboard
        } elseif ($user->R_id === 2) { // Replace with your role-checking logic
            return redirect('/manager');// Redirect managers to the manager dashboard
        } elseif ($user->R_id === 3) { // Replace with your role-checking logic
            return redirect('/employee');// Redirect employees to their dashboard
        } elseif ($user->R_id === 4) {
            return redirect('/'); // Default redirection for regular users
        }
    }
}