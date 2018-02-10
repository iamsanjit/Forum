<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a c``onvenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
    ];
});


$factory->define(App\Thread::class, function (Faker $faker) {
    return [
        'user_id' => factory(App\User::class)->create()->id,
        'channel_id' => factory(App\Channel::class)->create()->id,
        'title' => $faker->sentence(),
        'body' => $faker->paragraph(),
    ];
});


$factory->define(App\Reply::class, function (Faker $faker) {
    return [
        'user_id' => factory(App\User::class)->create()->id,
        'thread_id' => factory(App\User::class)->create()->id,
        'body' => $faker->paragraph(),
    ];
});


$factory->define(App\Channel::class, function (Faker $faker) {
    return [
        'name' => $faker->word(),
        'slug' => $faker->word(),
    ];
});
