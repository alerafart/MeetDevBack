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
        $user = $auth->meNoJson();

        //$user = User::where('email_address', '=', $userComp->pluck('email_address'))->first();

        if ( $request->fullUrl() != route('email.request.verification') &&
           ( ! $user || ! $this->hasVerifiedEmail($user) ) )
        {
            return $$this->hasVerifiedEmail($user);
            throw new AuthorizationException('Unauthorized, your email address '.$user->pluck('email_address').' is not verified.');
        }return $next($request);
    }
}
