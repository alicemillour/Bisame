<?php

namespace App\Models;

use App\Models\Corpus;
use App\Models\Annotation;

use Illuminate\Database\Eloquent\Model;

class GameUser extends Model {

	protected $table = 'gameUsers';
	public $timestamps = true;

	public function game()
	{
		return $this->belongsTo('App\Models\Game');
	}

	public function user()
	{
		return $this->belongsTo('App\Models\User');
	}
}