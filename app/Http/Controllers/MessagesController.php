<?php

namespace App\Http\Controllers;

use App\Models\Users;
use App\Models\Messages;
use App\Models\Developers;
use App\Models\Recruiters;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class MessagesController extends Controller
{
    /**
     * get all messages list
     *
     * @return void
     */
    public function list() {
        return Messages::all();
    }

    /**
     * get single message by id
     *
     * @param [int] $id
     * @return void
     */
    public function item($id){
        return Messages::whereId($id)->first();
    }

    /**
     * Create new message
     *
     * @param Request $request
     * @return void
     */
    public function create(Request $request) {

        try {
            $messages =new Messages();
            $messages->receiver_user_id = $request->receiver_user_id;
            $messages->sender_user_id = $request->sender_user_id;
            $messages->message_title = $request->title;
            $messages->message_content = $request->message_content;
            $messages->signature = $request->signature;

            if ($messages->save()) {
                return response()->json(['status' => 'success', 'message' => 'Message created successfully']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Update single message
     *
     * @param Request $request
     * @param [type] $id
     * @return void
     */
    public function update(Request $request, $id) {
        try {
            $messages =Messages::findOrFail($id);
            $messages->receiver_user_id = $request->receiver_user_id;
            $messages->sender_user_id = $request->sender_user_id;
            $messages->message_title = $request->title;
            $messages->message_content = $request->message_content;
            $messages->signature = $request->signature;

            if ($messages->save()) {
                return response()->json(['status' => 'success', 'message' => 'Message updated successfully']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Delete single message with id
     *
     * @param [int] $id
     * @return void
     */
    public function delete($id) {

        try {
            $messages = Messages::findOrFail($id);

            if ($messages->delete()) {
                return response()->json(['status' => 'success', 'message' => 'Message deleted succesfully']);
            }
        } catch(\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Retrieve all messages from One User using id and correspondent profile details
     *
     * @param [int] $id
     * @return void
     */
    public function getAllMessagesFromOneUser($id) {
        $messagesReceived = Messages::where('receiver_user_id','=', $id)->get();
        $messagesSent = Messages::where('sender_user_id','=', $id)->get();

        //this piece of code will check for all the $messagesReceived senders if they are a recruiter or a dev and depending of that, it will load all the data related to the user
        $sender =[];
        $senders = $messagesReceived->map(function($item) use ($id) {
            //if($item->receiver_user_id == $id){break;}

            $query = Users::query()->where("users.id", "=", $item->sender_user_id);
            $senderInfo = Users::where("users.id", "=", $item->sender_user_id)->first();
            $sender['userId'] = $senderInfo->id;

            if (isset($senderInfo->dev_id)) {
                $query->join("developers", "developers.id", "=", "users.dev_id");
            }
            if (isset($senderInfo->recrut_id)) {
                $query->join("recruiters", "recruiters.id", "=", "users.recrut_id");
            }
            $sender['$userDetails'] = $query->get();
            return $sender;
        });

        // and the same process here for the $messagesSent receivers
        $receiver = [];
        $receivers = $messagesSent->map(function($item) {
            //if($item->receiver_user_id == $id){break;}

            $query = Users::query()->where("users.id", "=", $item->receiver_user_id);
            $receiverInfo = Users::where("users.id", "=", $item->receiver_user_id)->first();
            $receiver['userId'] = $receiverInfo->id;

            if (isset($receiverInfo->dev_id)) {
                $query->join("developers", "developers.id", "=", "users.dev_id");
            }
            if (isset($receiverInfo->recrut_id)) {
                $query->join("recruiters", "recruiters.id", "=", "users.recrut_id");
            }
            $receiver['userDetails'] = $query->get();
            return $receiver;
        });

     return response()->json(['status' => 'success', 'receivedMessages' => $messagesReceived, 'sentMessages' => $messagesSent, 'sendersDetails' => $senders, 'receivers' => $receivers]);
 }

     /**
     * Retrieve one message send of a user profile using id and correspondent profile details
     *
     * @param [int] $id
     * @return void
     */
    public function getOneFromAUser(Request $request) {
        $currentUserId = $request->userId;
        $correspondantId = $request->correspondantId;
        $messageId = $request->messageId;

      //  $ms = $this->item($messageId);
        $message = Messages::findOrFail($messageId);

        //if($message->receiver_user_id === $currentUserId){

        $corres = Users::where("users.id", "=", $correspondantId)->first();
        $query = Users::query()->where("users.id", "=", $correspondantId);

        if (isset($corres->dev_id)) {
            $query->join("developers", "developers.id", "=", "users.dev_id");
        }
        if (isset($corres->recrut_id)) {
            $query->join("recruiters", "recruiters.id", "=", "users.recrut_id");
        }

        $sd = $query->get();

        return response()->json(['status' => 'success', 'message' => $message, 'receiver' => $sd]);
    }

    /**
     * Create new message from user
     *
     * @param Request $request
     * @return void
     */
    public function createMessageInDb(Request $request) {

        try {
            $messages = new Messages();
            $messages->sender_user_id = $request->sender_user_id;
            $messages->receiver_user_id = $request->receiver_user_id;
            $messages->message_title = $request->message_title;
            $messages->message_content = $request->message_content;
           // $messages->signature = $request->signature;

            if ($messages->save()) {
                return response()->json(['status' => 'success', 'message' => 'Message created successfully', 'created message' => $messages]);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
