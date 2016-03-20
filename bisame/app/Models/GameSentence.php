<?php

namespace App\Models;

use App\Models\Corpus;
use App\Models\Annotation;

use Illuminate\Database\Eloquent\Model;

class GameSentence extends Model {

	protected $table = 'game_sentence';
	public $timestamps = true;

	public function game()
	{
		return $this->belongsTo('App\Models\Game');
	}

	public function sentence()
	{
		return $this->belongsTo('App\Models\Sentence');
	}
}