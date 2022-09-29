<?php

use Faker\Generator as Faker;

$factory->define(App\Task::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence,
        'due_date' => $faker->date,
        'is_completed' => $faker->boolean,
    ];
});
