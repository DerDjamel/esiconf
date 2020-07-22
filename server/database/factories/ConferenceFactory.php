<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Conference;
use Faker\Generator as Faker;

$factory->define(Conference::class, function (Faker $faker) {
    return [
        "name"      => $faker->sentence,
        'user_id'   => factory('App\User')->create()->id
    ];
});
