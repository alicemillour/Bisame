<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Corpus extends Model {

	protected $table = 'corpora';
	public $timestamps = true;

	public function sentences()
	{
		return $this->hasMany('App\Sentence');
	}

}