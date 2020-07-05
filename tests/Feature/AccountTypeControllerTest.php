<?php

namespace Tests\Feature;

use App\Http\Resources\AccountTypeResource;
use App\Models\AccountType;
use App\User;
use Tests\TestCase;

class AccountTypeControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testIndex()
    {
        $user = factory(User::class)->create();
        $token = $user->createToken(config('auth.token_key'))->accessToken;

        $response = $this->getJson('/api/account_types', [
            'Authorization' => 'Bearer ' . $token,
        ]);
        $resource = AccountTypeResource::collection(AccountType::all());

        $response->assertSuccessful()
            ->assertResource($resource);
    }
}
