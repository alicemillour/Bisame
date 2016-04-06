<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Training extends Game
{
	protected static $singleTableType = 'training';

    public function sentences()
    {
        return $this->belongsToMany('App\Models\Sentence', 'game_sentence', 'game_id');
    }
}