<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {}

    public function login()
    {
        dd("Creating");

        if (Auth::check()) {
            return redirect(route('profile'));
        } else {
            return view('auth.login');
        }
    }

    public function signup()
    {
        dd("Creating");

        if (Auth::check()) {
            return redirect(route('profile'));
        } else {
            return view('auth.signup');
        }
    }
}
