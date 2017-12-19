<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\User;
use App\Game;

class GamePolicy
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
     * @param  App\Game  $game
     * @return bool
     */

    public function update(User $user, Game $game)
    {
        return $user->id == $game->user_id;
    }

    /**
     * Determine if the given game can be seen by the user.
     *
     * @param  App\User  $user
     * @param  App\Game  $game
     * @return bool
     */

    public function show(User $user, Game $game)
    {
        return $user->id == $game->user_id;
    }
}
