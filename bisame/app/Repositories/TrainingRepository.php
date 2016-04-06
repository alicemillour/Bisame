<?php 

namespace App\Repositories;

use App\Models\Training;
use App\Models\Sentence;

class TrainingRepository extends GameRepository {


    public function __construct(Training $training)
	{
		$this->game = $training;
	}


	# override function store
}