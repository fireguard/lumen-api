<?php

use Laravel\Lumen\Application;

$app->get('/', function () use ($app) {
    return $app->version();
});

$app->post('/auth/login', 'AuthController@authenticate');

$app->group(['middleware' => 'auth:api'], function(Application $app) {
    $app->get('/auth/token/refresh', 'AuthController@refreshToken');
    $app->get('/auth/token/invalidate', 'AuthController@invalidateToken');

    $app->get('/test', function() {
        return response()->json([
            'message' => 'Hello World!',
        ]);
    });
});
