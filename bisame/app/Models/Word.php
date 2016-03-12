<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'value',
    ];

	protected $table = 'word';
	public $timestamps = true;

	public function sentence()
	{
		return $this->belongsTo('App\Models\Sentence');
	}
}
