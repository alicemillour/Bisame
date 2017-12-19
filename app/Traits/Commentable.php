<?php 

namespace App\Traits;

trait Commentable
{
    public function discussion()
    {
    	return $this->morphOne('App\Discussion', 'entity');
    }

    /**
     * Check if the resource has a media
     *
     * @param integer $media_id
     * @return boolean
     */
    public function hasDiscussion(): bool
    {
        return $this->discussion()->exists();
    }

}