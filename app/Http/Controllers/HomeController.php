<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $route = Route::currentRouteName();
        if (!isset($_COOKIE['address_name']) && $route != "set-location") {
            Redirect::to('set-location')->send();
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // $authUserName = Auth::user() !== null ? Auth::user()->name : null;
        // // dd(Auth::user()->vendorUser->uuid);
        // // exit;

        return view('home');
    }
    public function setLocation()
    {
        return view('layer');
    }
    public function notification()
    {
        return view('notification');
    }
    public function storeFirebaseService(Request $request)
    {
        if (!empty($request->serviceJson) && Storage::disk('local')->exists('firebase/credentials.json') == false) {
            Storage::disk('local')->put('firebase/credentials.json', file_get_contents(base64_decode($request->serviceJson)));
        }
    }
}
