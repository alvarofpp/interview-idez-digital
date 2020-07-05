<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Account;
use App\Models\Company;
use Faker\Generator as Faker;

$factory->define(Company::class, function (Faker $faker) {
    $companyName = $faker->company;
    return [
        'cnpj' => $faker->cnpj(false),
        'company_name' => $companyName,
        'trading_name' => $companyName . ' ' . $faker->companySuffix,
        'account_id' => Account::all()->random()->id,
    ];
});
