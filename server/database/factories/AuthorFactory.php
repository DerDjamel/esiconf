<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Author;
use Faker\Generator as Faker;

$factory->define(Author::class, function (Faker $faker) {
    return [
        'user_id'   => factory('App\User')->create()->id,
        'paper_id'  => factory('App\Paper')->create()->id
    ];
});
