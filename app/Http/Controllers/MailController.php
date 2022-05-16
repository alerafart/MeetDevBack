<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
//use App\Mail\ContactUser;
use App\Mail\SendEmail;
use App\Models\Users;
//use App\Models\Subscriber;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class MailController extends Controller
{
    public function send(Request $request)
    {
        //public function mail()

        /*$name = 'Cloudways';
        Mail::to('Cloudways@Cloudways.com')->send(new SendMailable($name));*/

        /*$to_name = 'georges';
        $to_email = 'milekic.alicia@gmail.com';
        $data = array('name'=>"Cloudways (sender_name)", "body" => "A test mail");

        Mail::send('mail', $data, function($message) use ($to_name, $to_email) {
        $message->to($to_email, $to_name)
        ->subject('Laravel Test Mail');
        $message->from('meetdev.apollo22@gmail.com','Test Mail');
        });*/
        $email = $request->email;
        Mail::to($email)->send(new SendEmail($email));

        return response()->json(['status' => 'success', 'message' =>  'Email sent Successfully', 'data' => $email]);
    }



    public function hello()
    {
        return response()->json('hello');
    }

    public function contactUser(Request $request)
    {
        $senderId = $request->sender_user_id;
        $receiverId = $request->receiver_user_id;
        $messageContent = $request->message_content;

        $senderInfo = Users::where('id', '=', $senderId)->select('firstname', 'email_address')->get();
        $receiverInfo = Users::where('id', '=', $receiverId)->select('firstname', 'email_address')->get();

        foreach ($senderInfo as $si) {
            $senderName=$si->firstname;
            $senderMail=$si->email_address;
        }
        foreach ($receiverInfo as $ri) {
            $receiverName=$ri->firstname;
            $receiverMail=$ri->email_address;
        }


        $monEmail = 'milekic.alicia@gmail.com';
        Mail::to($monEmail)->send(new SendEmail($monEmail, $senderName, $senderMail, $receiverName, $receiverMail, $messageContent));

        return response()->json(['status' => 'success', 'message' =>  'Email sent Successfully', 'data' => $monEmail]);
    }
}
