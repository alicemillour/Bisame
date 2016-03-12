<?php 

namespace App\Repositories;

use App\Models\Corpus;

class CorpusRepository {

	protected $corpus;

	public function __construct(Corpus $corpus)
	{
		$this->corpus = $corpus;
	}

	public function getAndPaginate($n)
	{
		return $this->corpus
			->orderBy('corpus.created_at', 'desc')
			->paginate($n);
	}

}