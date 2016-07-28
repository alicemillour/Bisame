<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Training extends Game
{
    protected static $singleTableType = 'training';        
    
        
    public function get_single_table_type()
    {
        return self::$singleTableType;
    }
    public function sentences()
    {
        return $this->belongsToMany('App\Models\Sentence', 'game_sentence', 'game_id');
    }
}