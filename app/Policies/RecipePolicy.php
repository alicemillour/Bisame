<?php

namespace App\Policies;

use App\User;
use App\Recipe;
use Illuminate\Auth\Access\HandlesAuthorization;

class RecipePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user is admin for all authorization.
     */
    public function before(User $user)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }

    /**
     * Determine whether the user can update the recipe.
     *
     * @param  User $user
     * @param  Recipe $recipe
     * @return bool
     */
    public function update(User $user, Recipe $recipe): bool
    {
        return $user->isAdmin() || $user->id==$recipe->user_id;
    }

    /**
     * Determine whether the user can store a recipe.
     *
     * @param  User $user
     * @return bool
     */
    public function store(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the recipe.
     *
     * @param  \App\User  $user
     * @param  \App\Recipe  $recipe
     * @return mixed
     */
    public function delete(User $user, Recipe $recipe)
    {
        return $user->isAdmin();
    }
}
