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
     * Retrieve all messages from One User using id and correspondent profiles details
     *
     * @param [int] $id
     * @return void
     */
    public function getAllMessagesFromOneUser($id) {

        // case where our user is the receiver
        $messagesReceived = Messages::join('users', 'messages.receiver_user_id','=', 'users.id')
        ->where('users.id', '=', $id)
        ->get('messages.*');

        $senderId = $messagesReceived->pluck('sender_user_id')->unique();
        //return $senderId;
        $senderDetails = null;
        foreach ($senderId as $si) {

            $devId = Users::where('id', '=', $si)->get('dev_id');
            $query = Users::query()->where("users.id", "=", $si);
            //return $devId;
            if (isset($devId)) {


                $query->where("users.recrut_id", "=", null)
                    ->join("developers", function ($join) {
                        $join->on("developers.id", "=", "users.dev_id");
                    });

                $sd = $query->get();


            }

            $senderDetails = $sd;
            //return $sd;
        }





       /* $senderUser = $messagesUserReceiver->pluck('sender_user_id')->unique();
        foreach ($senderUser as $se) {
            /*$senderData = Users::join("developers", function($join) {
                $join->on("developers.id", "=", "users.dev_id");
            })
                ->whereNotNull("users.dev_id")
                ->where('users.id', '=', $se)
                ->get();*/



            /*$query = Users::query()->where("users.id", "=", $se);

            $query->where("users.recrut_id", "=", NULL)
                ->join("developers", function ($join){
                    $join->on("developers.id", "=", "users.dev_id");
                });


            $query->where("users.dev_id", "=", NULL)
            ->join("recruiters", function ($join){
                $join->on("recruiters.id", "=", "users.recrut_id");
            });

            $senderData = $query->get();
            return $senderData;


            $query->when("users.dev_id", "<>", "", function($join) {
                $join->on("developers.id", "=", "users.dev_id");
               // return $q->where("developers.id", "=", "users.dev_id")
            })
            ->where('users.id', '=', $se);

            $senderData = $query->get();

            return $senderData;
            }
            //->when('users.dev_id')
            return $senderData;





        $senderUser = $messagesUserReceiver->pluck('sender_user_id')->unique();
        foreach ($senderUser as $se) {
            $senderData = Users::join('developers', 'develop.id', '=', $se)->get();

        }

*/

       /* $senderData = [];
        $senderSpec = [];

        $senderUser = $messagesReceived->pluck('sender_user_id')->unique();
        foreach ($senderUser as $se) {
            $senderData = Users::where('id', '=', $se)->get();

            if (isset($senderData)) {
                $isDev = $senderData->pluck('dev_id');
                $isRecrut = $senderData->pluck('recrut_id');

                if (isset($isRecrut)) {
                    $recData = Recruiters::where('id', '=', $isRecrut)->get();
                    $senderSpec[] = $recData;
                } elseif (isset($isDev)) {
                    $devData = Developers::where('id', '=', $isDev)->get();
                    $senderSpec[] = $devData;
                }
            }
        }

        // case in which our user is the sender
        $messagesSent = Messages::join('users', 'messages.sender_user_id','=', 'users.id')
        ->where('users.id', '=', $id)
        ->get('messages.*');

        $receiverUser = $messagesSent->pluck('receiver_user_id')->unique();
        foreach($receiverUser as $re){
            $receiverData = Users::where('users.id', '=', $re)->get();

            $isDev = $receiverData->pluck('dev_id');
            $isRecrut = $receiverData->pluck('recrut_id');

            $receiverSpec = [];
           // if ($id !== $receiverId) {
                if(isset($isRecrut)) {
                $recData = Recruiters::where('id', '=', $isRecrut)->get();
                $receiverSpec[] = $recData;
                }
                elseif (isset($isDev)) {
                    $devData = Developers::where('id', '=', $isDev)->get();
                    $receiverSpec[] = $devData;
                    return $receiverSpec;
                }
                //return $receiverData;
            //}
        }*/

    return response()->json(['status' => 'success', 'receivedMessages' => $messagesReceived, 'senderDetails' => $senderDetails /*'sentMessages' => $messagesSent ,'receiverUsersDetails' => $receiverData, 'senderSpec' =>  $receiverSpec, 'senderUsersDetails' => $senderData, 'senderSpec' => $senderSpec*/]);
    }

     /**
     * Retrieve one message send of a user profile using id and correspondent profile details
     *
     * @param [int] $id
     * @return void
     */
    public function getOneFromAUser(Request $request) {
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
            $messages->message_title = $request->message_title;
            $messages->message_content = $request->message_content;
           // $messages->signature = $request->signature;

            if ($messages->save()) {
                return response()->json(['status' => 'success', 'message' => 'Message created successfully', 'createdMessage' => $messages]);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
