<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function list(){
        return Users::all();
    }

    public function create(Request $request){
        try {
            $users = new Users();
            $users->lastname = $request->lastname;
            $users->firstname = $request ->firstname;
            $users->email_address = $request->email_address;
            $users->password = $request ->password;
            $users->phone = $request ->phone;
            // $users->dev_id = $request->dev_id;
            // $users->recrut_id = $request ->recrut_id;
            $users->subscribe_to_push_notif = $request->subscribe_to_push_notif;
            $users->profile_picture = $request ->profile_picture;

            if ($users->save()) {
                return response()->json(['status' => 'succes', 'message' => 'User created successfully']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

}
// return response()->json( Category::all() );
