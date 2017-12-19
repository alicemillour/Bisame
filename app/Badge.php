<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
	public function next()
	{
		return $this->where('required_value','>',$this->required_value)
			->where('key','=',$this->key)
			->orderBy('required_value', 'asc')->first();
	}
}
