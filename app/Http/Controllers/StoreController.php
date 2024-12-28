<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class StoreController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function categoryList()
    {
        return view('store.categorylist');
    }

}
