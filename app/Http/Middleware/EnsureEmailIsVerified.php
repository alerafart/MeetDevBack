<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Http\Traits\MustVerifyEmail;
use Closure;
use Illuminate\Auth\Access\AuthorizationException;

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
        $user = User::where('email_address', '=', $request->email_address)->first();

        if ( $request->fullUrl() != route('email.request.verification') &&
           ( ! $user || ! $user->hasVerifiedEmail() ) )
        {
            throw new AuthorizationException('Unauthorized, your email address '.$user->email_address.' is not verified.');
        }return $next($request);
    }
}
