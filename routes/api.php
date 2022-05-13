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
    $router->post('/developer', 'UsersController@createNewDevUser');
    $router->post('/recruiter', 'UsersController@createNewRecruiterUser');
    $router->post('/login', 'UsersController@login');
    $router->get('/search', 'UsersController@getDevSearchResults');
});

/**
 * API messages routes
 */
$router->group(['prefix' => 'api/messages'], function() use ($router) {
    $router->get('/users', 'MessagesController@getAllMessagesFromOneUser');
    $router->get('/users/{id}', 'MessagesController@getOneFromAUser');
});

$router->group(['prefix' => 'api/secure/favorites'], function() use ($router){
    $router->get('/recruiters', 'FavoritesController@getOneFromOneUser');
    $router->get('/recruiters/{id}', 'FavoritesController@getAllFromOneUser');
});
