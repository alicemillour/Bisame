<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;
use App\Recipe;

class RecipeTest extends DuskTestCase
{
    /**
     * test create recipe.
     * @group recipes
     * @return void
     */
    public function testCreateRecipe()
    {
        $this->browse(function (Browser $browser) {
            $user = factory(User::class)->create();
            $recipe = factory(Recipe::class)->create();
            $browser->loginAs($user)
                    ->visit('/recipes/create')
                    ->pause(5000)
                    ->keys('#title',$recipe->title)
                    ->keys('#content',$recipe->content)
                    ->press('#btn-create');
        });
    }
}
