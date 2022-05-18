<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\EmailController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*
 Route::get('/users',  function  (Request $request)  {
   return response()->json(['Laravel CORS Demo']);
});*/

/**
 * API global users routes
 */
$router->group(['prefix' => 'api/users'], function() use ($router){
    $router->post('/developers', 'UsersController@createNewDevUser');
    $router->post('/recruiters', 'UsersController@createNewRecruiterUser');
    $router->post('/login', 'UsersController@login');
});

/**
 * API secure users routes
 */
$router->group(['prefix' => 'api/secure/users'], function() use ($router){
    $router->put('/{id}', 'UsersController@updateUser');
});

/**
 * API developers search route
 */
$router->get('api/secure/users/search', 'UsersController@getDevSearchResults');

/**
 * API messages routes
 */
$router->group(['prefix' => 'api/secure/messages'], function() use ($router) {
    $router->get('/users', 'MessagesController@getOneFromAUser');
    $router->get('/users/{id}', 'MessagesController@getAllMessagesFromOneUser');
    $router->post('/users', 'MessagesController@createMessageInDb');
});

/**
 * API favorites routes
 */
$router->group(['prefix' => 'api/secure/favorites'], function() use ($router){
    $router->get('/recruiters', 'FavoritesController@getOneFromOneUser');
    $router->get('/recruiters/{id}', 'FavoritesController@getAllFromOneUser');
    $router->post('/recruiters', 'FavoritesController@AddNewToProfile');
    $router->delete('/{id}', 'FavoritesController@delete');
});


/**
 *  JWT test routes
 */
$router->group(['prefix' => 'api'], function() use ($router){
    $router->post('/login', 'AuthController@login');
   // $router->post('/register', 'AuthController@register');
    $router->post('/register/developers', 'AuthController@registerDev');
    $router->post('/register/recruiters', 'AuthController@registerRecrut');
    $router->post('/logout', 'AuthController@logout');
    $router->post('/refresh', 'AuthController@refresh');
});


$router->group(['prefix' => 'api', 'middleware' => 'auth'], function() use ($router){
    $router->get('/me', 'AuthController@me');
});
