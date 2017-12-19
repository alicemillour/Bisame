<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Nanigans\SingleTableInheritance\SingleTableInheritanceTrait;

class Game extends Model
{
    use SingleTableInheritanceTrait;
    protected $table = 'games';
    public $timestamps = true;
    protected static $singleTableTypeField = 'type';
    protected static $singleTableType = 'game';

    protected static $singleTableSubclasses = [Training::class];

     public function get_single_table_type()
    {
        return self::$singleTableType;
    }
    
    
    public function sentences()
    {
        return $this->belongsToMany('App\Sentence');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
