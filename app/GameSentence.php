<?php

namespace App;

use App\Corpus;
use App\Annotation;

use Illuminate\Database\Eloquent\Model;

class GameSentence extends Model {

	protected $table = 'game_sentence';
	public $timestamps = true;

	public function game()
	{
		return $this->belongsTo('App\Game');
	}

	public function sentence()
	{
		return $this->belongsTo('App\Sentence');
	}
}