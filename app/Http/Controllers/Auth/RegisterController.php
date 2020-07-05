<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Register\RegisterRequest;
use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Handle a registration request for the application.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        $data = $request->all();

        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'cpf' => $data['cpf'],
                'telephone' => $data['telephone'],
                'password' => Hash::make($data['password']),
            ]);

            event(new Registered($user));
            Auth::guard()->login($user);
            $token = $user->createToken(config('auth.token_key'))->accessToken;

            DB::commit();
            return $this->responseSuccess([
                'message' => trans('controllers.RegisterController.register.success'),
                'data' => [
                    'access_token' => $token,
                    'user' => $user,
                ],
            ], 201);
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->responseErrorServer([
                'message' => trans('controllers.RegisterController.register.error'),
                'exception' => $exception->getMessage(),
            ]);
        }
    }
}
