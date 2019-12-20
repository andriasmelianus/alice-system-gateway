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

$router->group(['prefix'=>'contact', 'middleware'=>'jwt.auth'], function() use($router){
    $router->post('phone', 'ContactController@createPhone');
    $router->get('phone', 'ContactController@readPhone');
    $router->put('phone', 'ContactController@updatePhone');
    $router->patch('phone', 'ContactController@updatePhone');
    $router->delete('phone', 'ContactController@deletePhone');

    $router->post('address', 'ContactController@createAddress');
    $router->get('address', 'ContactController@readAddress');
    $router->put('address', 'ContactController@updateAddress');
    $router->patch('address', 'ContactController@updateAddress');
    $router->delete('address', 'ContactController@deleteAddress');

    $router->post('city', 'ContactController@createCity');
    $router->get('city', 'ContactController@readCity');
    $router->put('city', 'ContactController@updateCity');
    $router->patch('city', 'ContactController@updateCity');
    $router->delete('city', 'ContactController@deleteCity');

    $router->post('region', 'ContactController@createRegion');
    $router->get('region', 'ContactController@readRegion');
    $router->put('region', 'ContactController@updateRegion');
    $router->patch('region', 'ContactController@updateRegion');
    $router->delete('region', 'ContactController@deleteRegion');

    $router->post('country', 'ContactController@createCountry');
    $router->get('country', 'ContactController@readCountry');
    $router->put('country', 'ContactController@updateCountry');
    $router->patch('country', 'ContactController@updateCountry');
    $router->delete('country', 'ContactController@deleteCountry');
});
