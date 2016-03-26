<?php

namespace App\Repositories;

use App\Models\Postag;

class PostagRepository extends ResourceRepository
{

    //protected $user;

    public function __construct(Postag $postag)
	{
		$this->postag = $postag;
	}

	public function all()
	{
		return $this->postag->all();
	}

}