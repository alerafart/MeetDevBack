<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use App\Http\Controllers\MessagesController;
use App\Http\Controllers\UsersController;

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
    $router->get('/users/{id}', 'UsersController@item');
    $router->post('/users', 'UsersController@create');
    $router->put('/users/{id}', 'UsersController@update');
    $router->delete('/users/{id}', 'UsersController@delete');
});

$router->group(['prefix'=>'api/developers'], function() use ($router){
    $router->get('/', 'DevelopersController@list');
    $router->post('/', 'DevelopersController@create');
    $router->put('/{id}', 'DevelopersController@update');
    $router->delete('/{id}', 'DevelopersController@delete');
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
    $router->get('/messages/{id}', 'MessagesController@item');
    $router->get('/messages/{id}', 'MessagesController@getAllMessagesFromOneUser');

});

$router->group(['prefix' => 'api/secure/favorites'], function() use ($router){
    // $router->get('/', 'FavoritesController@list');
    // $router->get('/{id}', 'FavoritesController@item');
    $router->post('/', 'FavoritesController@create');
    $router->put('/{id}', 'FavoritesController@update');
    $router->delete('/{id}', 'FavoritesController@delete');
    $router->get('/recruiters-fav', 'FavoritesController@getAllFromOneUser');
    $router->get('/recruiters', 'FavoritesController@getOneFromOneUser');
});

$router->group(['prefix'=>'api/languages'], function() use ($router){
    $router->get('/', 'LanguagesController@list');
    $router->post('/', 'LanguagesController@create');
    $router->put('/{id}', 'LanguagesController@update');
    $router->delete('/{id}', 'LanguagesController@delete');
});

$router->group(['prefix' => 'api'], function() use ($router){
    $router->get('/dev_langs', 'DevLangController@list');
    $router->post('/dev_langs', 'DevLangController@create');
    $router->put('/dev_langs/{id}', 'DevLangController@update');
    $router->delete('/dev_langs/{id}', 'DevLangController@delete');
});

$router->group(['prefix' => 'api/users'], function() use ($router){
    $router->post('/developer', 'UsersController@createNewDevUser');
    $router->post('/recruiter', 'UsersController@createNewRecruiterUser');
    $router->post('/login', 'UsersController@login');
    // $router->get('/search-results', 'UsersController@getDevSearchResults');
});
