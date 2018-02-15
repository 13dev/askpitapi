<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Helpers\Response;

class AuthController extends Controller
{

    public function __construct()
    {
        //apply auth middleware except login
        $this->middleware('auth:api', ['except' => ['postLogin']]);
    }

    /**
     * @param Request $request
     * @return JsonResponse|null|\Symfony\Component\HttpFoundation\Response
     */
    public function postLogin(Request $request)
    {
        Log::notice('Calling postLogin...');

        try {
            $this->validate($request, [
                'email' => 'required|email|max:100',
                'password' => 'required|max:50',
            ]);
        } catch (ValidationException $e) {
            Log::error('Validation error! ', [$e->getMessage()]);
            return $e->getResponse();
        }
        try {
            //$user = User::where('email', $request->get('email'))->first();
            // Attempt to verify the credentials and create a token for the user

            if (!$token = JWTAuth::attempt(
                $this->getCredentials($request)
            )) {
                return $this->onUnauthorized();
            }

            //JWTAuth::addClaims([ 'admin' => $user->admin ]);
        } catch (JWTException $e) {
            // Something went wrong whilst attempting to encode the token
            return $this->onJwtGenerationError();
        }
        // All good so return the token
        return $this->onAuthorized($token);
    }

    /**
     * What response should be returned on invalid credentials.
     *
     * @return JsonResponse
     */
    protected function onUnauthorized()
    {
        Log::notice('onUnauthorized Called...');

        return Response::json('invalid_credentials', [], Response::UNAUTHORIZED);
    }

    /**
     * What response should be returned on error while generate JWT.
     *
     * @return JsonResponse
     */
    protected function onJwtGenerationError()
    {
        Log::notice('onJwtGenerationError called...');

        return Response::json('could_not_create_token', [], Response::INTERNAL_SERVER_ERROR);
    }

    /**
     * What response should be returned on authorized.
     *
     * @param $token
     * @return JsonResponse
     */
    protected function onAuthorized($token)
    {
        Log::notice('onAuthorized called...');

        $payload = JWTAuth::setToken($token)->getPayload();

        return Response::json('token_generated', [
            'token' => $token,
            'expires_in' => $payload->get('exp'),
        ]);

    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    protected function getCredentials(Request $request)
    {
        return $request->only('email', 'password');
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function patchRefresh()
    {
        try {
            // try to get current token and refresh-it.
            $token = JWTAuth::parseToken();
            $newToken = $token->refresh();
            $payload = JWTAuth::setToken($newToken)->getPayload();

        }catch (JWTException $e){
            // Something went wrong whilst attempting to encode the token
            Log::error('Error refresh token', [ $e->getMessage() ]);
            return $this->onJwtGenerationError();
        }

        Log::notice('Token refreshed!');

        return Response::json('token_refreshed', [
            'token' => $newToken,
            'expires_in' => $payload->get('exp'),
        ]);

    }
}
