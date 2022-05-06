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
            $users->city = $request ->city;
            $users->zip_code = $request ->zip_code;
            $users->email_address = $request->email_address;
            $users->password = $request ->password;
            $users->phone = $request ->phone;
            // $users->dev_id = $request->dev_id;
            // $users->recrut_id = $request ->recrut_id;
            $users->subscribe_to_push_notif = $request->subscribe_to_push_notif;
            $users->profile_picture = $request ->profile_picture;

            if ($users->save()) {
                return response()->json(['status' => 'success', 'message' => 'User created successfully']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function update(Request $request, $id){
        try {
            $users = Users::findOrFail($id);
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
                return response()->json(['status' => 'success', 'message' =>'User updated successfully' ]);
            }

        } catch(\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }

    }

    public function delete($id) {

        try {
            $users = Users::findOrFail($id);

            if ($users->delete()) {
                return response()->json(['status' => 'succes', 'message' => 'User deleted succesfully']);
            }
        } catch(\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
