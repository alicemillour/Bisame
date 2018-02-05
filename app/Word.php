<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'value','sentence_id'
    ];

	protected $table = 'words';
	public $timestamps = true;

	public function sentence()
	{
		return $this->belongsTo('App\Sentence');
	}

	public function annotation_melt()
	{
		return $this->hasOne('App\Annotation')->where('tagger','MElt');
	}

	public function annotation_training()
	{
		return $this->hasOne('App\Annotation')->where('tagger','training');
	}

	public function annotation_solution()
	{
		return $this->hasOne('App\Annotation')->where('tagger','solution');
	}
	public function annotation_user($user_id)
	{
		return $this->hasOne('App\Annotation')->where('user_id',$user_id)->first();
	}
}
