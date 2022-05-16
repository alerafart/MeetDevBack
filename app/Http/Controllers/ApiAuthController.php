<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\Client;

class ApiAuthController extends Controller
{

        public function register(Request $request)
        {
            $data = $request->validate([
                //'name' => 'required|max:255',
                'email' => 'required|email|unique:users',
                'password' => 'required|confirmed'
            ]);

            $data['password'] = Hash::make($request->password);

            $user = User::create($data);

            $token = $user->createToken('API Token')->accessToken;

            return response([ 'user' => $user, 'token' => $token]);
        }

        public function login(Request $request)
        {
           /* $email = $request->email;
            $pass = $request->password;

            if (!auth()->attempt($email, $pass)) {
                return response(['error_message' => 'Incorrect Details.
                Please try again']);
            }

            $token = auth()->user()->createToken('API Token')->accessToken;

            return response(['user' => auth()->user(), 'token' => $token]);*/



        $email = $request->email;
        $password = $request->password;

        // Check if field is not empty
        /*if (empty($email) OR empty($password)) {
            return response() ->json(['status' => 'error', 'message' => 'You must fill all fields']);
        }*/

        $client = new Client();

        try {
            return $client->post('http://localhost:8080/v1/oauth/token', [
                    "form_params" => [
                        "client_secret"=>"EiqRpP5ZXH5UCqzWXDdje3KCsQnb4sR7Q1XdDoHT",
                        "grant_type"=>"password",
                        "client_id"=>2,
                        "username"=> $request->email,
                        "password"=>$request->password
                    ]
                ]);
        } catch (\Exception $e) {
            return response()->json([ 'status' => 'error', 'message' =>$e->getMessage()]);
        }
    }


}

