<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Reviewer;
use Faker\Generator as Faker;

$factory->define(Reviewer::class, function (Faker $faker) {
    return [
        'conference_id' => factory('App\Conference')->create()->id,
        'user_id'       => factory('App\User')->create()->id
    ];
});
