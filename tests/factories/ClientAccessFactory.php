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

$factory->define(\Rockbuzz\LaraClient\Models\ClientAccess::class, function (Faker $faker) {
    return [
        'ip' => $faker->ipv4,
        'host' => $faker->url,
        'client_id' => function () {
            return factory(\Rockbuzz\LaraClient\Models\Client::class)->create();
        },
        'created_at' => now()
    ];
});