<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discussion extends Model
{

	protected $fillable = ['entity_type','entity_id'];

    /**
     * Get the entity of the discussion.
     */
    public function entity()
    {
        return $this->morphTo();
    }
    /**
     * Get the messages for the discussion.
     */
    public function messages()
    {
        return $this->hasMany('App\Message');
    }

    public function subscribers()
    {
        return $this->belongsToMany('App\User');
    }    
}
