<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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
    return 'hello';
});
$router->post('/upload', 'ImageController@upload');
// product routes
$router->group(['prefix' => '/product'], function () use ($router) {
    $router->get('', 'ProductController@all');
    $router->get('/{id}', 'ProductController@get');
    $router->post('', 'ProductController@add');
    $router->put('/{id}', 'ProductController@put');
    $router->delete('/{id}', 'ProductController@remove');

});
// user routes
$router->group(['prefix' => 'user'], function () use ($router) {
    $router->get('', 'UserController@all');
    $router->get('/{id}', 'UserController@get');
    $router->post('', 'UserController@add');
    $router->put('/{id}', 'UserController@put');
    $router->delete('/{id}', 'UserController@remove');

});
// auth routes
$router->group([
    'middleware' => 'auth',
    'prefix' => 'auth'
], function ($router) {
    $router->post('/logout', ['uses' => 'AuthController@logout']);
    $router->get('/refresh', ['uses' => 'AuthController@refresh']);
    $router->get('/user-profile', ['uses' => 'AuthController@userProfile']);  
});
$router->post('auth/register', ['uses' => 'AuthController@register']);
$router->post('auth/login', ['uses' => 'AuthController@login']);
 // bid Routes
$router->group([
    'prefix' => 'bid'
], function ($router) {
    $router->post('/{productId}', ['uses' => 'BidController@bid']);
});
// user-bid routes
$router->group([
    'prefix' => 'user-bid'
], function ($router) {
    $router->get('/{productId}', ['uses' => 'UserBidController@getBids']);
});

// shop routes
$router->group([
    'prefix' => 'shop'
], function ($router) {
    $router->get('/{sellerId}', ['uses' => 'ShopController@getShopProducts']);
});
