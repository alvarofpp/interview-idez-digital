<?php

namespace Tests\Feature;

use App\Http\Resources\AccountResource;
use App\Models\AccountType;
use App\User;
use Tests\TestCase;

class AccountControllerTest extends TestCase
{
    /**
     * AccountController@store
     *
     * @return void
     */
    public function testStorePerson()
    {
        $user = factory(User::class)->create();
        $token = $user->createToken(config('auth.token_key'))->accessToken;
        $data = [
            'bank_branch' => $this->faker->randomNumber(4, true),
            'number' => $this->faker->randomNumber(5, true),
            'digit' => (string)$this->faker->randomNumber(1),
            'user_id' => $user->id,
            'account_type_id' => AccountType::TYPE_PERSON,
        ];

        $response = $this->postJson('/api/accounts', $data, [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertSuccessful()
            ->assertJson([
                'message' => trans('controllers.AccountController.store.success'),
            ])->assertJsonStructure([
                'data' => [
                    'id',
                    'bank_branch',
                    'number',
                    'digit',
                    'account_type' => [
                        'id',
                        'slug',
                        'name',
                        'description',
                    ],
                ],
            ]);
        $this->assertDatabaseHas('accounts', [
            'account_type_id' => AccountType::TYPE_PERSON,
            'user_id' => $user->id,
        ]);
    }

    /**
     * AccountController@store
     *
     * @return void
     */
    public function testStoreCompany()
    {
        $user = factory(User::class)->create();
        $token = $user->createToken(config('auth.token_key'))->accessToken;
        $company = $this->faker->company;
        $data = [
            'bank_branch' => $this->faker->randomNumber(4, true),
            'number' => $this->faker->randomNumber(5, true),
            'digit' => (string)$this->faker->randomNumber(1, true),
            'user_id' => $user->id,
            'account_type_id' => AccountType::TYPE_COMPANY,
            'cnpj' => $this->faker->cnpj(false),
            'company_name' => $company,
            'trading_name' => $company . ' ' . $this->faker->companySuffix,
        ];

        $response = $this->postJson('/api/accounts', $data, [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertSuccessful()
            ->assertJson([
                'message' => trans('controllers.AccountController.store.success'),
            ])->assertJsonStructure([
                'data' => [
                    'id',
                    'bank_branch',
                    'number',
                    'digit',
                    'account_type' => [
                        'id',
                        'slug',
                        'name',
                        'description',
                    ],
                    'company' => [
                        'cnpj',
                        'company_name',
                        'trading_name',
                    ],
                ],
            ]);
        $this->assertDatabaseHas('accounts', [
            'account_type_id' => AccountType::TYPE_COMPANY,
            'user_id' => $user->id,
        ])->assertDatabaseHas('companies', [
            'account_id' => $response['data']['id'],
        ]);
    }

    /**
     * AccountController@show
     *
     * @return void
     */
    public function testShowPerson()
    {
        $user = factory(User::class)
            ->state('complete')
            ->create();
        $token = $user->createToken(config('auth.token_key'))->accessToken;
        $user->load('accounts');
        $account = $user->accounts
            ->where('account_type_id', AccountType::TYPE_PERSON)
            ->first();

        $response = $this->getJson('/api/accounts/' . $account->id, [
            'Authorization' => 'Bearer ' . $token,
        ]);
        $resource = new AccountResource($account, true);

        $response->assertSuccessful()
            ->assertResource($resource);
    }

    /**
     * AccountController@show
     *
     * @return void
     */
    public function testShowCompany()
    {
        $user = factory(User::class)
            ->state('complete')
            ->create();
        $token = $user->createToken(config('auth.token_key'))->accessToken;
        $user->load('accounts');
        $account = $user->accounts
            ->where('account_type_id', AccountType::TYPE_COMPANY)
            ->first();

        $response = $this->getJson('/api/accounts/' . $account->id, [
            'Authorization' => 'Bearer ' . $token,
        ]);
        $resource = new AccountResource($account, true);

        $response->assertSuccessful()
            ->assertResource($resource);
    }

    /**
     * AccountController@update
     *
     * @return void
     */
    public function testUpdatePerson()
    {
        $user = factory(User::class)
            ->state('complete')
            ->create();
        $token = $user->createToken(config('auth.token_key'))->accessToken;
        $user->load('accounts');
        $account = $user->accounts
            ->where('account_type_id', AccountType::TYPE_PERSON)
            ->first();
        $data = [
            'bank_branch' => $this->faker->randomNumber(4, true),
            'number' => $this->faker->randomNumber(5, true),
        ];

        $response = $this->putJson('/api/accounts/' . $account->id, $data, [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertSuccessful()
            ->assertJson([
                'message' => trans('controllers.AccountController.update.success'),
            ])->assertJsonStructure([
                'data' => [
                    'id',
                    'bank_branch',
                    'number',
                    'digit',
                    'account_type' => [
                        'id',
                        'slug',
                        'name',
                        'description',
                    ],
                ],
            ]);
    }

    /**
     * AccountController@update
     *
     * @return void
     */
    public function testUpdateCompany()
    {
        $user = factory(User::class)
            ->state('complete')
            ->create();
        $token = $user->createToken(config('auth.token_key'))->accessToken;
        $user->load('accounts');
        $account = $user->accounts
            ->where('account_type_id', AccountType::TYPE_COMPANY)
            ->first();
        $company = $this->faker->company;
        $data = [
            'company_name' => $company,
            'trading_name' => $company . ' ' . $this->faker->companySuffix,
        ];

        $response = $this->putJson('/api/accounts/' . $account->id, $data, [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertSuccessful()
            ->assertJson([
                'message' => trans('controllers.AccountController.update.success'),
            ])->assertJsonStructure([
                'data' => [
                    'id',
                    'bank_branch',
                    'number',
                    'digit',
                    'account_type' => [
                        'id',
                        'slug',
                        'name',
                        'description',
                    ],
                    'company' => [
                        'cnpj',
                        'company_name',
                        'trading_name',
                    ],
                ],
            ]);
    }

    /**
     * AccountController@destroy
     *
     * @return void
     */
    public function testDestroy()
    {
        $user = factory(User::class)
            ->state('complete')
            ->create();
        $token = $user->createToken(config('auth.token_key'))->accessToken;
        $user->load('accounts');

        foreach (AccountType::TYPES as $type) {
            $account = $user->accounts
                ->where('account_type_id', $type)
                ->first();

            $response = $this->deleteJson('/api/accounts/' . $account->id, [], [
                'Authorization' => 'Bearer ' . $token,
            ]);

            $response->assertSuccessful()
                ->assertJson([
                    'message' => trans('controllers.AccountController.destroy.success'),
                ]);
        }
    }
}
