<?php

use Faker\Generator as Faker;

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

$factory->define(\Rockbuzz\LaraClient\Models\Client::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'email' => $faker->email,
        'phone' => $faker->phoneNumber,
        'cnpj' => $faker->numberBetween(1111111111,9999999999),
        'public_key' => strtoupper(str_random(32)),
        'secret_key' => str_random(64),
        'start_access' => now(),
        'end_access' => now()->addYear(),
        'limit_access' => $faker->numberBetween(1000, 10000),
        'active' => $faker->boolean
    ];
});