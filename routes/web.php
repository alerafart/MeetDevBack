<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use App\Http\Controllers\MessagesController;

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

$router->group(['prefix' => 'api'], function() use ($router){
    $router->get('/users', 'UsersController@list');
    $router->post('/users', 'UsersController@create');
    $router->put('/users/{id}', 'UsersController@update');
    $router->delete('/users/{id}', 'UsersController@delete');
});

$router->group(['prefix' => 'api'], function() use ($router){
    $router->get('/recruiters', 'RecruitersController@list');
    $router->post('/recruiters', 'RecruitersController@create');
    $router->put('/recruiters/{id}', 'RecruitersController@update');
    $router->delete('/recruiters/{id}', 'RecruitersController@delete');
});


$router->group(['prefix' => 'api'], function() use ($router) {
    $router->get('/messages', 'MessagesController@list');
    $router->post('/messages', 'MessagesController@create');
    $router->put('/messages/{id}', 'MessagesController@update');
    $router->delete('/messages/{id}', 'MessagesController@delete');

$router->group(['prefix' => 'api/secure/favorites'], function() use ($router){
    $router->get('/', 'FavoritesController@list');
    $router->post('/', 'FavoritesController@create');
    $router->put('/{id}', 'FavoritesController@update');
    $router->delete('/{id}', 'FavoritesController@delete');
});

$router->group(['prefix'=>'api/users/developers'], function() use ($router){
    $router->get('/', 'DevelopersController@list');
    $router->post('/', 'DevelopersController@create');
    $router->put('/{id}', 'DevelopersController@update');
    $router->delete('/{id}', 'DevelopersController@delete');

});

$router->group(['prefix' => 'api'], function() use ($router){
    $router->get('/dev_langs', 'DevLangController@list');
    $router->post('/dev_langs', 'DevLangController@create');
    $router->put('/dev_langs/{id}', 'DevLangController@update');
    $router->delete('/dev_langs/{id}', 'DevLangController@delete');
});
