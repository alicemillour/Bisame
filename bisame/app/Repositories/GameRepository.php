<?php

namespace App\Repositories;

use App\Models\Game;

class GameRepository extends ResourceRepository
{


    public function __construct(Game $game)
	{
		$this->game = $game;
	}
    private function save(Game $game, Array $inputs)
	{
		$game->user_id = $inputs['user_id'];	
		$game->save();
	}

	public function store(Array $inputs)
	{
		$game = new $this->game;		

		$this->save($game, $inputs);

		return $game;
	}

	public function update($id, Array $inputs)
	{
		$this->save($this->getById($id), $inputs);
	}

	public function destroy($id)
	{
		$this->getById($id)->delete();
	}

	public function getById($id)
	{
		return $this->game->findOrFail($id);
	}
}