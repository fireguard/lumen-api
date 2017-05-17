<?php

use Laravel\Lumen\Application;

$app->get('/', function () use ($app) {
    return $app->version();
});

$app->post('/auth/login', 'AuthController@authenticate');

$app->group(['middleware' => 'auth:api', 'prefix' => 'auth'], function(Application $app) {

    $app->get('/token/refresh', 'AuthController@refreshToken');
    $app->get('/token/invalidate', 'AuthController@invalidateToken');
});


$app->group(['middleware' => ['auth:api', 'throttle:30,1'], 'prefix' => 'api'], function(Application $app) {

    $app->get('/users', 'UserController@index');
    $app->get('/user/profile', 'UserController@profile');
    $app->get('/user/{id}', 'UserController@show');
    $app->post('/user', 'UserController@store');
});
