<?php

namespace App\Repositories;

use App\Models\Sentence;

class SentenceRepository extends ResourceRepository
{

    //protected $user;

    public function __construct(Sentence $sentence)
	{
		$this->sentence = $sentence;
	}

	public function all()
	{
		return $this->sentence->all();
	}

}