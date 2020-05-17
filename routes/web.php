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

// Route dengan prefix "auth"
$router->group(['prefix'=>'auth'], function() use($router){
    // Proses login
    $router->post('login', 'Gateway\AuthController@authenticate');
    $router->post('logout', 'Gateway\AuthController@logout');

    // Route dengan prefix "auth" yang membutuhkan login dulu
    $router->group(['middleware'=>'jwt.auth'], function() use($router){
        // User
        $router->post('user', ['middleware' => 'permission:create-user','uses' => 'Gateway\UserController@create']);
        $router->get('user', ['middleware' => 'permission:read-user','uses' => 'Gateway\UserController@read']);
        $router->get('user-by-me', 'Gateway\UserController@readByMe');
        $router->get('user-by-username', ['middleware' => 'permission:read-user','uses' => 'Gateway\UserController@readByUsername']);
        $router->get('user-by-company', ['middleware' => 'permission:read-user','uses' => 'Gateway\UserController@readByCompany']);
        $router->put('user', ['middleware' => 'permission:update-user','uses' => 'Gateway\UserController@update']);
        $router->patch('user', ['middleware' => 'permission:update-user','uses' => 'Gateway\UserController@update']);
        $router->delete('user', ['middleware' => 'permission:delete-user','uses' => 'Gateway\UserController@delete']);
        $router->get('user-role', ['middleware' => 'permission:read-role','uses' => 'Gateway\RoleController@readByUser']);
        $router->post('user-role', ['middleware' => 'permission:create-user','uses' => 'Gateway\UserController@addRole']);
        $router->delete('user-role', ['middleware' => 'permission:create-user','uses' => 'Gateway\UserController@removeRole']);

        // Service
        $router->post('service', ['middleware' => 'permission:create-service','uses' => 'Gateway\ServiceController@create']);
        $router->get('service', ['middleware' => 'permission:read-service','uses' => 'Gateway\ServiceController@read']);
        $router->put('service', ['middleware' => 'permission:update-service','uses' => 'Gateway\ServiceController@update']);
        $router->patch('service', ['middleware' => 'permission:update-service','uses' => 'Gateway\ServiceController@update']);
        $router->delete('service', ['middleware' => 'permission:delete-service','uses' => 'Gateway\ServiceController@delete']);

        // Permission
        $router->post('permission', ['middleware' => 'permission:create-role','uses' => 'Gateway\PermissionController@create']);
        $router->get('permission', ['middleware' => 'permission:read-role','uses' => 'Gateway\PermissionController@read']);
        $router->get('permission-by-role', ['middleware' => 'permission:read-role','uses' => 'Gateway\PermissionController@readByRole']);
        $router->put('permission', ['middleware' => 'permission:update-role','uses' => 'Gateway\PermissionController@update']);
        $router->patch('permission', ['middleware' => 'permission:update-role','uses' => 'Gateway\PermissionController@update']);
        $router->delete('permission', ['middleware' => 'permission:delete-role','uses' => 'Gateway\PermissionController@delete']);

        // Role
        $router->post('role', ['middleware' => 'permission:create-role','uses' => 'Gateway\RoleController@create']);
        $router->get('role', ['middleware' => 'permission:read-role','uses' => 'Gateway\RoleController@read']);
        $router->get('role-by-user', ['middleware' => 'permission:read-role','uses' => 'Gateway\RoleController@readByUser']);
        $router->put('role', ['middleware' => 'permission:update-role','uses' => 'Gateway\RoleController@update']);
        $router->patch('role', ['middleware' => 'permission:update-role','uses' => 'Gateway\RoleController@update']);
        $router->delete('role', ['middleware' => 'permission:delete-role','uses' => 'Gateway\RoleController@delete']);
        // Role-Permission
        $router->get('role-permission', ['middleware' => 'permission:read-role','uses' => 'Gateway\PermissionController@readByRole']);
        $router->post('role-permission', ['middleware' => 'permission:create-role','uses' => 'Gateway\RoleController@addPermission']);
        $router->delete('role-permission', ['middleware' => 'permission:create-role','uses' => 'Gateway\RoleController@removePermission']);
    });
});

// Contact
$router->group(['prefix'=>'contact', 'middleware'=>'jwt.auth'], function() use($router){
    $router->post('phone', ['middleware' => 'permission:create-contact','uses' => 'Contact\ContactController@createPhone']);
    $router->get('phone', ['middleware' => 'permission:read-contact','uses' => 'Contact\ContactController@readPhone']);
    $router->put('phone', ['middleware' => 'permission:update-contact','uses' => 'Contact\ContactController@updatePhone']);
    $router->patch('phone', ['middleware' => 'permission:update-contact','uses' => 'Contact\ContactController@updatePhone']);
    $router->delete('phone', ['middleware' => 'permission:delete-contact','uses' => 'Contact\ContactController@deletePhone']);

    $router->post('address', ['middleware' => 'permission:create-contact','uses' => 'Contact\ContactController@createAddress']);
    $router->get('address', ['middleware' => 'permission:read-contact','uses' => 'Contact\ContactController@readAddress']);
    $router->put('address', ['middleware' => 'permission:update-contact','uses' => 'Contact\ContactController@updateAddress']);
    $router->patch('address', ['middleware' => 'permission:update-contact','uses' => 'Contact\ContactController@updateAddress']);
    $router->delete('address', ['middleware' => 'permission:delete-contact','uses' => 'Contact\ContactController@deleteAddress']);

    $router->post('city', ['middleware' => 'permission:create-contact','uses' => 'Contact\ContactController@createCity']);
    $router->get('city', ['middleware' => 'permission:read-contact','uses' => 'Contact\ContactController@readCity']);
    $router->put('city', ['middleware' => 'permission:update-contact','uses' => 'Contact\ContactController@updateCity']);
    $router->patch('city', ['middleware' => 'permission:update-contact','uses' => 'Contact\ContactController@updateCity']);
    $router->delete('city', ['middleware' => 'permission:delete-contact','uses' => 'Contact\ContactController@deleteCity']);

    $router->post('region', ['middleware' => 'permission:create-contact','uses' => 'Contact\ContactController@createRegion']);
    $router->get('region', ['middleware' => 'permission:read-contact','uses' => 'Contact\ContactController@readRegion']);
    $router->put('region', ['middleware' => 'permission:update-contact','uses' => 'Contact\ContactController@updateRegion']);
    $router->patch('region', ['middleware' => 'permission:update-contact','uses' => 'Contact\ContactController@updateRegion']);
    $router->delete('region', ['middleware' => 'permission:delete-contact','uses' => 'Contact\ContactController@deleteRegion']);

    $router->post('country', ['middleware' => 'permission:create-contact','uses' => 'Contact\ContactController@createCountry']);
    $router->get('country', ['middleware' => 'permission:read-contact','uses' => 'Contact\ContactController@readCountry']);
    $router->put('country', ['middleware' => 'permission:update-contact','uses' => 'Contact\ContactController@updateCountry']);
    $router->patch('country', ['middleware' => 'permission:update-contact','uses' => 'Contact\ContactController@updateCountry']);
    $router->delete('country', ['middleware' => 'permission:delete-contact','uses' => 'Contact\ContactController@deleteCountry']);
});

// Perusahaan dan cabang
$router->group(['middleware'=>'jwt.auth'], function() use($router){
    $router->post('company', ['middleware' => 'permission:create-company','uses' => 'Gateway\CompanyController@create']);
    $router->get('company', ['middleware' => 'permission:read-company','uses' => 'Gateway\CompanyController@read']);
    $router->put('company', ['middleware' => 'permission:update-company','uses' => 'Gateway\CompanyController@update']);
    $router->patch('company', ['middleware' => 'permission:update-company','uses' => 'Gateway\CompanyController@update']);
    $router->delete('company', ['middleware' => 'permission:delete-company','uses' => 'Gateway\CompanyController@delete']);

    $router->get('company-business', ['middleware' => 'permission:read-company','uses' => 'Gateway\CompanyController@readBusiness']);
    $router->get('company-industry', ['middleware' => 'permission:read-company','uses' => 'Gateway\CompanyController@readIndustry']);

    $router->post('branch', ['middleware' => 'permission:create-company','uses' => 'Gateway\BranchController@create']);
    $router->get('branch', ['middleware' => 'permission:read-company','uses' => 'Gateway\BranchController@read']);
    $router->get('branch-by-company', ['middleware' => 'permission:read-company','uses' => 'Gateway\BranchController@readByCompany']);
    $router->put('branch', ['middleware' => 'permission:update-company','uses' => 'Gateway\BranchController@update']);
    $router->patch('branch', ['middleware' => 'permission:update-company','uses' => 'Gateway\BranchController@update']);
    $router->delete('branch', ['middleware' => 'permission:delete-company','uses' => 'Gateway\BranchController@delete']);
});


// PRODUCTS
$router->group(['middleware'=>'jwt.auth'], function() use($router){
    $router->post('product', ['middleware' => 'permission:create-product','uses' => 'Product\ProductController@create']);
    $router->get('product', ['middleware' => 'permission:read-product','uses' => 'Product\ProductController@read']);
    $router->put('product', ['middleware' => 'permission:update-product','uses' => 'Product\ProductController@update']);
    $router->patch('product', ['middleware' => 'permission:update-product','uses' => 'Product\ProductController@update']);
    $router->delete('product', ['middleware' => 'permission:delete-product','uses' => 'Product\ProductController@delete']);
    $router->group(['prefix'=>'product'], function() use($router){
        // Product Category
        $router->post('category', ['middleware' => 'permission:update-product','uses' => 'Product\CategoryController@add']);
        $router->get('category', ['middleware' => 'permission:read-product','uses' => 'Product\CategoryController@get']);
        $router->delete('category', ['middleware' => 'permission:update-product','uses' => 'Product\CategoryController@remove']);
        // Product Brand
        $router->get('brand', ['middleware' => 'permission:read-product','uses' => 'Product\BrandController@get']);

        // Product Images
        // Catatan: Data gambar dikirimkan bersamaan dengan permintaan data produk
        $router->post('image', ['middleware' => 'permission:create-product','uses' => 'Product\ProductController@addImage']);
        $router->put('image', ['middleware' => 'permission:update-product','uses' => 'Product\ProductController@setDefaultImage']);
        $router->patch('image', ['middleware' => 'permission:update-product','uses' => 'Product\ProductController@setDefaultImage']);
        $router->delete('image', ['middleware' => 'permission:delete-product','uses' => 'Product\ProductController@removeImage']);

        // Product Movement
        $router->post('movement', ['middleware' => 'permission:create-product-movement','uses' => 'Product\MovementController@create']);
        $router->get('movement', ['middleware' => 'permission:read-product-movement','uses' => 'Product\MovementController@read']);
        $router->put('movement', ['middleware' => 'permission:update-product-movement','uses' => 'Product\MovementController@update']);
        $router->patch('movement', ['middleware' => 'permission:update-product-movement','uses' => 'Product\MovementController@update']);
        $router->delete('movement', ['middleware' => 'permission:delete-product-movement','uses' => 'Product\MovementController@delete']);
        $router->group(['prefix'=>'movement'], function() use($router){
            // Product Movement Serial
            $router->post('serial', ['middleware' => 'permission:create-product-movement','uses' => 'Product\MovementController@create']);
            $router->get('serial', ['middleware' => 'permission:read-product-movement','uses' => 'Product\MovementController@read']);
            $router->put('serial', ['middleware' => 'permission:update-product-movement','uses' => 'Product\MovementController@update']);
            $router->patch('serial', ['middleware' => 'permission:update-product-movement','uses' => 'Product\MovementController@update']);
            $router->delete('serial', ['middleware' => 'permission:delete-product-movement','uses' => 'Product\MovementController@delete']);
        });
    });
});
