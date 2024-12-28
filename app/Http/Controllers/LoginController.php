<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }
    
	public function login()
    {
        if (\Auth::check()){
        	return redirect(route('profile'));
        }else{
        	return view('auth.loginuser');
        }
    }
	
	public function signup()
    {
        if (\Auth::check()){
        	return redirect(route('profile'));
        }else{
        	return view('auth.signup');
        }
    }
}
