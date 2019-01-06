<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AlternativeWord extends Model
{
    protected $fillable = [
		'user_id',
		'original',
		'alternative',
	];
}
