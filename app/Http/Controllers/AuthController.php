<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
//use App\Models\User;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * Undocumented class
 */
class AuthController extends Controller
{
     /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function register(Request $request){
        $this->validate($request, [
            'email_address' => 'required|unique:users, email_address,1, id',
            'password' => 'required|confirmed'
        ]);

        $email_address = $request->input('email_address');
        $password = Hash::make($request->input('password'));
        User::create(['email_address'=>$email_address, 'password'=>$password]);

        return response()->json(['status'=>'succes', 'registration'=>'created']);
    }
     /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);
        // Get some user from somewhere
        $user = User::first();

        // Get the token
        $token = auth()->login($user);
        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
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
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }


}



    // /**
    //  * Get a JWT via given credentials.
    //  *
    //  * @param  Request  $request
    //  * @return Response
    //  */
    // public function login(Request $request)
    // {

    //     $this->validate($request, [
    //         'email' => 'required|string',
    //         'password' => 'required|string',
    //     ]);

    //     $credentials = $request->only(['email', 'password']);

    //     if (! $token = Auth::attempt($credentials)) {
    //         return response()->json(['message' => 'Unauthorized'], 401);
    //     }

    //     return $this->respondWithToken($token);
    // }

    //  /**
    //  * Get the authenticated User.
    //  *
    //  * @return \Illuminate\Http\JsonResponse
    //  */
    // public function me()
    // {
    //     return response()->json(auth()->user());
    // }

    // /**
    //  * Log the user out (Invalidate the token).
    //  *
    //  * @return \Illuminate\Http\JsonResponse
    //  */
    // public function logout()
    // {
    //     auth()->logout();

    //     return response()->json(['message' => 'Successfully logged out']);
    // }

    // /**
    //  * Refresh a token.
    //  *
    //  * @return \Illuminate\Http\JsonResponse
    //  */
    // public function refresh()
    // {
    //     return $this->respondWithToken(auth()->refresh());
    // }

    // /**
    //  * Get the token array structure.
    //  *
    //  * @param  string $token
    //  *
    //  * @return \Illuminate\Http\JsonResponse
    //  */
    // protected function respondWithToken($token)
    // {
    //     return response()->json([
    //         'access_token' => $token,
    //         'token_type' => 'bearer',
    //         'user' => auth()->user(),
    //         'expires_in' => auth()->factory()->getTTL() * 60 * 24
    //     ]);
    // }

