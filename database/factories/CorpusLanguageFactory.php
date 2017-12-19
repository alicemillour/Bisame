<?php

use Faker\Generator;
use App\CorpusLanguage;

$factory->define(CorpusLanguage::class, function (Generator $faker) {
    return [
        'slug' => $faker->word
    ];
});

