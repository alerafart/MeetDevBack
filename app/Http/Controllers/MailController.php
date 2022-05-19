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

       $msg = $msgCtrl->createMessageInDb($request);
       if ($msg) {
        return response()->json(['status' => 'success', 'message' =>  'Email sent Successfully', 'data' => $testEmail]);
       }
    }
}
