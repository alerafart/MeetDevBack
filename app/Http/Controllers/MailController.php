<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Mail\SendEmail;
use App\Models\Users;
use App\Http\Controllers\Messages;
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


    /**
     * This function will be called when a user will send a message to another user. This will trigger a new email to be send and stock the message in the database
     *
     * @param Request $request
     * @return void
     */
    public function contactUser(Request $request)
    {
        $msgCtrl = new MessagesController;

        $senderId = $request->sender_user_id;
        $receiverId = $request->receiver_user_id;
        $messageTitle = $request->message_title;
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

        $testEmail = $request->testEmail ;
        Mail::to($testEmail)->send(new SendEmail($testEmail, $senderName, $senderMail, $receiverName, $receiverMail, $messageTitle, $messageContent));

       $msg = $msgCtrl->createMessageInDbFromUser($request);
       if ($msg) {
        return response()->json(['status' => 'success', 'message' =>  'Email sent Successfully', 'data' => $testEmail]);
       }
    }
}
