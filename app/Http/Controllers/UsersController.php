<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Response;
use App\User;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class UsersController extends Controller
{
	public function __construct()
    {
        //apply auth middleware except getting user
        $this->middleware('auth:api', [
        	'except' => [
        		'getUsers',
        		'getUser',
        		'createUser',
        	]
        ]);
    }

    public function getUsers()
    {
        // get first 20 users
        if($users = User::paginate(20))
        {
        	 return Response::json('getusers_success', $users);
        }

        // no users to retrive
		return Response::json('getusers_no_content', [
		], Response::NO_CONTENT);
    }

    public function getUser($id)
    {
        // find user by id
    	if($user = User::find($id))
        {
            // user was found
        	return Response::json('getuser_success', [
    			$user,
        	]);
        }

        // not found user
		return Response::json('getuser_notfound', [
		], Response::NOT_FOUND);

    }

    public function createUser(Request $request)
    {
    	// Add some delay
    	sleep(random_int(1, 4));

        // get user data
        $userData = $this->getCredentials($request);

        // create user instanciate
        $user = new User();

        // attempt validation
        if (!$user->validate($userData))
        {
            // failure, get errors
            return Response::json('createuser_error', [
                $user->errors(),
            ], Response::NOT_IMPLEMENTED);
        }

        // attempt create user
        //TODO: Change User static to dynamic..
    	if($createdUser = User::create($userData))
        {
            // user created
        	return Response::json('createuser_success', [
    			$createdUser,
        	],Response::OK);
        }

        // cant create user...
		return Response::json('createuser_error', [
		], Response::NOT_IMPLEMENTED);

    }

    public function deleteUser($id)
    {
        $token = JWTAuth::parseToken();
        $payload = $token->getPayload();
        $authUser = $this->getAuthenticatedUser();

        $isUserAdmin = $payload->get('admin');

        if(!$isUserAdmin)
        {
            if($id != $authUser->id)
            {
                // cant delete this user...
                return Response::json('deleteuser_error', [
                ], Response::UNAUTHORIZED);
            }
        }

        // if user is admin and is deleting himself
        if($isUserAdmin && $id == $authUser->id)
        {
            // cant delete this user...
            return Response::json('deleteuser_error', [
                ], Response::UNAUTHORIZED);
        }

        // find user by id
        if(!$user = User::find($id))
        {
            // cant find user
            return Response::json('deleteuser_error', [
            ], Response::NOT_FOUND);
        }

        if($deletedUser = $user->delete())
        {
            // TODO: invalidate token by user id..
            JWTAuth::invalidate($token);

            // user deleted
            return Response::json('deleteuser_success', [
                $deletedUser,
            ],Response::OK);
        }

        // cant delete user...
        return Response::json('deleteuser_error', [
        ], Response::OK);


    }

    public function getAuthenticatedUser()
    {
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return Response::json('user_not_found', []);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return Response::json('token_expired', [ $e->getStatusCode() ]);
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return Response::json('token_invalid', [ $e->getStatusCode() ]);
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return Response::json('token_absent', [ $e->getStatusCode() ]);
        }
        // the token is valid and we have found the user via the sub claim
        return $user;
    }

    protected function getCredentials(Request $request)
    {
        // return only data of the user
        return $request->only([
        	'email',
        	'password',
        	'firstname',
        	'lastname',
        	'birthday',
        	'gender',
        	'username',
        ]);
    }
}
