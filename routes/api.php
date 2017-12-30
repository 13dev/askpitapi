<?php
// ex: api/v1/auth

/**
 * Auth
 */
$router->group([
    'prefix' => 'auth',
], function() use ($router){
    $router->post('/login', 'AuthController@postLogin');
    $router->patch('/refresh','AuthController@patchRefresh');
});

/**
 * Admin
 */
$router->group([
    'prefix' => 'admin',
    'middleware' => ['auth:api','admin'],
], function() use ($router){
    $router->get('/test', function(){
        return "11";
    });
});



