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
     * TransactionController@store
     *
     * @return void
     */
    public function testStore()
    {
        // Users
        $users = factory(User::class, 10)
            ->state('complete')
            ->create();
        $user = $users->shuffle()
            ->shift();
        $token = $user->createToken(config('auth.token_key'))->accessToken;
        // Accounts
        $userAccounts = $user->accounts;
        $accountId = $userAccounts->random()->id;
        $accounts = Account::all();
        // Transactions
        $data = [
            'value' => $this->faker->randomFloat(2, -100, 100),
            'account_to_id' => $accounts->random()
                ->id,
            'transaction_type_id' => TransactionType::all()
                ->shuffle()
                ->first()
                ->id,
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
                    'account_from' => [
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
                        'user' => [
                            'id',
                            'name',
                            'cpf',
                            'telephone',
                            'email',
                        ],
                    ],
                    'account_to' => [
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
