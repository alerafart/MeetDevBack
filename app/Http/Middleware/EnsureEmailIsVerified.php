<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Http\Traits\MustVerifyEmail;
use Closure;
use Illuminate\Auth\Access\AuthorizationException;
use App\Http\Controllers\AuthController;

class EnsureEmailIsVerified
{   use MustVerifyEmail;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $auth = new AuthController;

        if($request->email_address){
            $user = User::where('email_address', '=', $request->email_address)->first();

            if ( $request->fullUrl() != route('email.request.verification') &&
            //( ! $user || ! $user->hasVerifiedEmail($user) ) )
            ( ! $user || !isset($user->email_verified_at) ) )
            {
                //throw new AuthorizationException('Unauthorized, your email address '.$user->email_address.' is not verified.');
                return response()->json('Unauthorized, your email address '.$user->email_address.' is not verified.');
            }
        }else {
            $user = $auth->meNoJson();
            $userEmailVerified = $user->pluck('email_verified_at');
            if ( $request->fullUrl() != route('email.request.verification') && ( ! $user || ! isset($userEmailVerified) ) )
            {
                //throw new AuthorizationException('Unauthorized, your email address '.$user->email_address.' is not verified.');
                return response()->json('Unauthorized, your email address '.$user->pluck('email_address').' is not verified.');
            }
        }
        return $next($request);
    }
}
