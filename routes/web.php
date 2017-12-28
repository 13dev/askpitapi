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
    return $router->app->version();
});

// ex: api/v1/auth
$router->group([
    'prefix' => 'api/'. env('API_VERSION'),
    ], function () use($router){

    /**
     * Auth
     */
    $router->group([
        'prefix' => 'auth',
    ], function() use ($router){
        $router->post('/login', 'AuthController@postLogin');
        $router->patch('/refresh','AuthController@patchRefresh');
    });

});



//$router->get('/me', function (\Illuminate\Http\Request $request) {
//    return $request->user();
//});