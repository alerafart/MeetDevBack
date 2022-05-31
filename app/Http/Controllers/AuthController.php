<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Users;
use App\Models\Developers;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UsersController;
use App\Models\Recruiters;
use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Traits\MustVerifyEmail;

class AuthController extends Controller
{
    use MustVerifyEmail;

    /**
     * create a new AuthController instance
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['register', 'registerDev', 'registerRecrut', 'login', 'refresh', 'logout']]);
    }

    /**
     * Get a JWT via given credentials.
     * @param Illuminate\Http\Request;
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        // $credentials = $request->only(['email_address', 'password', 'access_token','token_type']);
        $credentials = $request->only(['email_address', 'password']);

        $user = Users::where('email_address', '=', $credentials['email_address'])->first();
        $isDev = false;
        $isRecruiter = false;

        if (! $token = auth()->attempt($credentials)) {
        return response()->json(['error' => 'Unauthorized', 'credentials' => $credentials], 401);
        }

        if(!empty($user->dev_id)) {
            $isDev = true;

            $dev_id = $user->dev_id;
            $dev = DB::table('developers')
            ->select('*')
            ->where('id', '=', $dev_id)
            ->get();

            return response()->json(['status' => 'success', 'message' => 'Login successfull', 'isDev' => $isDev, 'isRecruiter' => $isRecruiter, 'general' => $user, 'spec' => $dev, 'token' => $this->respondWithToken($token)]);
        } else if(!empty($user->recrut_id)) {
            $isRecruiter = true;

            $recrut_id = $user->recrut_id;
            $recrut = DB::table('recruiters')
            ->select('*')
            ->where('id', '=', $recrut_id)
            ->get();
            return response()->json(['status' => 'success', 'message' => 'Login successfull','isDev' => $isDev, 'isRecruiter' => $isRecruiter, 'general' => $user, 'spec' => $recrut,  'token' => $this->respondWithToken($token)]);
        }
    }

    /**
     * Get the authenticated User (full profile).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        $user = auth()->user();
        $query = Users::query()->where("users.id", "=", $user->id);

        if (isset($user->dev_id)) {
            $query->join("developers", "developers.id", "=", "users.dev_id");
        }
        if (isset($user->recrut_id)) {
            $query->join("recruiters", "recruiters.id", "=", "users.recrut_id");
        }

        $userDetails = $query->get();

        return response()->json(['userId' => $user->id, 'userDetails' => $userDetails]);
    }

    /**
     * Get the authenticated User (full profile) to reuse data in back-end.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function meNoJson()
    {
        $user = auth()->user();
        $query = Users::query()->where("users.id", "=", $user->id);

        if (isset($user->dev_id)) {
            $query->join("developers", "developers.id", "=", "users.dev_id");
        }
        if (isset($user->recrut_id)) {
            $query->join("recruiters", "recruiters.id", "=", "users.recrut_id");
        }

        $userDetails = $query->get();

        return $userDetails;
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }


    /**
     * New developer profile creation with JWT token send back in the response
     *
     * @param Request $request
     * @return object
     */
    public function registerDev(Request $request)
    {
        /*$this->validate($request, [
            'email_address' => 'required|unique:users,email_address,1,id',
            'password' => 'required'//|confirmed'
        ]);*/

        //check if user email address exists in DB, if not proceed to creation
        if (Users::where('email_address', '=', $request->email_address)->exists()) {
            return response()->json(['status' => 'error', 'message' => 'email address already existing in database'], 400);
        } else {
            $userCtrler = new UsersController;
            //call the createNewDevUser() from the UsersController
            $userCreation = $userCtrler->createNewDevUser($request);

            if ($userCreation->status() === 200) {
                //if the user has been created in DB, then we create a new JWT token for them and send a verification email
                $user = User::where('email_address', '=', $request->email_address)->first();
                $token = auth()->login($user);
                $this->emailRequestVerification($request);

                $developer = Developers::where('id', '=', $user->dev_id)->first();

                return response()->json(['status' => 'success', 'confimationEmail' => 'Email request verification sent to '.($request->email_address), 'message' =>'Developer user created successfully',  'general' => $user, 'spec' => $developer]);//, 'token' => $this->respondWithToken($token)]);
            } else {
                // the case of user creation failing is handled within the creation method so we only send a message here
                return response()->json(['status' => 'error', 'message' => 'Creation failed'], 400);
            }
        }
    }

    /**
     * New recruiter profile creation with JWT token send back in the response
     *
     * @param Request $request
     * @return object
     */
    public function registerRecrut(Request $request){
        //check if user email address exists in DB, if not proceed to creation
        if (Users::where('email_address', '=', $request->email_address)->exists()) {
            return response()->json(['status' => 'error', 'message' => 'email address already existing in database'], 400);
        }
        else {
            $userCtrler = new UsersController;
            //call the createNewRecruiterUser() from the UsersController
            $userCreation = $userCtrler->createNewRecruiterUser($request);

            if ($userCreation->status() === 200) {
                //if the user has been created in DB, then we create a new JWT token for them and send a verification email
                $user = User::where('email_address', '=', $request->email_address)->first();
                $token = auth()->login($user);
                $this->emailRequestVerification($request);

                $recruiter = Recruiters::where('id', '=', $user->recrut_id)->first();
                return response()->json(['status' => 'success', 'message' =>'Recruter user created successfully', 'general' => $user, 'spec' => $recruiter, 'token' => $token]);
            } else {
                // the case of user creation failing is handled within the creation method so we only send a message here
                return response()->json(['status' => 'error', 'message' => 'Creation failed'], 400);
            }
        }
    }


    // Email verification related functions

    /**
    * Request an email address verification mail to be sent.
    *
    * @param  Request  $request
    * @return Response
    */
    public function emailRequestVerification(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();
        return response()->json('Email request verification sent to '.($request->user()->email_address));
    }

    /**
    * Verify an email address using token in the notification link clicked by the user.
    *
    * @param  Request  $request
    * @return Response
    */
    public function emailVerify(Request $request)
    {
        $this->validate($request, [
            'token' => 'required|string',
        ]);

        \Tymon\JWTAuth\Facades\JWTAuth::getToken();
        \Tymon\JWTAuth\Facades\JWTAuth::parseToken()->authenticate();

        $userInfo = $request->user();

        if ( ! $userInfo ) {
            return response()->json('Invalid token', 401);
        }

        if ( $this->hasVerifiedEmail($userInfo) ) {
            return response()->json(['status' => 'failed', 'message' => 'Email address '.$request->user()->getEmailForVerification().' is already verified.']);
        }$request->user()->markEmailAsVerified();


        $query = Users::query()->where("users.id", "=", $userInfo->id);

        if (isset($userInfo->dev_id)) {
            $query->join("developers", "developers.id", "=", "users.dev_id");
        }elseif (isset($userInfo->recrut_id)) {
            $query->join("recruiters", "recruiters.id", "=", "users.recrut_id");
        }
        $user = $query->get();

        return response()->json(['status' => 'success','message' => 'Email address '. $request->user()->email.' successfully verified.', 'user' => $user ], 200);
    }

}

