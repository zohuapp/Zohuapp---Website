<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**       
 * Display a listing of the resource.
 *
 * @param  Illuminate\Http\Request $request
 * @return Response
 */

class ContactUsController extends Controller
{
    public function __construct()
    {
    	
    }
	
    public function index()
    {
        return view('contact_us.contact_us');
    }
  
   
    
}
