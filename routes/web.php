<?php

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
    // return $router->app->version();
    return 'Welcome to the '.env('APP_NAME').'!';
});

$router->group(['prefix'=>'auth'], function() use($router){
    $router->post('login', 'AuthController@authenticate');

    $router->group(['middleware'=>'jwt.auth'], function() use($router){
        $router->get('user', 'AuthController@user');
    });
});
