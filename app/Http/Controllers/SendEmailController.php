<?php

namespace App\Http\Controllers;

use App\Mail\SetEmailData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Redirect;

class SendEmailController extends Controller
{
    public function __construct()
    {
    }

   
    function sendMail(Request $request)
    {

        $data = $request->all();
        $subject = (@$data['subject']) ? $data['subject'] : "New inquiry from customer";
        $message = (@$data['message']) ? urldecode(base64_decode($data['message'])) : "";
        $recipients = (@$data['recipients']) ? $data['recipients'] : $data['email'];
        
        Mail::to($recipients)->send(new SetEmailData($subject, $message));

        return redirect()->back()->with("success_contact", "email sent successfully!");
    }
}

?>