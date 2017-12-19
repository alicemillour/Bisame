<?php 

namespace App\Repositories;

use App\Training;
use App\Sentence;

class TrainingRepository extends GameRepository {


    public function __construct(Training $training)
	{
		$this->game = $training;
	}

        
	protected function get_sentences($user_id) 
	{
		return Sentence::join('corpora', 'corpora.id', '=', 'sentences.corpus_id')
                        ->select('sentences.*')
                        ->where('corpora.is_training', 1)
                        ->where('corpora.is_active', 0)
                        ->get();
        }
}