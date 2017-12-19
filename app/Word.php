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
}
