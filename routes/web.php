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

//Route dengan prefix "auth"
$router->group(['prefix'=>'auth'], function() use($router){
    //Proses login
    $router->post('login', 'AuthController@authenticate');
    $router->post('logout', 'AuthController@logout');

    //Route dengan prefix "auth" yang membutuhkan login dulu
    $router->group(['middleware'=>'jwt.auth'], function() use($router){
        $router->post('user', 'UserController@create');
        $router->get('user', 'UserController@read');

        //Service
        $router->post('service', 'ServiceController@create');
        $router->get('service', 'ServiceController@read');
        $router->put('service', 'ServiceController@update');
        $router->patch('service', 'ServiceController@update');
        $router->delete('service', 'ServiceController@delete');

        //Permission
        $router->post('permission', 'PermissionController@create');
        $router->get('permission', 'PermissionController@read');
        $router->get('permission-by-role', 'PermissionController@readByRole');
        $router->put('permission', 'PermissionController@update');
        $router->patch('permission', 'PermissionController@update');
        $router->delete('permission', 'PermissionController@delete');

        //Role
        $router->post('role', 'RoleController@create');
        $router->post('role-add-permission', 'RoleController@addPermission');
        $router->get('role', 'RoleController@read');
        $router->put('role', 'RoleController@update');
        $router->patch('role', 'RoleController@update');
        $router->delete('role', 'RoleController@delete');
        $router->delete('role-remove-permission', 'RoleController@removePermission');
    });
});

//Contact
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

//Perusahaan dan cabang
$router->group(['middleware'=>'jwt.auth'], function() use($router){
    $router->post('company', 'CompanyController@create');
    $router->get('company', 'CompanyController@read');
    $router->put('company', 'CompanyController@update');
    $router->patch('company', 'CompanyController@update');
    $router->delete('company', 'CompanyController@delete');

    $router->post('branch', 'BranchController@create');
    $router->get('branch', 'BranchController@read');
    $router->put('branch', 'BranchController@update');
    $router->patch('branch', 'BranchController@update');
    $router->delete('branch', 'BranchController@delete');
});
