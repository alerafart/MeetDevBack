<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use App\Http\Controllers\MessagesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\EmailController;
use App\Mail\SendEmail;



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

