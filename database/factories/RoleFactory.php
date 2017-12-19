<?php

use Faker\Generator;
use App\Role;

$factory->define(Role::class, function (Generator $faker) {
    return [
        'slug' => $faker->word
    ];
});

$factory->state(Role::class, 'admin', function ($faker) {
    return [
        'slug' => 'admin'
    ];
});

$factory->state(Role::class, 'moderator', function ($faker) {
    return [
        'slug' => 'moderator'
    ];
});
