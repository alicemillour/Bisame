<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    /**
     * The users that belong to the notification.
     */
    public function users()
    {
        return $this->belongsToMany('App\User');
    }
}
