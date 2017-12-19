<?php

use Faker\Generator;
use App\Ingredient;
use App\Recipe;

$factory->define(Ingredient::class, function (Generator $faker) {
    return [
        'name' => $faker->word,
        'quantity' => $faker->word,
        'recipe_id' => function () {
            return factory(Recipe::class)->create()->id;
        }
    ];
});