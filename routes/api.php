<?php
// ex: api/v1/auth

/**
 * Auth
 */
$router->group([
    'prefix' => 'auth',
], function () use ($router) {
    $router->post('/login', 'AuthController@postLogin');
    $router->patch('/refresh', 'AuthController@patchRefresh');
});

/**
 * Users
 */
$router->group(['prefix' => 'users'], function () use ($router) {

    $router->get('/', 'UsersController@getUsers');
    $router->get('{id:[0-9]+}', 'UsersController@getUser');

    $router->delete('{id:[0-9]+}', 'UsersController@deleteUser');
    $router->post('/', 'UsersController@createUser');
    // $router->get('{id}/posts', ['uses' => 'UsersController@getUserPosts', ]);
    // $router->get('{id}/posts/{postId}', ['uses' => 'UsersController@getUserPost', ]);
    // $router->get('{id}/comments', ['uses' => 'UsersController@getUserComments', ]);
    // $router->get('{id}/comments/{commentId}', ['uses' => 'UsersController@getUserComment', ]);
    //
    //$router->put('{id:[0-9]+}', ['uses' => 'UsersController@updateUser']);
});
// $router->group(['prefix' => 'posts', 'namespace' => 'App\Http\Controllers'], function() use ($router) {
//     $router->get('/', ['uses' => 'PostsController@getPosts', ]);
//     $router->get('{id}', ['uses' => 'PostsController@getPost', ]);
//     $router->post('/', ['uses' => 'PostsController@createPost', ]);
//     $router->delete('{id}', ['uses' => 'PostsController@deletePost', ]);
//     $router->put('{id}', ['uses' => 'PostsController@updatePost', ]);
// });
// $router->group(['prefix' => 'comments', 'namespace' => 'App\Http\Controllers'], function() use ($router) {
//     $router->get('/', ['uses' => 'CommentsController@getComments', ]);
//     $router->get('{id}', ['uses' => 'CommentsController@getComment', ]);
//     $router->post('/', ['uses' => 'CommentsController@createComment', ]);
//     $router->delete('{id}', ['uses' => 'CommentsController@deleteComment', ]);
//     $router->put('{id}', ['uses' => 'CommentsController@updateComment', ]);
// });

/**
 * Admin
 */
$router->group([
    'prefix'     => 'admin',
    'middleware' => ['auth:api', 'admin'],
], function () use ($router) {
    $router->get('/test', function () {
        return "11";
    });
});
