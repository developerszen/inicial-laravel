<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Book;
use Faker\Generator as Faker;

$factory->define(Book::class, function (Faker $faker) {
    return [
        'user_id' => 1,
        'title' => $faker->sentence(4),
        'synopsis' => $faker->paragraph(6),
        'image' => $faker->randomElement([null, $faker->imageUrl()]),
    ];
});
