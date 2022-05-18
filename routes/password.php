<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/* $router->group(['prefix' => 'api', 'middleware' => 'auth'], function() use ($router){
    $router->get('/me', 'AuthController@me');
}); */

$router->group(['prefix' => 'api', 'middleware' => 'auth'], function() use ($router){
    $router->get('/forgot-password', 'AuthController@forgotpsx');
});

/* Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->middleware('auth')->name('password.request'); */

/* Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email_address' => 'required|email_address']);

    $status = Password::sendResetLink(
        $request->only('email')
    );

    return $status === Password::RESET_LINK_SENT
                ? back()->with(['status' => __($status)])
                : back()->withErrors(['email_address' => __($status)]);
})->middleware('guest')->name('password.email_address');

Route::get('/reset-password/{token}', function ($token) {
    return view('auth.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset'); */


/* Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email_address' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);

    $status = Password::reset(
        $request->only('email_address', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->setRememberToken(Str::random(60));

            $user->save();

            event(new PasswordReset($user));
        }
    );

    return $status === Password::PASSWORD_RESET
                ? redirect()->route('login')->with('status', __($status))
                : back()->withErrors(['email' => [__($status)]]);
})->middleware('guest')->name('password.update'); */
