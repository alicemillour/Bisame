<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    const ROLE_ADMIN = 'admin';
    const ROLE_MODERATOR = 'moderator';

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = ['slug'];
}
