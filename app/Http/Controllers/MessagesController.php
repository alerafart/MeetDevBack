<?php

namespace App\Http\Controllers;

use App\Models\Users;
use App\Models\Messages;
use App\Models\Developers;
use App\Models\Recruiters;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Mime\Message;

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
     * Retrieve all messages from One User using id and correspondent prodile details
     *
     * @param [int] $id
     * @return void
     */
    public function getAllMessagesFromOneUser($id) {

        $messageUserReceiver = Messages::join('users', 'messages.receiver_user_id','=', 'users.id')
        ->where('users.id', '=', $id)
        ->get('messages.*');

        $senderUser = $messageUserReceiver->pluck('sender_user_id');
        $senderDetail = Users::where('users.id', '=', $senderUser)->get();

        // messages envoyés par notre utilisateur en param de la route
        $messagesUserSender = Messages::join('users', 'messages.sender_user_id','=', 'users.id')
        ->where('users.id', '=', $id)
        ->get('messages.*');

        $receivers = [];
        foreach($messagesUserSender as $msgSender){
            $recieverUser = $msgSender->receiver_user_id;
            $recieverDetail = Users::where('users.id', '=', $recieverUser)->get();
            $devId = $recieverDetail->pluck('dev_id');
            $recrutId = $recieverDetail->pluck('recrut_id');
            $receivers[] = $recieverDetail;

            /*if($devId) {
                $receiverDevDetails = Developers::where('dev_id', '=', $devId)->first();
                $receivers[] = $receiverDevDetails;
                //return $receivers;
            } elseif($recrutId){
                $receiverRecrutDetails = Recruiters::where('recrut_id', '=', $recrutId)->get('*');
                $receivers[] = $receiverRecrutDetails;
                //return $receivers;
            }*/

        }

        return response()->json(['status' => 'success', 'messages receiver' => $messageUserReceiver, 'messages sender' => $messagesUserSender ,'reciever_user_Detail'=>$receivers]);
    }

     /**
     * Retrieve one message send of a user profile using id and correspondent profile details
     *
     * @param [int] $id
     * @return void
     */
    public function getOneMessageFromAUser(Request $request) {
        $userId = $request->userId;
        $correspondantId = $request->correspondantId;


        $messageUserReceiver = Messages::join('users', 'messages.receiver_user_id','=', 'users.id')
        ->where('users.id', '=', $userId)
        ->get('messages.*');

        //$senderDetail = Users::where('users.id', '=', $correspondantId)->get();

        $messagesUserSender = Messages::join('users', 'messages.sender_user_id','=', 'users.id')
        ->where('users.id', '=', $userId)
        ->get('messages.*');

        //$recieverUser = $messagesUserSender->pluck('receiver_user_id');
        //$recieverDetail = Users::where('users.id', '=', $recieverUser)->get();

        return response()->json(['status' => 'success', 'receiver' => $messageUserReceiver ]);
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
            $messages->message_content = $request->message_content;
            $messages->signature = $request->signature;

            if ($messages->save()) {
                return response()->json(['status' => 'success', 'message' => 'Message created successfully', 'createdMessage' => $messages]);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
