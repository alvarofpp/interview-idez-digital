<?php

namespace Tests\Feature;

use App\Http\Resources\UserResource;
use App\User;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    /**
     * UserController@index
     *
     * @return void
     */
    public function testIndex()
    {
        $user = factory(User::class)->create();
        $token = $user->createToken(config('auth.token_key'))->accessToken;
        factory(User::class, 10)->create();

        $response = $this->getJson('/api/users', [
            'Authorization' => 'Bearer ' . $token,
        ]);
        $resource = UserResource::collection(User::paginate());

        $response->assertSuccessful()
            ->assertResource($resource);
    }

    /**
     * UserController@index
     * q = '11111111111'
     *
     * @return void
     */
    public function testIndexWithDocCpf()
    {
        $doc = '11111111111';
        $user = factory(User::class)->create([
            'cpf' => $doc,
        ]);
        $token = $user->createToken(config('auth.token_key'))->accessToken;
        factory(User::class, 10)->create();

        $response = $this->getJson('/api/users?q='.$doc, [
            'Authorization' => 'Bearer ' . $token,
        ]);
        $resource = UserResource::collection(User::searchBy($doc)->paginate());

        $response->assertSuccessful()
            ->assertResource($resource);
    }

    /**
     * UserController@show
     *
     * @return void
     */
    public function testShow()
    {
        $user = factory(User::class)->state('complete')->create();
        $token = $user->createToken(config('auth.token_key'))->accessToken;

        $response = $this->getJson('/api/users/' . $user->id, [
            'Authorization' => 'Bearer ' . $token,
        ]);
        $resource = new UserResource($user, true);

        $response->assertSuccessful()
            ->assertResource($resource);
    }

    /**
     * UserController@update
     *
     * @return void
     */
    public function testUpdate()
    {
        $user = factory(User::class)->state('complete')->create();
        $token = $user->createToken(config('auth.token_key'))->accessToken;
        $data = [
            'email' => $this->faker->unique()->safeEmail,
            'telephone' => unmaskValue($this->faker->phoneNumber),
        ];

        $response = $this->putJson('/api/users/' . $user->id, $data, [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertSuccessful()
            ->assertJson([
                'message' => trans('controllers.UserController.update.success'),
            ])->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'cpf',
                    'telephone',
                    'email',
                ],
            ]);
    }

    /**
     * UserController@destroy
     *
     * @return void
     */
    public function testDestroy()
    {
        $user = factory(User::class)->state('complete')->create();
        $token = $user->createToken(config('auth.token_key'))->accessToken;

        $response = $this->deleteJson('/api/users/' . $user->id, [], [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertSuccessful()
            ->assertJson([
                'message' => trans('controllers.UserController.destroy.success'),
            ]);
    }
}
