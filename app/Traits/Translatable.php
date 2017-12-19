<?php 

namespace App\Traits;

trait Translatable
{
    public function alternative_texts($attribute=null)
    {
    	if($attribute)
        	return $this->morphMany('App\AlternativeText', 'translatable')->where('translatable_attribute',$attribute);
    	else
    		return $this->morphMany('App\AlternativeText', 'translatable');
    }
}