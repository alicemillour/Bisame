<?php 

namespace App\Traits;

trait Mediable
{
    public function medias()
    {
  		return $this->morphMany('App\Media', 'mediable');
    }
}