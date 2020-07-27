<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Carbon\Carbon;
use App\Conference;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Conference::class, function (Faker $faker) {
    $now = new Carbon();
    $copy = $now->copy()->addDays(5);
    $name = $faker->sentence;
    $slug = Str::slug($name);
    $count = Conference::where('slug', 'like', '%' . $slug . '%')->count();
    return [
        'name'          => $name,
        'slug'          => $count >= 1 ? $slug . '-' . ($count + 1) : $slug,
        'country'       => $faker->country,
        'city'          => $faker->city,
        'description'   => $faker->text,
        'start'         => $now,
        'end'           => $now->copy()->addDays(30),
        'webpage'       => $faker->url,
        'user_id'       => factory('App\User')->create()->id
    ];
});
