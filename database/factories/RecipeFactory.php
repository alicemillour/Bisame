<?php

use Faker\Generator;
use App\Recipe;
use App\User;
use App\CorpusLanguage;
use Carbon\Carbon;

$factory->define(Recipe::class, function (Generator $faker) {
    return [
        'title' => $faker->sentence,
        'content' => $faker->paragraph,
        'commentary' => $faker->paragraph,
        'preparation_time_hour' => $faker->numberBetween(0, 2),
        'preparation_time_minute' => $faker->numberBetween(5, 55),
        'cooking_time_hour' => $faker->numberBetween(0, 2),
        'cooking_time_minute' => $faker->numberBetween(10, 50),
        'servings' => $faker->numberBetween(2, 8),
        'created_at' => Carbon::now(),
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
        'corpus_language_id' => function () {
            return factory(CorpusLanguage::class)->create()->id;
        }
    ];
});