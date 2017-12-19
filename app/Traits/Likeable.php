<?php 

namespace App\Traits;

trait Likeable
{
    public function likes()
    {
  		return $this->morphMany('App\Like', 'likeable');
    }
}