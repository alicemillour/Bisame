<?php

namespace App\Models;

use App\Models\Corpus;
use App\Models\Annotation;

use Illuminate\Database\Eloquent\Model;

class Sentence extends Model {

	protected $table = 'sentences';
	public $timestamps = true;

	public function corpus()
	{
		return $this->belongsTo('App\Models\Corpus');
	}

	public function words()
	{
		return $this->hasMany('App\Models\Word');
	}

    public function games()
    {
        return $this->belongsToMany('App\Models\Game');
    }

    public function is_training()
    {
    	return $this->corpus->is_training;
    }
}