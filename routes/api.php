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
