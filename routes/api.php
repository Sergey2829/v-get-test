<?php

/** @var \Laravel\Lumen\Routing\Router $router */


use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompaniesController;

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api/user'], function () use ($router) {
    $router->post('/register', 'AuthController@register');
    $router->post('/sign-in', 'AuthController@signIn');
    $router->group(['middleware' => 'auth'], function () use ($router) {
        $router->patch('recover-password', 'AuthController@recoverPassword');
        $router->get('/companies', 'CompaniesController@index');
        $router->post('/companies', 'CompaniesController@store');
    });
});
