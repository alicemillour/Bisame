<?php

use Illuminate\Database\Seeder;
use App\Recipe;
use App\User;
use App\Ingredient;
// use App\NewsletterSubscription;
use Faker\Factory;

class DevDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        factory(User::class, 10)
            ->create()
            ->each(function ($user) use ($faker) {
                factory(Recipe::class, $faker->numberBetween(2, 20))
                    ->create([
                        'user_id' => $user->id
                    ])
                    ->each(function ($recipe) use ($faker) {
                        factory(Ingredient::class, $faker->numberBetween(3, 9))
                            ->create([
                                'recipe_id' => $recipe->id
                            ]);
                    });
            });

        // factory(NewsletterSubscription::class, $faker->numberBetween(10, 50))->create();
    }
}
