<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    // use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }

    /**
     * Show the login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

     /**
     * Check the user authentication.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function authenticate(Request $request)
     {
        $rules = [
            'email' => 'required|email',
            'password' =>'required'
        ];

        $validator = \Validator::make($request->all(),$rules);
        if($validator->fails()){
            return redirect()->back()->withInput($request->all)->withErrors($validator->getMessageBag());
        }

        $email = $request->email;
        $password = $request->password;
        $remember = $request->remember;

        // if(Auth::attempt(['email'=>$email,'password'=>$password,'status'=>1,'is_verified'=>1],$remember))
        if(Auth::attempt(['email'=>$email,'password'=>$password],$remember)){
            return redirect('admin/dashboard')->with('success','Welcome to dashboard');
        }

        if(Auth::attempt(['email'=>$email,'password'=>$password],$remember)){
            Auth::logout();
            return redirect()->back()->with('error','Your account is deactivated');
        }
        else{
            return redirect()->back()->with('error','Wrong Credentials')->withInput($request->all());
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
