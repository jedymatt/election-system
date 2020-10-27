<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

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
        'local_id' => $faker->randomNumber(6),
        'lastname' => $faker->lastName,
        'firstname' => $faker->firstName,
        'role'=> 'student',
        'password' => \Illuminate\Support\Facades\Hash::make('12345678'), // password
    ];
});
