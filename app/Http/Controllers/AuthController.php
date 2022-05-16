<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
// use Laravel\Passport\Bridge\Client;
//use Laravel\Passport\Client;
use App\Http\Controllers\Controller;
use GuzzleHttp\Exception\BadResponseException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $isDev = false;
        $isRecruiter = false;

        $email = $request->email;
        $password = $request->password;

        // Check if field is not empty
        if (empty($email) OR empty($password)) {
            return response() ->json(['status' => 'error', 'message' => 'You must fill all fields']);
        }

        $client = new Client();

        try {
            return $client->post('http://localhost:8080/v1/oauth/token', [
                    "form_params" => [
                        "client_secret"=>"R5xqI7BVQphRJfhzf0OeUHeNrdCpUtAnyC1aV0hG",
                        "grant_type"=>"password",
                        "client_id"=>2,
                        "username"=> $request->email,
                        "password"=>$request->password
                    ]
                ]);
        } catch (BadResponseException $e) {
            return response()->json([ 'status' => 'error', 'message' =>$e->getMessage()]);
        }
    }
}
