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
        //User
        $router->post('user', ['middleware' => 'permission:create-user','uses' => 'UserController@create']);
        $router->get('user', ['middleware' => 'permission:read-user','uses' => 'UserController@read']);
        $router->get('user-by-me', 'UserController@readByMe');
        $router->get('user-by-username', ['middleware' => 'permission:read-user','uses' => 'UserController@readByUsername']);
        $router->get('user-by-company', ['middleware' => 'permission:read-user','uses' => 'UserController@readByCompany']);
        $router->put('user', ['middleware' => 'permission:update-user','uses' => 'UserController@update']);
        $router->patch('user', ['middleware' => 'permission:update-user','uses' => 'UserController@update']);
        $router->delete('user', ['middleware' => 'permission:delete-user','uses' => 'UserController@delete']);
        $router->get('user-role', ['middleware' => 'permission:read-role','uses' => 'RoleController@readByUser']);
        $router->post('user-role', ['middleware' => 'permission:create-user','uses' => 'UserController@addRole']);
        $router->delete('user-role', ['middleware' => 'permission:create-user','uses' => 'UserController@removeRole']);

        //Service
        $router->post('service', ['middleware' => 'permission:create-service','uses' => 'ServiceController@create']);
        $router->get('service', ['middleware' => 'permission:read-service','uses' => 'ServiceController@read']);
        $router->put('service', ['middleware' => 'permission:update-service','uses' => 'ServiceController@update']);
        $router->patch('service', ['middleware' => 'permission:update-service','uses' => 'ServiceController@update']);
        $router->delete('service', ['middleware' => 'permission:delete-service','uses' => 'ServiceController@delete']);

        //Permission
        $router->post('permission', ['middleware' => 'permission:create-permission','uses' => 'PermissionController@create']);
        $router->get('permission', ['middleware' => 'permission:read-permission','uses' => 'PermissionController@read']);
        $router->get('permission-by-role', ['middleware' => 'permission:read-permission','uses' => 'PermissionController@readByRole']);
        $router->put('permission', ['middleware' => 'permission:update-permission','uses' => 'PermissionController@update']);
        $router->patch('permission', ['middleware' => 'permission:update-permission','uses' => 'PermissionController@update']);
        $router->delete('permission', ['middleware' => 'permission:delete-permission','uses' => 'PermissionController@delete']);

        //Role
        $router->post('role', ['middleware' => 'permission:create-role','uses' => 'RoleController@create']);
        $router->get('role', ['middleware' => 'permission:read-role','uses' => 'RoleController@read']);
        $router->get('role-by-user', ['middleware' => 'permission:read-role','uses' => 'RoleController@readByUser']);
        $router->put('role', ['middleware' => 'permission:update-role','uses' => 'RoleController@update']);
        $router->patch('role', ['middleware' => 'permission:update-role','uses' => 'RoleController@update']);
        $router->delete('role', ['middleware' => 'permission:delete-role','uses' => 'RoleController@delete']);
        //Role-Permission
        $router->get('role-permission', ['middleware' => 'permission:read-permission','uses' => 'PermissionController@readByRole']);
        $router->post('role-permission', ['middleware' => 'permission:create-role','uses' => 'RoleController@addPermission']);
        $router->delete('role-permission', ['middleware' => 'permission:create-role','uses' => 'RoleController@removePermission']);
    });
});

//Contact
$router->group(['prefix'=>'contact', 'middleware'=>'jwt.auth'], function() use($router){
    $router->post('phone', ['middleware' => 'permission:create-contact','uses' => 'ContactController@createPhone']);
    $router->get('phone', ['middleware' => 'permission:read-contact','uses' => 'ContactController@readPhone']);
    $router->put('phone', ['middleware' => 'permission:update-contact','uses' => 'ContactController@updatePhone']);
    $router->patch('phone', ['middleware' => 'permission:update-contact','uses' => 'ContactController@updatePhone']);
    $router->delete('phone', ['middleware' => 'permission:delete-contact','uses' => 'ContactController@deletePhone']);

    $router->post('address', ['middleware' => 'permission:create-contact','uses' => 'ContactController@createAddress']);
    $router->get('address', ['middleware' => 'permission:read-contact','uses' => 'ContactController@readAddress']);
    $router->put('address', ['middleware' => 'permission:update-contact','uses' => 'ContactController@updateAddress']);
    $router->patch('address', ['middleware' => 'permission:update-contact','uses' => 'ContactController@updateAddress']);
    $router->delete('address', ['middleware' => 'permission:delete-contact','uses' => 'ContactController@deleteAddress']);

    $router->post('city', ['middleware' => 'permission:create-contact','uses' => 'ContactController@createCity']);
    $router->get('city', ['middleware' => 'permission:read-contact','uses' => 'ContactController@readCity']);
    $router->put('city', ['middleware' => 'permission:update-contact','uses' => 'ContactController@updateCity']);
    $router->patch('city', ['middleware' => 'permission:update-contact','uses' => 'ContactController@updateCity']);
    $router->delete('city', ['middleware' => 'permission:delete-contact','uses' => 'ContactController@deleteCity']);

    $router->post('region', ['middleware' => 'permission:create-contact','uses' => 'ContactController@createRegion']);
    $router->get('region', ['middleware' => 'permission:read-contact','uses' => 'ContactController@readRegion']);
    $router->put('region', ['middleware' => 'permission:update-contact','uses' => 'ContactController@updateRegion']);
    $router->patch('region', ['middleware' => 'permission:update-contact','uses' => 'ContactController@updateRegion']);
    $router->delete('region', ['middleware' => 'permission:delete-contact','uses' => 'ContactController@deleteRegion']);

    $router->post('country', ['middleware' => 'permission:create-contact','uses' => 'ContactController@createCountry']);
    $router->get('country', ['middleware' => 'permission:read-contact','uses' => 'ContactController@readCountry']);
    $router->put('country', ['middleware' => 'permission:update-contact','uses' => 'ContactController@updateCountry']);
    $router->patch('country', ['middleware' => 'permission:update-contact','uses' => 'ContactController@updateCountry']);
    $router->delete('country', ['middleware' => 'permission:delete-contact','uses' => 'ContactController@deleteCountry']);
});

//Perusahaan dan cabang
$router->group(['middleware'=>'jwt.auth'], function() use($router){
    $router->post('company', ['middleware' => 'permission:create-company','uses' => 'CompanyController@create']);
    $router->get('company', ['middleware' => 'permission:read-company','uses' => 'CompanyController@read']);
    $router->get('company-by-me', ['middleware' => 'permission:read-company','uses' => 'CompanyController@readByMe']);
    $router->put('company', ['middleware' => 'permission:read-company','uses' => 'CompanyController@update']);
    $router->patch('company', ['middleware' => 'permission:read-company','uses' => 'CompanyController@update']);
    $router->delete('company', ['middleware' => 'permission:delete-company','uses' => 'CompanyController@delete']);

    $router->get('company-user', ['middleware' => 'permission:read-user','uses' => 'UserController@readByCompany']);
    $router->post('company-user', ['middleware' => 'permission:create-company','uses' => 'CompanyController@addUser']);
    $router->delete('company-user', ['middleware' => 'permission:create-company','uses' => 'CompanyController@removeUser']);

    $router->get('company-business', ['middleware' => 'permission:read-company','uses' => 'CompanyController@readBusiness']);
    $router->get('company-industry', ['middleware' => 'permission:read-company','uses' => 'CompanyController@readIndustry']);

    $router->post('branch', ['middleware' => 'permission:create-company','uses' => 'BranchController@create']);
    $router->get('branch', ['middleware' => 'permission:read-company','uses' => 'BranchController@read']);
    $router->get('branch-by-company', ['middleware' => 'permission:read-company','uses' => 'BranchController@readByCompany']);
    $router->put('branch', ['middleware' => 'permission:update-company','uses' => 'BranchController@update']);
    $router->patch('branch', ['middleware' => 'permission:update-company','uses' => 'BranchController@update']);
    $router->delete('branch', ['middleware' => 'permission:delete-company','uses' => 'BranchController@delete']);
});
