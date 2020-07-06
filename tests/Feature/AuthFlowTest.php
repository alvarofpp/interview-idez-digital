<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;

class AuthFlowTest extends TestCase
{
    private $user = [
        'name' => 'Sr Test',
        'telephone' => '12345-6789',
        'cpf' => '125.578.147-50',
        'email' => 'test@gmail.com',
        'password' => 'test@123',
        'token' => null,
    ];

    /**
     * Auth\RegisterController@register
     *
     * @return void
     */
    public function testRegister()
    {
        $response = $this->post('/api/auth/register', [
            'name' => $this->user['name'],
            'telephone' => $this->user['telephone'],
            'cpf' => $this->user['cpf'],
            'email' => $this->user['email'],
            'password' => $this->user['password'],
            'password_confirmation' => $this->user['password'],
        ]);

        $response->assertSuccessful()
            ->assertJson([
                'message' => trans('controllers.RegisterController.register.success'),
            ])->assertJsonStructure([
                'data' => [
                    'access_token',
                    'user' => [
                        'id',
                        'name',
                        'email',
                        'cpf',
                        'telephone',
                        'created_at',
                        'updated_at',
                    ],
                ],
            ]);
        $this->assertDatabaseHas('users', [
            'email' => $this->user['email'],
        ]);
    }

    /**
     * @depends testRegister
     * Auth\AuthController@login
     *
     * @return void
     */
    public function testLogin()
    {
        $user = factory(User::class)->create([
            'name' => $this->user['name'],
            'telephone' => $this->user['telephone'],
            'cpf' => $this->user['cpf'],
            'email' => $this->user['email'],
            'password' => bcrypt($this->user['password']),
        ]);

        $response = $this->postJson('/api/auth/login', [
            'email' => $this->user['email'],
            'password' => $this->user['password'],
        ]);

        $response->assertSuccessful()
            ->assertJsonStructure([
                'data' => [
                    'token' => [
                        'access',
                        'expires',
                    ],
                    'user' => [
                        'id',
                        'name',
                        'email',
                        'cpf',
                        'telephone',
                        'created_at',
                        'updated_at',
                    ],
                ],
            ]);
        $this->assertAuthenticatedAs($user);
    }

    /**
     * @depends testLogin
     * Auth\AuthController@logout
     *
     * @return void
     */
    public function testLogout()
    {
        $user = factory(User::class)->create([
            'name' => $this->user['name'],
            'telephone' => $this->user['telephone'],
            'cpf' => $this->user['cpf'],
            'email' => $this->user['email'],
            'password' => bcrypt($this->user['password']),
        ]);

        $token = $user->createToken(config('auth.token_key'))->accessToken;
        $response = $this->getJson('/api/auth/logout', [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertSuccessful()
            ->assertJson([
                'message' => trans('controllers.AuthController.logout.success'),
            ]);
    }

    /**
     * Auth\AuthController@logout
     *
     * @return void
     */
    public function testLogoutWithoutSession()
    {
        $response = $this->getJson('/api/auth/logout', [
            'Authorization' => 'Bearer ' . '1234567890',
        ]);

        $response->assertUnauthorized()
            ->assertJson([
                'message' => trans('controllers.AuthController.logout.error'),
            ]);
    }
}
