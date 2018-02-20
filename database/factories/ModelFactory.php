<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'username' => $faker->userName,
        'email' => $faker->email,
        'password' => 'secret',
        'firstname' => $faker->firstName,
        'lastname' => $faker->lastName,
        'birthday' => $faker->dateTimeThisCentury->format('Y-m-d'),
        'cover' => $faker->imageUrl(),
        'avatar' => $faker->imageUrl(),
        'gender' => $faker->boolean,
        'admin' => $faker->boolean,
    ];
});
