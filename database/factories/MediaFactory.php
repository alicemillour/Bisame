<?php

use App\Media;
use App\Post;
use Faker\Generator;

$factory->define(Media::class, function (Generator $faker) {
    return [
        'filename' => $faker->image,
        'original_filename' => 'avatar.png',
        'mime_type' => 'image/png'
    ];
});

$factory->state(Media::class, 'thumbnail', function (Generator $faker) {
    return [
        'filename' => $faker->image,
        'original_filename' => 'avatar.png',
        'mime_type' => 'image/png',
        'mediable_type' => 'App\Recipe',
        'mediable_id' => function () {
            return factory(Recipe::class)->create()->id;
        }
    ];
});
