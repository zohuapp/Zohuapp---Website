<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CmsController extends Controller
{
	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    	
    }
	
    public function index($slug)
    {
        return view('cms.index',['slug'=>$slug]);
    }
	
	public function privacypolicy()
    {
        return view('static.privacypolicy');
    }

    public function refundpolicy()
    {
        return view('static.refundpolicy');
    }

    public function aboutus()
    {
        return view('static.aboutus');
    }

    public function help()
    {
        return view('static.help');
    }
	
	public function termsofuse()
    {
        return view('static.termsofuse');
    }
	
	public function deliveryofsupport()
    {
        return view('static.deliveryofsupport');
    }
}
