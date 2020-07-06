<?php

namespace Tests\Feature;

use App\Http\Resources\TransactionTypeResource;
use App\Models\TransactionType;
use App\User;
use Tests\TestCase;

class TransactionTypeControllerTest extends TestCase
{
    /**
     * TransactionTypeController@index
     *
     * @return void
     */
    public function testIndex()
    {
        $user = factory(User::class)->create();
        $token = $user->createToken(config('auth.token_key'))->accessToken;

        $response = $this->getJson('/api/transaction_types', [
            'Authorization' => 'Bearer ' . $token,
        ]);
        $resource = TransactionTypeResource::collection(TransactionType::all());

        $response->assertSuccessful()
            ->assertResource($resource);
    }
}
