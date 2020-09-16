<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Chapter;
use Faker\Generator as Faker;

$factory->define(Chapter::class, function (Faker $faker) {
    return [
        'fk_book' => 1,
        'title' => $faker->sentence(4),
        'body' => $faker->paragraph(6),
    ];
});
