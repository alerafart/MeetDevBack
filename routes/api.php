<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


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
 * API users routes
 */
$router->group(['prefix' => 'api/users'], function() use ($router){
    $router->post('/developers', 'UsersController@createNewDevUser');
    $router->post('/recruiters', 'UsersController@createNewRecruiterUser');
    $router->post('/login', 'UsersController@login');
    $router->get('/secure/search', 'UsersController@getDevSearchResults');
});

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
});
