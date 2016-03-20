<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $table = 'games';
    public $timestamps = true;

    public function sentences()
    {
        return $this->belongsToMany('App\Models\Sentence');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
