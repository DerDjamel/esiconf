<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Paper;
use Faker\Generator as Faker;

$factory->define(Paper::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'abstract' => $faker->text,
        'comment' => $faker->text,
        'path'      => 'thisis a path to a file',
        'conference_id' => factory('App\Conference')->create()->id,
    ];
});
