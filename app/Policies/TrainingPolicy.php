<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\User;
use App\Training;

class TrainingPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }


    /**
     * Determine if the given game can be updated by the user.
     *
     * @param  App\User  $user
     * @param  App\Training  $game
     * @return bool
     */

    public function update(User $user, Training $game)
    {
        return $user->id == $game->user_id;
    }

    /**
     * Determine if the given game can be seen by the user.
     *
     * @param  App\User  $user
     * @param  App\Training  $game
     * @return bool
     */

    public function show(User $user, Training $game)
    {
        return $user->id == $game->user_id;
    }
}
