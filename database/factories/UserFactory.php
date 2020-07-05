<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Account;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/


$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => bcrypt('password'),
        'remember_token' => Str::random(10),
        'cpf' => $faker->cpf(false),
        'telephone' => unmaskValue($faker->phoneNumber),
    ];
});

$factory->afterCreatingState(User::class, 'complete', function ($user, $faker) {
    $user->accounts()
        ->save(
            factory(Account::class)
                ->state('person')
                ->create()
        );
    $user->accounts()
        ->save(
            factory(Account::class)
                ->state('company')
                ->create()
        );
});
