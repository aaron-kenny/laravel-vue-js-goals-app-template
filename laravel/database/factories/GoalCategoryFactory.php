<?php

use Faker\Generator as Faker;

$factory->define(App\GoalCategory::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
    ];
});