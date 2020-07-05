<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Account;
use App\Models\AccountType;
use App\Models\Company;
use App\User;
use Faker\Generator as Faker;

$factory->define(Account::class, function (Faker $faker) {
    return [
        'bank_branch' => $faker->randomNumber(4, true),
        'number' => $faker->randomNumber(5, true),
        'digit' => $faker->randomNumber(1),
        'user_id' => User::all()->random()->id,
        'account_type_id' => AccountType::all()->random()->id,
    ];
});

$factory->state(Account::class, 'person', [
    'account_type_id' => AccountType::TYPE_PERSON,
]);

$factory->state(Account::class, 'company', [
    'account_type_id' => AccountType::TYPE_COMPANY,
]);

$factory->afterCreatingState(Account::class, 'company', function ($account, $faker) {
    $account->company()
        ->save(
            factory(Company::class)
                ->make([
                    'account_id' => $account->id,
                ])
        );
});
