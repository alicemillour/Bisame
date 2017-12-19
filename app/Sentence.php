<?php

namespace App;

use App\Corpus;
use App\Annotation;

use Illuminate\Database\Eloquent\Model;

class Sentence extends Model {

	protected $table = 'sentences';
	public $timestamps = true;

	public function corpus()
	{
		return $this->belongsTo('App\Corpus');
	}

	public function words()
	{
		return $this->hasMany('App\Word');
	}

    public function games()
    {
        return $this->belongsToMany('App\Game');
    }

    public function is_training()
    {
    	return $this->corpus->is_training;
    }
}