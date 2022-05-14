<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Mail\ContactUser;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function send()
    {
        //public function mail()

        /*$name = 'Cloudways';
        Mail::to('Cloudways@Cloudways.com')->send(new SendMailable($name));*/

        $to_name = 'RECEIVER_NAME';
        $to_email = 'RECEIVER_EMAIL_ADDRESS';
        $data = array('name'=>"Cloudways (sender_name)", "body" => "A test mail");

        Mail::send('mail', $data, function($message) use ($to_name, $to_email) {
        $message->to($to_email, $to_name)
        ->subject('Laravel Test Mail');
        $message->from('SENDER_EMAIL_ADDRESS','Test Mail');
        });

        return response()->json(['status' => 'success', 'message' =>  'Email sent Successfully']);
    }



        public function hello()
        {
            return response()->json('hello');
        }
}
