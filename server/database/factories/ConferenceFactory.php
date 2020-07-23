<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Carbon\Carbon;
use App\Conference;
use Faker\Generator as Faker;

$factory->define(Conference::class, function (Faker $faker) {
    $now = new Carbon();
    $copy = $now->copy()->addDays(5);
    return [
        "name"          => $faker->sentence,
        'country'       => $faker->country,
        'city'          => $faker->city,
        'description'   => $faker->text,
        'start'         => $now,
        'end'           => $now->copy()->addDays(30),
        'webpage'       => $faker->url,
        'user_id'       => factory('App\User')->create()->id
    ];
});
