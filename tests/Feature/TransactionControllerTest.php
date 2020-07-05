<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\AccountType;
use App\Models\TransactionType;
use App\User;
use Tests\TestCase;

class TransactionControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testStore()
    {
        $users = factory(User::class, 10)
            ->state('complete')
            ->create();
        $token = $users->shuffle()
            ->shift()
            ->createToken(config('auth.token_key'))->accessToken;
        $accounts = Account::all();
        $accountId = $accounts->random()->first()->user_id;
        $data = [
            'value' => $this->faker->randomFloat(2, -100, 100),
            'number' => $this->faker->randomNumber(5, true),
            'account_to_id' => $accounts->random()->first()->user_id,
            'transaction_type_id' => TransactionType::all()->first()->id,
        ];

        $response = $this->postJson('/api/accounts/' . $accountId . '/transactions', $data, [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertSuccessful()
            ->assertJson([
                'message' => trans('controllers.TransactionController.store.success'),
            ])->assertJsonStructure([
                'data' => [
                    'id',
                    'value',
                    'created_at',
                    'transaction_type' => [
                        'id',
                        'name',
                    ],
                    'from' => [
                        'account' => [
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
                        'user' => [
                            'id',
                            'name',
                            'cpf',
                            'telephone',
                            'email',
                        ],
                    ],
                    'to' => [
                        'account' => [
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
                        'user' => [
                            'id',
                            'name',
                            'cpf',
                            'telephone',
                            'email',
                        ],
                    ],
                ],
            ]);
        $this->assertDatabaseHas('transactions', [
            'id' => $response['data']['id'],
        ]);
    }
}
