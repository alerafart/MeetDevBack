<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use App\Mail\SendEmail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\MessagesController;

use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});



/**
 *  Users CRUD methods routes
 */
$router->group(['prefix' => 'users'], function() use ($router){
    $router->get('/', 'UsersController@list');
    $router->get('/{id}', 'UsersController@item');
    $router->post('/', 'UsersController@create');
    $router->put('/{id}', 'UsersController@update');
    $router->delete('/{id}', 'UsersController@delete');
});

/**
 *  Developers CRUD methods routes
 */
$router->group(['prefix'=>'developers'], function() use ($router){
    $router->get('/', 'DevelopersController@list');
    $router->get('/{id}', 'DevelopersController@item');
    $router->post('/', 'DevelopersController@create');
    $router->put('/{id}', 'DevelopersController@update');
    $router->delete('/{id}', 'DevelopersController@delete');
});

/**
 *  Recruiters CRUD methods routes
 */
$router->group(['prefix' => 'recruiters'], function() use ($router){
    $router->get('/', 'RecruitersController@list');
    $router->get('/{id}', 'RecruitersController@item');
    $router->post('/', 'RecruitersController@create');
    $router->put('/{id}', 'RecruitersController@update');
    $router->delete('/{id}', 'RecruitersController@delete');
});

/**
 *  Messages CRUD methods routes
 */
$router->group(['prefix' => 'messages'], function() use ($router) {
    $router->get('/', 'MessagesController@list');
    $router->get('/{id}', 'MessagesController@item');
    $router->post('/', 'MessagesController@create');
    $router->put('/{id}', 'MessagesController@update');
    $router->delete('/{id}', 'MessagesController@delete');
});

/**
 *  Favorites CRUD methods routes
 */
$router->group(['prefix' => 'favorites'], function() use ($router){
    $router->get('/', 'FavoritesController@list');
    $router->get('/{id}', 'FavoritesController@item');
    $router->post('/', 'FavoritesController@create');
    $router->put('/{id}', 'FavoritesController@update');
    //$router->delete('/{id}', 'FavoritesController@delete');
});

/**
 *  Languages CRUD methods routes
 */
$router->group(['prefix'=>'languages'], function() use ($router){
    $router->get('/', 'LanguagesController@list');
    $router->get('/{id}', 'LanguagesController@item');
    $router->post('/', 'LanguagesController@create');
    $router->put('/{id}', 'LanguagesController@update');
    $router->delete('/{id}', 'LanguagesController@delete');
});

/**
 *  Dev_langs CRUD methods routes
 */
$router->group(['prefix' => 'dev_langs'], function() use ($router){
    $router->get('/', 'DevLangController@list');
    $router->get('/{id}', 'DevLangController@item');
    $router->post('/', 'DevLangController@create');
    $router->put('/{id}', 'DevLangController@update');
    $router->delete('/{id}', 'DevLangController@delete');
});

/**
 *  Other routes
 */
$router->group(['prefix' => 'api/users'], function() use ($router){
       // $router->get('/send/email', 'MailController@send');
       $router->get('/contact', 'MailController@contactUser');
});

/*Route::get('/mailable', function () {
    $email = "patate@patate.com";
    $sm = new App\Mail\SendEmail($email);

    $markdown = new \Illuminate\Mail\Markdown(View(), config('mail.markdown'));
 //$data = "patate@patate.com";
    return $markdown->render($sm->markdown);
});*/

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->middleware('guest')->name('password.request');

Route::post('/forgot-password', function (Request $request) {
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
})->middleware('guest')->name('password.reset');


Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
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
})->middleware('guest')->name('password.update');
