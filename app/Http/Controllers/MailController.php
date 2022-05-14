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

        $to_name = 'georges';
        $to_email = 'milekic.alicia@gmail.com';
        $data = array('name'=>"Cloudways (sender_name)", "body" => "A test mail");

        Mail::send('mail', $data, function($message) use ($to_name, $to_email) {
        $message->to($to_email, $to_name)
        ->subject('Laravel Test Mail');
        $message->from('meetdev.apollo22@gmail.com','Test Mail');
        });

        return response()->json(['status' => 'success', 'message' =>  'Email sent Successfully', 'data' => $data]);
    }



        public function hello()
        {
            return response()->json('hello');
        }
}
