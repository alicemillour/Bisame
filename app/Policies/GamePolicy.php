<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;
use App\Models\Game;

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
     * @param  App\Models\User  $user
     * @param  App\Models\Game  $game
     * @return bool
     */

    public function update(User $user, Game $game)
    {
        return $user->id === $game->user_id;
    }

    /**
     * Determine if the given game can be seen by the user.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Game  $game
     * @return bool
     */

    public function show(User $user, Game $game)
    {
        return $user->id === $game->user_id;
    }
}
