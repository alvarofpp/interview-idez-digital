<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\LogoutRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Login to the application.
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $loginData = [
            'email' => $request->get('email'),
            'password' => $request->get('password'),
        ];

        if (Auth::attempt($loginData)) {
            $user = Auth::user();
            $personalAccessToken = $user->createToken(config('auth.token_key'));

            return $this->responseData([
                'token' => [
                    'access' => $personalAccessToken->accessToken,
                    'expires' => $personalAccessToken->token->expires_at->format('Y-m-d H:i:s'),
                ],
                'user' => $user,
            ]);
        }

        return $this->responseError([
            'message' => trans('controllers.AuthController.login.error'),
            'errors' => [],
        ], 401);
    }

    /**
     * Application logout.
     *
     * @param LogoutRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(LogoutRequest $request)
    {
        $user = $request->user('api');
        if (is_null($user)) {
            return $this->responseError([
                'message' => trans('controllers.AuthController.logout.error'),
            ], 401);
        }

        $user->token()
            ->revoke();

        return $this->responseSuccess([
            'message' => trans('controllers.AuthController.logout.success'),
        ]);
    }
}
