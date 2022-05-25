<?php

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


/**
 * API global unsecured users routes
 */
$router->group(['prefix' => 'api'], function() use ($router){
    $router->post('/register/users/developers', 'AuthController@registerDev');
    $router->post('/register/users/recruiters', 'AuthController@registerRecrut');
    $router->post('/logout', 'AuthController@logout');
    $router->post('/refresh', 'AuthController@refresh');
    //Verify user email address
    $router->post('/email/verify', ['as' => 'email.verify', 'uses' => 'AuthController@emailVerify']);
    $router->post('/login', 'AuthController@login');
});


/**
 * API unsecured but only accessible to verified users routes
 */
$router->group(['middleware' => 'verified'], function () use ($router) {
    $router->post('/login', 'AuthController@login');
});


/**
 * API JWT secured routes group
 */
$router->group(['prefix' => 'api/secure', 'middleware' => 'jwt.auth', 'jwt.refresh'], function() use ($router){
      $router->post('/email/request-verification', ['as' => 'email.request.verification', 'uses' => 'AuthController@emailRequestVerification']);

    //verified email address routes
    $router->group(['middleware' => 'verified'], function() use ($router){
      /**
       * API secure users related routes
       */
      $router->group(['prefix' => '/users'], function () use ($router) {
          $router->post('/logout', 'AuthController@logout');
          $router->put('/{id}', 'UsersController@updateUser');
          $router->get('/me', 'AuthController@me');
          $router->get('/search', 'UsersController@getDevSearchResults');
          $router->get('/contact', 'MailController@contactUser');
      });

      /**
       * API messages related routes
       */
      $router->group(['prefix' => '/messages/users'], function () use ($router) {
          $router->get('/', 'MessagesController@getOneFromAUser');
          $router->get('/{id}', 'MessagesController@getAllMessagesFromOneUser');
          $router->post('/', 'MessagesController@createMessageInDb');
      });

      /**
       * API favorites related routes
       */
      $router->group(['prefix' => '/favorites'], function () use ($router) {
          $router->get('/recruiters', 'FavoritesController@getOneFromOneUser');
          $router->get('/recruiters/{id}', 'FavoritesController@getAllFromOneUser');
          $router->post('/recruiters', 'FavoritesController@AddNewToProfile');
          $router->delete('/{id}', 'FavoritesController@delete');
      });
    });

});



$router->group(['middleware' => 'auth'], function () use ($router) {
    //$router->post('/password/reset-request', 'RequestPasswordController@sendResetLinkEmail');
});


