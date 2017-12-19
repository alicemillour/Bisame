<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeletionReason extends Model
{
	protected $fillable = ['slug','description'];
}
