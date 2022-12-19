<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function create() 
    {
        return view('auth/login');
    }
    
    public function store(Request $request)
    {

         $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $remember_me  = ( !empty( $request->remember_me ) )? TRUE : FALSE;
   
        $credentials = $request->only('email', 'password');
        $user = User::where(["email" => $credentials['email']])->first();
        // if($user->status == 0) { //in-active
        //     return redirect()->back()->with('error', 'You account has been deactivated, kindly contact admin');
        // }

        if (Auth::attempt($credentials)) {
            Auth::login($user, $remember_me);
        }
        return redirect("login")->withInput()->with('error', 'You have entered invalid credentials');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

}
