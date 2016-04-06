<?php

namespace App\Repositories;

use App\Models\Game;
use App\Models\Sentence;

class GameRepository extends ResourceRepository
{

    public function __construct(Game $game)
	{
		$this->game = $game;
	}
    private function save(Game $game, Array $inputs)
	{
		$game->user_id = $inputs['user_id'];
		$game->sentence_index = $inputs['sentence_index'];
		$game->save();
	}

	public function store(Array $inputs)
	{
		$game = new $this->game;
		$sentences = $this->get_sentences()->take(4);
		$this->save($game, $inputs);
		$game->sentences()->attach($sentences);
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

	public function getWithUserId($user_id)
	{
		return $this->game->where('user_id', $user_id)->where('is_finished', 0);
	}

	protected function get_sentences() 
	{
		return Sentence::all()->where('is_training', 0);
	}
}